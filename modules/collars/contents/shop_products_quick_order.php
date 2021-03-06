<?php
class shop_products_quick_order extends Engine_Class {

    /**
     * Doc
     *
     * @return ShopProduct
     */
    private function _getProduct() {
        return $this->getValue('product');
    }

    public function process() {
        $product = $this->_getProduct();
        if ($product) {
            $this->setValue('productName', $product->getName());
            $this->setValue('productID', $product->getId());
        }



        try{
            $user = $this->getUser();
            $this->setControlValue('qoname', $user->makeName(false, 'lfm'));
            $this->setControlValue('qophone', $user->getPhone());
            $this->setControlValue('qoemail', $user->getEmail());
        } catch (Exception $e) {

        }

        $this->setValue(
            'requiredEmail',
            Shop::Get()->getSettingsService()->getSettingValue('shop-email-required-for-order')
        );

        if ($this->getArgumentSecure('qosubmit')) {

            try {
                SQLObject::TransactionStart();

                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                // определяем клиента
                $client = false;
                try {
                    $client = $this->getUser();
                    if ($client->isManager()) {
                        $client = false;
                    }
                } catch (Exception $clientEx) {

                }

                if (!$client) {
                    try {
                        $client = Shop::Get()->getUserService()->addUserClient(
                            $this->getControlValue('qoname'),
                            false, // namelast
                            false, // namemiddle
                            false, // typesex
                            false, // company
                            false, // post
                            $this->getControlValue('qoemail'),
                            $this->getControlValue('qophone')
                        );
                        $client->setDistribution(1);
                        $client->update();
                    } catch (Exception $e) {
                        $client = $this->getUser();
                    }
                }
                /*добавление опций в заказ*/
                $options = json_encode($this->getArgumentSecure('productoption'));
                $basket = Shop::Get()->getShopService()->addToBasket($this->getArgument('productid'), 2, $options);
                unset($options);

                $url = Engine::GetURLParser()->getHost().Engine::GetURLParser()->getCurrentURL()
                if ($url) {
                }

;
                $product = Shop::Get()->getShopService()->getProductByID($this->getArgument('productid'));

                // оформляем заказ
                $order = $this->_makeOrderQuick(
                    $client,
                    $product,
                    $this->getControlValue('qoname'),
                    $this->getControlValue('qoemail'),
                    $this->getControlValue('qophone'),
                    $basket
                );

                SQLObject::TransactionCommit();

                $products = $order->getOrderProducts();
                $ids = '?ids=';
                while ($x = $products->getNext()) {
                    $ids .= $x->getProductid().',';
                }

                header(
                    'Location: '.
                    Engine::GetLinkMaker()->makeURLByContentID('shop-basket-success').$ids.'&orderid='.$order->getId()
                );

            } catch (ServiceUtils_Exception $e) {
                SQLObject::TransactionRollback();
            }
        }
    }


    /**
     * Быстрое оформление заказа (на один товар)
     *
     * Внимание! Если бизнес-процесса и статуса не будет - заказы не оформляются!
     *
     * @param User $client
     * @param ShopProduct $product
     * @param string $name
     * @param string $email
     * @param string $phone
     *
     * @return ShopOrder
     */
    private function _makeOrderQuick(User $client, ShopProduct $product, $name, $email, $phone, ShopBasket $basket) {
        /**
         * Общий алгоритм оформления заказа:
         *
         * 1. При оформлении заказа все суммы товаров и сумма заказа будет
         * в системной валюте.
         * 2. Будет выбрано активное юрлицо по умолчанию - и оно будет выставлено
         * в заказ.
         * 3. Все стоимости товаров будут приведены к полной стоимости включая НДС
         * (если НДС указан в самом товаре). НДС контрактора не будет использоваться.
         *
         * Уже в управлении заказом чтобы посчитать НДС нужно будет от суммы заказа снять
         * процент НДС.
         */

        try {
            SQLObject::TransactionStart();

            $name = trim($name);
            $phone = trim($phone);
            $email = trim($email);

            $ex = new ServiceUtils_Exception();

            if (empty($name)) {
                $ex->addError('name');
            }

            if ($phone) {
                if (!Checker::CheckPhone($phone)) {
                    $ex->addError('phone');
                }
            }

            if ($email) {
                if (!Checker::CheckEmail($email)) {
                    $ex->addError('email');
                }
            }

            if (!$email && !$phone) {
                $ex->addError('email');
                $ex->addError('phone');
            }

            // получаем системную валюту, в которой будем оформлять заказ
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $outcoming = false;
            $orderType = false;
            $filter_quantity = false;

            // поиск категории по умолчанию
            try {
                $category = WorkflowService::Get()->getWorkflowDefault('order');
            } catch (Exception $workflowEx) {
                throw new ServiceUtils_Exception('workflow');
            }

            $categoryID = $category->getId();
            $outcoming = $category->getOutcoming();
            $orderType = $category->getType();

            // поиск статуса заказа по умолчанию
            $statusDefault = $category->getStatusDefault();

            // поиск активного юридического лица
            try {
                $contractor = Shop::Get()->getShopService()->getContractorDefault();
                $contractorID = $contractor->getId();
                $contractorTax = $contractor->getTax();
            } catch (Exception $e) {
                $contractorID = 0;
                $contractorTax = 0;
            }

            // оформление заказа
            $order = new ShopOrder();
            $order->setCdate(date('Y-m-d H:i:s'));

            // оформляем заказ на клиента
            $order->setUserid($client->getId());

            $client->getPhone() ? false : $client->setPhone($phone);
            $client->getEmail() ? false : $client->setEmail($email);
            $client->update();

            // параметры юзера из формы
            $order->setClientname($name);
            $order->setClientphone($phone);
            $order->setClientemail($email);
            $order->setStatusid($statusDefault->getId());
            $order->setType($orderType);
            $order->setCategoryid($categoryID);
            $order->setOutcoming($outcoming);

            // дата до которой нужно выполнить заказ
            $date = Shop::Get()->getSettingsService()->getSettingValue('order-dateto-days');
            $order->setDateto(DateTime_Object::Now()->addDay((int) $date)->__toString());

            // юрлицо (контрактор)
            $order->setContractorid($contractorID);

            // кто автор заказа
            try {
                $order->setAuthorid(Shop::Get()->getUserService()->getUser()->getId());
            } catch (Exception $authorEx) {
                $order->setAuthorid($client->getId());
            }

            // кто менеджер заказа
            try {
                $manager = Shop::Get()->getUserService()->getUser();
                if ($manager->isManager()) {
                    $order->setManagerid($manager->getId());
                }
            } catch (Exception $managerEx) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $managerEx;
                }
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            // вставляем заказ
            $order->insert();

            // сумма заказа
            $sum = 0;
            if (Shop_ModuleLoader::Get()->isImported('personal-discount')) {
                // для суммы по товарам с персональными скидками (на неё не накладывается общая скидка)
                $personalSum = array();
            }
            //$baskets = $this->getBasketProducts();
            $count = 0;

            // вставляем запись
            $op = new ShopOrderProduct();

            try {
                try {
                    $filter_count = Engine::Get()->getConfigField('filter_count');
                } catch (Exception $e) {
                    $filter_count = 10;
                }
                for ($j = 1; $j <= $filter_count; $j++) {

                    // 10 фильтров в shopbasket
                    // если id=0, а значение !=0, то это фильтр количества
                    if ($basket->getField('filter'.$j.'id') == 0 && $basket->getField('filter'.$j.'value') != 0) {
                        $filter_quantity = $basket->getField('filter' . $j . 'value');
                        continue;
                    }

                    if ($basket->getField('filter'.$j.'id')) {

                        try {
                            $filter = Shop_ShopService::Get()->getProductFilterByID(
                                $basket->getField('filter' . $j . 'id')
                            );
                        } catch (Exception $e) {

                        }

                        $productCommentArray[] = $filter->getName() . ': ' . $basket->getField('filter' . $j . 'value');

                    }
                }
            } catch (Exception $optionEx) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $optionEx;
                }
            }
            $op->setComment(implode(', ', $productCommentArray));

            // приводим стоимость товара к НДС и скидке в самом товаре, к валюте заказа
            if (isset($personalSum)) {
                if ($personalPrice = PersonalDiscountService::Get()->makePersonalPrice($product, $currencyDefault)) {
                    $price = $personalPrice['price'];
                    $personalSum[$product->getId()] = $personalPrice;
                    $op->setPersonal_discountid($personalPrice['discountID']);
                    $op->setComment(
                        'Товар приобретён по персональной скидке "'.
                        $personalSum[$product->getId()]['discountName'].
                        '(№'.$personalSum[$product->getId()]['discountID'].
                        ')", накопительная скидка на товар не насчитывается'
                    );
                } else {

                    $price = $product->makePrice($currencyDefault);
                }
            } else {
                //считаем цену методом корзины
                $price = $basket->makePrice($currencyDefault);
            }

            $op->setOrderid($order->getId());
            $op->setProductid($product->getId());
            if ($filter_quantity) {
                $op->setProductcount($filter_quantity);
            } else {

                $op->setProductcount(1);
            }
             // 1 штука
            $op->setProductname($product->getName());
            $op->setSupplierid($product->getSupplierid());
            try {
                $op->setCategoryname($product->getCategory()->makePathName());
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
            $op->setProductprice($price);
            $op->setProducttax($product->getTax());
            $op->setCurrencyid($currencyDefault->getId());
            $op->insert();

            // считаем сумму заказа.
            // при подсчете приводим цену к округлению НДС контрактора
            $priceWithoutTax = Shop::Get()->getShopService()->calculateSum(
                $price,
                $contractorTax,
                0,
                0,
                true, // return sum
                false, // + vat tax
                false // without discount
            );

            $sum = round($priceWithoutTax * $op->getProductcount(), 2);

            // увеличиваем счетчик заказа товаров на +1
            $product->setOrdered($product->getOrdered() + 1);
            $product->setLastordered(date('Y-m-d H:i:s'));
            $product->update();

            $count ++;

            // если нет строк - нет заказа
            if (!$count) {
                throw new ServiceUtils_Exception('count');
            }

            if ($contractorTax) {
                $sum *= (1 + $contractorTax / 100);
            }

            // автоопределение скидки
            if (empty($personalSum[$product->getId()])) {
                $value = 0;
                $discount = false;
                $discounts = Shop::Get()->getShopService()->getDiscountAll();
                while ($x = $discounts->getNext()) {
                    // если скидка может применятся автоматически
                    if ($x->getMinstartsum() > 0) {
                        // конвертируем сумму заказа в валюту скидки
                        $sumDiscount = Shop::Get()->getCurrencyService()->convertCurrency(
                            $sum,
                            $currencyDefault,
                            $x->getCurrency()
                        );

                        if ($x->getMinstartsum() <= $sumDiscount) {
                            // ищем максимально возможную скидку
                            $x_value = $x->makeDiscountValue($sum, $currencyDefault);
                            if ($x_value > $value) {
                                $value = $x_value;
                                $discount = clone $x;
                            }
                        }
                    }
                }

                if ($client && $client->getDiscountid()) {
                    try{
                        $discount = Shop::Get()->getShopService()->getDiscountByID($client->getDiscountid());
                    } catch (Exception $edu) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $edu;
                        }
                    }
                }

                if ($discount) {
                    $order->setDiscountid($discount->getId());
                    $order->setDiscountsum($discount->makeDiscountValue($sum, $currencyDefault));
                    $sum = $discount->applyDiscount($sum, $currencyDefault);
                    $sum = round($sum, 2);
                }
            }

            // увеличиваем стоимость заказа на сумму доставки
            // Внимание! Доставка в сумме заказа уже не фигурирует!
            // $sum += $deliveryPrice;

            // записываем сумму заказа и валюту
            $order->setSum($sum);
            $order->setSumbase($sum);
            $order->setCurrencyid($currencyDefault->getId());

            // формируем записываем Hash заказа
            // для трек-ссылки заказа
            $order->setHash(md5($order->getId().$order->getClientname().$order->getClientphone().$order->getCdate()));

            // обновляем заказ
            $order->update();

            try{
                // вставляем историю
                $change = new XShopOrderChange();
                if ($client) {
                    $change->setUserid($client->getId());
                }
                $change->setOrderid($order->getId());
                $change->setCdate($order->getCdate());
                $change->setKey('statusid');
                $change->setValue($order->getStatusid());
                $change->insert();
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // fire event
            $event = Events::Get()->generateEvent('shopOrderAddAfter');
            $event->setOrder($order);
            $event->setUser($client);
            $event->notify();

            SQLObject::TransactionCommit();

            return $order;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

}