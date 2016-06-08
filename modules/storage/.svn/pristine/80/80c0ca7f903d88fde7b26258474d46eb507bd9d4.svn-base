<?php
class storage_order_status_action_block_production_passport extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        // все склады с которых можно перемещать
        $storageNames = StorageNameService::Get()->getStorageNamesForTransferFromByUser(
            $this->getUser()
        );
        $this->setValue('storagesfromArray', $storageNames->toArray());

        // все склады на которые можно перемещать
        $storageNames = StorageNameService::Get()->getStorageNamesForTransferToByUser(
            $this->getUser()
        );
        $this->setValue('storagestoArray', $storageNames->toArray());

        $data = json_decode($this->getValue('data'));


        $this->setValue('storagenameid_product', $data->to);
        $this->setValue('storagenameid_materials', $data->from);
    }

    public function processData() {
        $index = $this->getValue('index');



        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode(
                array(
                    'from' => $this->getArgumentSecure($index.'_storagenameid_materials'),
                    'to' => $this->getArgumentSecure($index.'_storagenameid_product')
                )
            )
        );
    }

    public function processStatus(Events_Event $event) {
        $data = json_decode($this->getValue('data'));

        $storageFrom = $data->from;
        $storageTo = $data->to;

        $user =  $this->_getUser($event);
        $order = $this->_getOrder($event);
        $orderProducts = $order->getOrderProducts();
        while ($orderProduct = $orderProducts->getNext()) {
            // добавляем в корзину перемещения товар

            $passportItem = new XShopProductPassportItem();
            $passportItem->setIstarget(1);
            $passportItem->setProductid($orderProduct->getProductid());
            $passportItem = $passportItem->getNext();

            if (!$passportItem) {
                throw new ServiceUtils_Exception('passport');
            }

            StorageProductionService::Get()->addPassportToProduction(
                $user,
                $storageFrom,
                $passportItem->getPassportid(),
                $orderProduct->getProductcount()
            );


        }

        $storageID = StorageProductionService::Get()->processProduction(
            $user,
            $storageTo,
            DateTime_Object::Now()
        );

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