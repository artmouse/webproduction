<?php
class action_block_supplier_order extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));

        $this->setValue('orderSupplier', $data['choise']);
    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'choise' => $this->getArgumentSecure($index.'_orderSupplier')
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }

    public function processStatus(Events_Event $event) {
        $order = $this->_getOrder($event);
        $orderProducts = $order->getOrderProducts();

        $data = (Array) json_decode($this->getValue('data'));
        $data = $data['choise'];

        if ($data == 'create') {
            while ($op = $orderProducts->getNext()) {
                $this->shopOrderProductSupplierOrder($op);
            }
        } elseif ($data == 'cancel') {
            // убираем товар из заказа поставщику, если он есть
            while ($op = $orderProducts->getNext()) {
                $orderProductsSupplier = Shop::Get()->getShopService()->getOrderProductsAll();
                $orderProductsSupplier->setLinkkey('orderproduct-' . $op->getId());
                // проверка статуса заказа
                $orderProductsSupplier->addWhereQuery(
                    "orderid IN (SELECT id FROM shoporder WHERE statusid IN (
                        SELECT id FROM shoporderstatus WHERE
                            (payed='0' and saled='0' and prepayed='0' and closed='0' and shipped='0')
                    ))"
                );

                while ($x = $orderProductsSupplier->getNext()) {
                    $orderSupplier = $x->getOrder();
                    $x->delete();

                    Shop::Get()->getShopService()->recalculateOrderSums($orderSupplier);
                }
            }
        }

    }

    public function processOrderEditAfter (Events_Event $event) {
        $this->processStatus($event);
    }

    public function processOrderProductDeleteBefore (Events_Event $event) {
        $data = $this->getValue('data');

        $orderProduct = $this->_getOrderProduct($event);

        // удаление товаров из заказа поставщику
        if ($data) {
            // убираем товар из заказа поставщику, если он есть
            $orderProductsSupplier = Shop::Get()->getShopService()->getOrderProductsAll();
            $orderProductsSupplier->setLinkkey('orderproduct-' . $orderProduct->getId());
            // проверка статуса заказа
            $orderProductsSupplier->addWhereQuery(
                "orderid IN (SELECT id FROM shoporder WHERE statusid IN (
                    SELECT id FROM shoporderstatus WHERE
                        (payed='0' and saled='0' and prepayed='0' and closed='0' and shipped='0')
                ))"
            );

            while ($x = $orderProductsSupplier->getNext()) {
                $orderSupplier = $x->getOrder();
                $x->delete();

                Shop::Get()->getShopService()->recalculateOrderSums($orderSupplier);
            }
        }
    }

    /**
     * Получить удаляемый OrderProdcut. Метод обертка для типизации.
     *
     * @param Events_Event $event
     *
     * @return ShopOrderProduct
     */
    private function _getOrderProduct(Events_Event $event) {
        return $event->getOrderProduct();
    }

    /**
     * Обертка
     *
     * @param Shop_Event_Order $event
     *
     * @return ShopOrder
     */
    private function _getOrder($event) {
        return $event->getOrder();
    }

    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

    public function shopOrderProductSupplierOrder(ShopOrderProduct $orderProduct) {
        // ищем связанный товар
        $tmp = new ShopOrderProduct();
        $tmp->setProductid($orderProduct->getProductid());
        $tmp->setLinkkey('orderproduct-'.$orderProduct->getId());

        $productFind = false;
        $productCountInClosedOrder = 0;
        $productCountInOpenOrder = 0;

        // ищем связанный товар в заказе с учетом статусов
        while ($x = $tmp->getNext()) {
            try {
                if ($x->getOrder()->getDeleted()) {
                    continue;
                }
                $status = $x->getOrder()->getStatus();
                // проверяем статус
                if (!$status->getDefault()) {
                    $productCountInClosedOrder += $x->getProductcount();
                } else {
                    $productCountInOpenOrder += $x->getProductcount();
                    $productFind[]= $x;
                }
            } catch (Exception $e) {

            }

        }
        // сколько надо добавить
        $productCount = $orderProduct->getProductcount() - $productCountInClosedOrder - $productCountInOpenOrder;
        if (Shop_ModuleLoader::Get()->isImported('storage')) {
            // считаем сколько есть на складе
            try {
                $storages = StorageNameService::Get()->getStorageNamesForSale();
                $storages->setOrder('id');
                while ($storage = $storages->getNext()) {
                    $balance = StorageBalanceService::Get()->getBalanceByProductForReserve(
                        $orderProduct->getProduct(),
                        $this->getUser(),
                        $storage->getId()
                    )->getNext();

                    if ($balance) {
                        $productCount-= $balance->getAmountAvailable();
                    }
                }
            } catch (Exception $e) {

            }

        }

        if ($productFind) {
            // связанный товар найден.
            // обновляем количество
            if ($productCount > 0) {
                // количество увеличиваем
                $product = $productFind[0];
                $product->setProductcount($product->getProductcount() + $productCount);
                $product->update();
                // пересчитать цены
                Shop::Get()->getShopService()->recalculateOrderSums($product->getOrder());
            } elseif ($productCount < 0) {
                // количество уменьшаем
                foreach ($productFind as $product) {
                    $count = $product->getProductcount();
                    $productCount += $count;
                    if ($productCount > 0) {
                        $product->setProductcount($productCount);
                    } else {
                        $product->setProductcount(0);
                    }
                    $product->update();
                    // пересчитать цены
                    Shop::Get()->getShopService()->recalculateOrderSums($product->getOrder());

                    if ($productCount > 0) {
                        break;
                    }

                }

            }

        } elseif ($productCount > 0) {
            // связанный товар не найден.
            $this->_addProducSupplierOrder($orderProduct, $productCount);

        }
    }

    private function _addProducSupplierOrder (ShopOrderProduct $orderProduct, $productCount = false) {
        // определяем поставщика
        try{
            $supplier = $orderProduct->getSupplier();
        } catch (Exception $esupplier) {
            $result = Shop::Get()->getSupplierService()->calculatePriceBySupplier($orderProduct->getProduct());
            if ($result['supplierid']) {
                $supplier = Shop::Get()->getSupplierService()->getSupplierByID($result['supplierid']);
            } else {
                return false;
            }
        }

        if (!$supplier->getWorkflowid()) {
            return false;
        }

        try {
            $supplierContact = $supplier->getContact();
        } catch (Exception $econtact) {
            throw new ServiceUtils_Exception('no_contact_supplier');
        }

        // находим открытый заказ поставщику
        $orderSupplier = new ShopOrder();
        $orderSupplier->setDeleted(0);
        $orderSupplier->setOutcoming(1);
        $orderSupplier->setUserid($supplierContact->getId());
        $orderSupplier->setIssue(0);
        $orderSupplier->addWhereQuery("(linkkey LIKE 'autoOrderSupplier-%')");
        $orderSupplier->addWhereQuery(
            "statusid IN (SELECT id FROM shoporderstatus WHERE `default`='1')"
        );

        if ($orderSupplier = $orderSupplier->getNext()) {
            // открытый заказ найден,
            // дописываем в него
            $this->_addSupplierOrderProduct($orderSupplier, $orderProduct, $productCount);

        } else {
            // заказ не найден
            // нужно создавать новый
            $workFlow = false;
            try {
                $workFlow = Shop::Get()->getShopService()->getOrderCategoryByID($supplier->getWorkflowid());
            } catch (Exception $e) {
                throw new ServiceUtils_Exception('supplier_workflow');
            }

            $orderSupplier = Shop::Get()->getShopService()->makeOrderEmpty();

            $orderSupplier->setClientname($supplierContact->makeName(false, false));
            $orderSupplier->setClientphone($supplierContact->getPhone());
            $orderSupplier->setClientemail($supplierContact->getEmail());
            $orderSupplier->setClientaddress($supplierContact->getAddress());
            $orderSupplier->setUserid($supplierContact->getId());
            $orderSupplier->setOutcoming(1);
            $orderSupplier->setIssue(0);
            $orderSupplier->setCategoryid($supplier->getWorkflowid());
            $orderSupplier->setStatusid($workFlow ? $workFlow->getStatusDefault()->getId():0);
            $orderSupplier->setLinkkey('autoOrderSupplier-'.$supplier->getId());
            $orderSupplier->update();

            // дописываем в него
            $this->_addSupplierOrderProduct($orderSupplier, $orderProduct, $productCount);

        }

    }

    /**
     * Добавить товар в заказ поставщика (на основе строки заказа клиента)
     *
     * @param ShopOrder $orderSupplier
     * @param ShopOrderProduct $orderProduct
     * @param int $productCount
     */
    private function _addSupplierOrderProduct(ShopOrder $orderSupplier, ShopOrderProduct $orderProduct,
                                              $productCount = false) {
        // определяем цену и поставщика
        try {
            $product = $orderProduct->getProduct();

            $tmp = new ShopOrderProduct();
            $tmp->setProductid($orderProduct->getProductid());
            $tmp->setOrderid($orderSupplier->getId());
            $tmp->setProductname($orderProduct->getProductname());
            $tmp->setProductcount($productCount);
            $tmp->setProductprice($product->getPricebase());
            $tmp->setCurrencyid(Shop::Get()->getCurrencyService()->getCurrencySystem()->getId());
            $tmp->setLinkkey('orderproduct-'.$orderProduct->getId());
            $tmp->insert();

        } catch (Exception $e) {

        }

        // пересчитать цены
        Shop::Get()->getShopService()->recalculateOrderSums($orderSupplier);
    }

}