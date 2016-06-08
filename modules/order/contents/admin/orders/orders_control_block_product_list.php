<?php
class orders_control_block_product_list extends Engine_Class {

    public function process() {
        try {
            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            // текущий авторизированный пользователь
            $user = $this->getUser();

            $canEdit = $this->getValue('canEdit');
            if (!$canEdit) {
                $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            }
            $this->setValue('canEdit', $canEdit);

            // когда нажата кнопка Сохранить
            if ($canEdit && $this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    $event = Events::Get()->generateEvent('shopOrderEditBefore');
                    $event->setOrder($order);
                    $event->notify();

                    // добавляем товар в заказ
                    $this->_addOrderProduct($order);

                    // удаляем отмеченные товары из заказа
                    // обновляем цены и содержимое заказа
                    $orderproducts = $order->getOrderProducts();
                    while ($op = $orderproducts->getNext()) {

                        // удаление orderproduct'a
                        if ($this->_deleteOrderProduct($op)) {
                            // дальше продолжать не нужно
                            continue;
                        }

                        // обновляем данные заказа
                        $this->_updateOrderProduct($op);
                    }

                    // обновляем скидку
                    try {
                        $discount = Shop::Get()->getShopService()->getDiscountByID(
                            $this->getControlValue('discount')
                        );
                        $order->setDiscountid($discount->getId());
                    } catch (Exception $e) {
                        $order->setDiscountid(0);
                    }

                    try {
                        $newCurrency = Shop::Get()->getCurrencyService()->getCurrencyByID(
                            $this->getArgument('ordercurrencyid')
                        );

                        $order->setCurrencyid($newCurrency->getId());
                        $order->update();
                    } catch (Exception $currencyEx) {

                    }

                    // считаем все суммы заказа
                    Shop::Get()->getShopService()->recalculateOrderSums($order);

                    // обновляем заказ
                    $order->update();

                    if ($order->getOutcoming() && ($order->getSum() > 0)) {
                        $order->setSum($order->getSum()*(-1));
                        $order->update();
                    }

                    $event = Events::Get()->generateEvent('shopOrderEditAfter');
                    $event->setOrder($order);
                    $event->notify();

                    SQLObject::TransactionCommit();

                    if (Engine::GetURLParser()->getArgumentSecure('message') != 'error') {
                        Engine::GetURLParser()->setArgument('message', 'ok');
                    }

                } catch (ServiceUtils_Exception $te) {
                    SQLObject::TransactionRollback();

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $te;
                    }

                    Engine::GetURLParser()->setArgument('message', 'error');

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $te->getErrorsArray());

                    $this->setValue(
                        'errorText',
                        implode(
                            '<br />',
                            Shop_ContentErrorHandler::Get()->getErrorValueArray($te)
                        )
                    );
                }
            }

            // получаем все товары в заказе
            $orderproducts = $order->getOrderProducts();

            $a = array();
            $storageSum = 0;
            $serviceSum = 0; // сумма услуг
            $allSum = 0; // считаем суммы по наборам
            $countProductAll = 0;
            $orderLinked = true;
            $clientId = false;
            try {
                $clientId = $order->getUserid();
            } catch (Exception $e) {

            }

            while ($x = $orderproducts->getNext()) {
                // информация о наличии в поставщиках
                $supplierArray = array();
                $priceBase = 0;

                try {
                    // productid может быть не действительный,
                    // поэтому заключаем в try-catch

                    $product = $x->getProduct();


                    $productSuppliers = Shop::Get()->getSupplierService()->getProductSupplierFromProduct($product);
                    while ($p = $productSuppliers->getNext()) { 
                        $supplierID = $p->getSupplierid();
                        if (!$supplierID) {
                            continue;
                        }

                        $supplierAvail = $p->getAvail();
                        if (!$supplierAvail) {
                            continue;
                        }

                        $supplierCode = $p->getCode();
                        $supplierPrice = $p->getPrice();
                        $supplierCurrencyID = $p->getCurrencyid();
                        $supplierAvailtext = $p->getAvailtext();

                        try {
                            $supplier = Shop::Get()->getShopService()->getSupplierByID(
                                $supplierID
                            );

                            if ($supplier->getHidden()) {
                                continue;
                            }

                            $supplierName = $supplier->getName();
                            $supplierColor = $supplier->getColor();
                            $deliveryTime = $supplier->getDeliverytime();
                        } catch (Exception $supplierEx) {
                            continue;
                        }

                        try {
                            $supplierCurrencyName = Shop::Get()->getCurrencyService()->getCurrencyByID(
                                $supplierCurrencyID
                            )->getName();
                        } catch (Exception $supplierEx) {
                            $supplierCurrencyName = false;
                        }

                        try {
                            $supplierWorkflow = Shop::Get()->getShopService()->getSupplierByID(
                                $supplierID
                            )->getWorkflowid();
                        } catch (Exception $supplierEx) {
                            $supplierWorkflow = 0;
                        }

                        try {
                            $supplierContactId = Shop::Get()->getShopService()->getSupplierByID(
                                $supplierID
                            )->getContactid();
                        } catch (Exception $supplierEx) {
                            $supplierContactId = 0;
                        }

                        $supplierArray[] = array(
                            'id' => $supplierID,
                            'name' => $supplierName,
                            'color' => $supplierColor,
                            'code' => $supplierCode,
                            'price' => $supplierPrice,
                            'currency' => $supplierCurrencyName,
                            'availtext' => $supplierAvailtext,
                            'workflow' => $supplierWorkflow,
                            'contactId' => $supplierContactId,
                            'deliveryTime' => $deliveryTime,
                        );
                    } 

                    $productURLEdit = $product->makeURLEdit();
                    $productCount = $product->getCountWithDivisibility($x->getProductcount());
                    $productSource = $product->getSource();
                    $productUnit = $product->getUnit();
                    $showSerial = true;
                    if ($product->getSource() == 'service' || $product->getSource() == 'servicebusy') {
                        $showSerial = false;
                    }

                    $priceBase = $product->getPricebase();
                    $priceBase = Shop::Get()->getCurrencyService()->convertCurrency(
                        $priceBase,
                        $product->getCurrency(),
                        $order->getCurrency()
                    );

                    if ($product->getSource() == 'service'
                    || $product->getSource() == 'servicebusy') {
                        $serviceSum += round($priceBase * $x->getProductcount(), 2);
                    }

                    $storageArray = array();
                    $reserveOK = false;
                    $storageCount = false;
                    $storageIncoming = false;
                    $storageLinked = array();
                    $storageLinkedAmount = array();
                    if (Shop_ModuleLoader::Get()->isImported('storage')) {
                        // считаем количество на складе
                        $storageIncoming = $x->getStorageincomingid();
                        $storages = StorageNameService::Get()->getStorageNamesForSale();
                        $storages->setOrder('id');
                        while ($storage = $storages->getNext()) {
                            $balance = StorageBalanceService::Get()->getBalanceByProductForReserve(
                                $product,
                                $this->getUser(),
                                $storage->getId()
                            )->getNext();

                            if ($balance) {
                                try {
                                    $storageArray[$storage->getId()] = array(
                                        'id' => $balance->getId(),
                                        'name' => $balance->getStorageName()->getName(),
                                        'count' => round($balance->getAmountAvailable(), 3),
                                    );

                                    if (!$reserveOK) {
                                        $reserveOK = (
                                            $storageArray[$storage->getId()]['linked'] >= $x->getProductcount()
                                        );
                                    }

                                    if (!$storageCount) {
                                        $storageCount = ($storageArray[$storage->getId()]['count']);
                                    }
                                } catch (Exception $balanceEx) {

                                }
                            }
                        }
                        $amount = 0;
                        $links = StorageReserveService::Get()->getLinksByOrderProduct($x);
                        while ($link = $links->getNext()) {
                            try{
                                $storageName = $link->getStorageName();
                                $amount += $link->getAmount();
                                if (array_key_exists($storageName->getId(), $storageLinked)) {
                                    $storageLinked[$storageName->getId()]['amount'] = round(
                                        $storageLinked[$storageName->getId()]['amount'] + $link->getAmount(),
                                        2
                                    );
                                } else {
                                    $storageLinked[$storageName->getId()] = array(
                                        'storageName' => $storageName->getName(),
                                        'balanceid' => $link->getBalance()->getId(),
                                        'amount' => round($link->getAmount(), 2)
                                    );
                                }

                            } catch (Exception $e) {

                            }

                        }
                        $storageLinkedAmount = $amount;

                    }

                } catch (Exception $e) {
                    $productCount = $x->getProductcount();
                    $productSource = '';
                    $productUnit = '';
                    $productURLEdit = false;
                    $storageArray = array();
                    $showSerial = true;
                }

                $linkOrderName = false;
                $linkOrderURL = false;
                if (preg_match("/^orderproduct-(\d+)$/ius", $x->getLinkkey(), $r)) {
                    try {
                        $linkOrder = Shop::Get()->getShopService()->getOrderProductById($r[1])->getOrder();

                        $linkOrderName = $linkOrder->makeName();
                        $linkOrderURL = $linkOrder->makeURLEdit();
                    } catch (Exception $e) {

                    }
                }

                try {
                    $sum = $x->makeSum($order->getCurrency());
                } catch (Exception $priceEx) {
                    $sum = 0;
                }

                $allSum += $sum;
                $countProductAll += $productCount;

                // запись в тексте, вместо кода товара, код поставщика, если поставщик - клиент
                $codesupplier = 0;

                if ($clientId) {
                    try {
                        $supplier = Shop::Get()->getShopService()->getSupplierByID($x->getSupplierid());
                        if ($supplier->getContactid() == $clientId) {
                            foreach ($supplierArray as $s) {
                                if ($s['id'] == $x->getSupplierid()) {
                                    $codesupplier = $s['code'];
                                }
                            }
                        }
                    } catch (Exception $e) {
                        // если поставщик не выбран, берем первого
                        if (count($supplierArray)) {
                            try {
                                $supplier = Shop::Get()->getShopService()->getSupplierByID($supplierArray[0]['id']);
                                if ($supplier->getContactid() == $clientId) {
                                    $codesupplier = $supplierArray[0]['code'];
                                }

                            } catch (Exception $e) {

                            }

                        }
                    }
                }

                $image = false;
                try {
                    if ($x->getProduct()->getImage()) {
                        $src = MEDIA_PATH.'/shop/'.$x->getProduct()->getImage();
                        if (file_exists($src)) {
                            $image = $x->getProduct()->makeImageThumb('100', '100');
                        }
                    }
                } catch (Exception $e2) {

                }

                // заказы у поставщиков
                $supplierOrders = array();
                $products = new XShopOrderProduct();
                $products->setLinkkey('orderproduct-'.$x->getId());
                while ($p = $products->getNext()) {
                    try {
                        $supplierOrder = Shop::Get()->getShopService()->getOrderByID($p->getOrderid());
                        if ($supplierOrder->getDeleted()) {
                            continue;
                        }
                        $supplierOrders[] = array(
                            'id' => $supplierOrder->getId(),
                            'url' => $supplierOrder->makeURLEdit()
                        );
                    } catch (Exception $e) {

                    }
                }

                // товары
                @$a[] = array(
                    'id' => $x->getId(),
                    'name' => htmlspecialchars($x->getProductname()),
                    'productid' => $x->getProductid(),
                    'url' => $productURLEdit,
                    'count' => (float) $productCount,
                    'price' => $x->getProductprice(),
                    'pricebase' => $priceBase,
                    'margin' => ($priceBase) ? round((100 * ($x->getProductprice() - $priceBase) / $priceBase), 2) : 0,
                    'sum' => $sum,
                    'currencyid' => $x->getCurrencyid(),
                    'currencySym' => $x->getCurrency()->getSymbol(),
                    'comment' => htmlspecialchars($x->getComment()),
                    'statusid' => $x->getStatusid(),
                    'supplierArray' => $supplierArray,
                    'supplierid' => $x->getSupplierid(),
                    'storageid' => $x->getStorageid(),
                    'suppliercode' => $codesupplier,
                    'categoryname' => htmlspecialchars($x->getCategoryname()),
                    'serial' => htmlspecialchars($x->getSerial()),
                    'warranty' => htmlspecialchars($x->getWarranty()),
                    'source' => $productSource,
                    'datefrom' => $this->_formatDate($x->getDatefrom()),
                    'dateto' => $this->_formatDate($x->getDateto()),
                    'unit' => htmlspecialchars($productUnit),
                    'image' => $image,
                    'linkOrderName' => $linkOrderName,
                    'linkOrderURL' => $linkOrderURL,
                    'storageCountArray' => $storageArray,
                    'reserveOK' => $reserveOK,
                    'showSerial' => $showSerial,
                    'supplierOrders' => $supplierOrders,
                    'storageCount' => $storageCount,
                    'storageIncoming' => $storageIncoming,
                    'storageLinked' => $storageLinked,
                    'storageLinkedAmount' => $storageLinkedAmount,
                    'coupon' => $x->getLinkkey() == 'coupon' ? true : false
                );
            }

            $this->setValue('productsArray', $a);

            try{
                $isOutcoming = !$order->getWorkflow()->getOutcoming();
            } catch (Exception $eworkflow) {
                $isOutcoming = !$order->getOutcoming();
            }

            $this->setValue('isOutcoming', $isOutcoming);


            if (Shop_ModuleLoader::Get()->isImported('storage') && !$isOutcoming) {
                // склады
                $storageNames = StorageNameService::Get()->getStorageNamesForTransfers();
                $storageNames->setHidden(0);
                $this->setValue('storageIncomingArray', $storageNames->toArray());

            }

            $this->setValue('countProductAll', $countProductAll);
            $this->setValue('allSum', $allSum);

            $this->setControlValue('ordercurrencyid', $order->getCurrencyid());
            $this->setControlValue('discount', $order->getDiscountid());

            $delivery2 = false;
            try {
                $delivery2 = Shop::Get()->getDeliveryService()->getDeliveryByID($order->getDeliveryid());
            } catch (Exception $e) {

            }

            // сумма заказа
            if ($delivery2 && $delivery2->getPaydelivery()) {
                $this->setValue('totalSum', $order->getSum() + $order->getDeliveryprice());
            } else {
                $this->setValue('totalSum', $order->getSum());
                $this->setValue('payDelivery', true);
            }

            $this->setValue('sum', $order->getSum());
            $this->setValue('deliveryPrice', $order->getDeliveryprice()); // стоимость доставки
            $this->setValue('currency', $order->getCurrency()->getSymbol());
            $this->setValue('orderid', $order->getId());
            $this->setValue(
                'urlBarcode',
                Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-order-barcode',
                    $order->getId()
                )
            );

            // информация о ПДВ
            $taxSum = $order->makeTaxSum();
            $this->setValue('taxSum', $taxSum, 2);
            $this->setValue('sumWithoutTax', $order->makeSumWithoutTax());

            $this->setValue('discountSum', $order->getDiscountsum());

            // валюты
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $this->setValue('currencyArray', $currency->toArray());

            // если подключен модуль Финансы
            // добавляем счета
            if (Shop_ModuleLoader::Get()->isImported('finance')) {
                $this->setValue('finance', true);

                // сколько оплачено и баланс
                $paymentSum = $order->makeSumPaid();
                $this->setValue('paymentSum', $paymentSum);

                $paymentBalance = $order->makeSumBalance();
                $this->setValue('paymentBalance', $paymentBalance);
            }

            // список скидок
            $discounts = Shop::Get()->getShopService()->getDiscountAll();
            $discountArray = array();
            while ($discount = $discounts->getNext()) {
                try {
                    $discountArray[] = array(
                        'id' => $discount->getId(),
                        'name' => $discount->getName(),
                        'value' => $discount->getValue(),
                        'type' => $discount->getType(),
                        'currency' => $discount->getCurrency()->getName()
                    );
                } catch (ServiceUtils_Exception $se) {

                }
            }
            $this->setValue('discountArray', $discountArray);

            // валюты
            $currencies = Shop::Get()->getCurrencyService()->getCurrencyActive();
            $a = array();
            while ($x = $currencies->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'rate' => $x->getRate(),
                );
            }
            $this->setValue('orderCurrencyArray', $a);

            $this->setValue('ajax', $this->getArgumentSecure('ajax'));
            $this->setValue('orderid', $order->getId());

        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    /**
     * Обработчик добавления нового товара в заказ.
     *
     * При добавлении товара в заказ цена товара приводится по правилам:
     * (product.price + product.tax%)
     * и это все конвертируется в валюту заказа.
     *
     * @param ShopOrder $order
     */
    private function _addOrderProduct(ShopOrder $order) {
        $addProductID = $this->getArgumentSecure('productid');
        if (!$addProductID) {
            return ;
        }

        try {
            $product = Shop::Get()->getShopService()->getProductByID($addProductID);
            // проверяем не является ли наш продукт купоном
            if (strpos($product->getCode1c(), 'discountCoupon-') === 0) {
                Shop::Get()->getShopService()->addCoupon($order, $addProductID);
            } else {
                Shop::Get()->getShopService()->addOrderProduct($order, $addProductID);
            }

        } catch (Exception $e) {
            Shop::Get()->getShopService()->addOrderProduct($order, $addProductID);
        }

        return;

    }

    /**
     * Обработчик удаления товара из заказа
     *
     * @param ShopOrderProduct $op
     */
    private function _deleteOrderProduct(ShopOrderProduct $op) {
        try {
            $deleteID = $this->getArgument('delete'.$op->getId());

            $event = Events::Get()->generateEvent('shopOrderProductDeleteBefore');
            $event->setOrderProduct($op);
            $event->notify();

            $op->delete();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Обработчик обновления товара в заказе
     *
     * @param ShopOrderProduct $op
     */
    private function _updateOrderProduct(ShopOrderProduct $op) {
        try {
            $price = $this->getArgument('price'.$op->getId());
            $price = str_replace(',', '.', $price);

            $supplierID = $this->getArgumentSecure('supplier'.$op->getId());

            $storageID = $this->getArgumentSecure('storage'.$op->getId());

            $currencyID = $this->getArgument('currency'.$op->getId());

            // проверяем валюту на валидность
            $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);

            $count = $this->getArgument('count'.$op->getId());
            $count = str_replace(',', '.', $count);
            $count = (float) trim($count);

            try {
                $count = $op->getProduct()->getCountWithDivisibility($count);
            } catch (ServiceUtils_Exception $cse) {

            }

            $comment = $this->getArgument('comment'.$op->getId());
            $name = $this->getArgument('name'.$op->getId());
            $serial = $this->getArgumentSecure('serial'.$op->getId());
            $warranty = $this->getArgument('warranty'.$op->getId());
            $categoryName = $this->getArgument('category'.$op->getId());

            $dateFrom = $this->getArgumentSecure('datefrom'.$op->getId(), 'date');
            $dateTo = $this->getArgumentSecure('dateto'.$op->getId(), 'date');

            $storageIncoming = $this->getArgumentSecure('storageincoming'.$op->getId());

            try {
                if ($dateFrom && $dateTo && $op->getProduct()->getSource() == 'servicebusy') {
                    // это товар с месячной сеткой занятости
                    // (цена - за месяц)

                    $term = $op->getProduct()->getTerm();
                    if ($term == 'month') {
                        $count = DateTime_Differ::DiffMonth($dateFrom, $dateTo, false);
                    } elseif ($term == 'day') {
                        $count = DateTime_Differ::DiffDay($dateTo, $dateFrom) + 1;
                    } elseif ($term == 'year') {
                        $count = DateTime_Differ::DiffYear($dateTo, $dateFrom);
                    }

                }
            } catch (ServiceUtils_Exception $cse) {

            }

            /*
            // нельзя ставить цену ниже себестоимости
            $minProductPrice = $op->getProduct()->getPricebase();
            if ($minProductPrice > 0 && $minProductPrice > $price) {
            $price = $minProductPrice;
            }
            */

            $oldCount = $op->getProductcount();

            // сохраняем цену и валюту как указано
            $op->setProductprice($price);
            $op->setCurrencyid($currencyID);
            $op->setProductname($name);
            $op->setCategoryname($categoryName);
            $op->setSerial($serial);
            $op->setWarranty($warranty);

            $op->setProductcount($count);
            $op->setComment($comment);

            $op->setSupplierid($supplierID);

            $op->setDatefrom($dateFrom);
            $op->setDateto($dateTo);

            if (Shop_ModuleLoader::Get()->isImported('storage')) {
                $op->setStorageincomingid($storageIncoming);
                $op->setStorageid($storageID);
            }

            $op->update();

            if ($oldCount != $count) {
                $event = Events::Get()->generateEvent('shopOrderProductCountUpdateAfter');
                $event->setOrderProduct($op);
                $event->notify();
            }

        } catch (Exception $e) {

        }

    }

    private function _formatDate($date) {
        if (Checker::CheckDate($date)) {
            return DateTime_Formatter::DateISO9075($date);
        }

        return '';
    }

}