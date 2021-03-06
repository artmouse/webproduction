<?php
class storage_order_status_action_block_debit_order_auto extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));
    }

    public function processData() {
        $index = $this->getValue('index');

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode(
                array(
                    'data' => 1
                )
            )
        );
    }

    public function processStatus(Events_Event $event) {

        // разбиваем продукты заказа по складам
        $order = $this->_getOrder($event);
        $orderProducts = $order->getOrderProducts();
        $orderProductsByStorage = array();
        while ($op = $orderProducts->getNext()) {
            if (!$op->getProductid()) {
                continue;
            }

            try{
                $source = $op->getProduct()->getSource();

                if ($source == 'service' || $source == 'servicebusy') {
                    continue;
                }
            } catch (Exception $eproduct) {

            }

            if (!$op->getStorageincomingid()) {
                throw new ServiceUtils_Exception('storage-no-storage-found-incoming-orderproduct');
            }
            $orderProductsByStorage[$op->getStorageincomingid()][] = $op->getId();
        }

        foreach ($orderProductsByStorage as $storageid => $productsArray) {
            $storage = StorageNameService::Get()->getStorageNameByID($storageid);

            // список orderProduct
            $orderProduct = Shop::Get()->getShopService()->getOrderProductsAll();
            $orderProduct->addWhereArray($productsArray);
            // автооприходование
            StorageIncomingService::Get()->processIncomingsAutoDifferentStorage(
                $this->_getUser($event),
                $this->_getOrder($event),
                $storage,
                $orderProduct
            );
        }

        $order->setIsshipped(1);
        $order->setDateshipped(date('Y-m-d H:i:s'));
        $order->update();

        // авторезервирование
        while ($op = $orderProducts->getNext()) {
            try{
                $source = $op->getProduct()->getSource();

                if ($source == 'service' || $source == 'servicebusy') {
                    continue;
                }
            } catch (Exception $eproduct) {

            }

            if (preg_match("/^orderproduct-(\d+)$/ius", $op->getLinkkey(), $r)) {
                try {
                    // выбранная запись баланса
                    $balance = StorageBalanceService::Get()->getBalanceByProduct($op->getProduct());
                    $balance->setAmount($op->getProductcount());
                    $balance->setOrder('id', 'DESC');
                    $balance = $balance->getNext();

                    if ($balance) {
                        StorageReserveService::Get()->addLinksReserve(
                            $this->_getUser($event),
                            $balance,
                            Shop::Get()->getShopService()->getOrderProductById($r[1])
                        );
                    }

                } catch (Exception $e) {

                }
            }
        }

    }

    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
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
     * @param Shop_Event_Order $event
     *
     * @return User
     */
    private function _getUser($event) {
        return $event->getUser();
    }

}