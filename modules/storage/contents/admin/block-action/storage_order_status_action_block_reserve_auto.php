<?php
class storage_order_status_action_block_reserve_auto extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));

        $this->setValue('storagenameid_incoming', $data['storageId']);

        $storageNamesIncoming = StorageNameService::Get()->getStorageNamesAll();
        $storageNamesIncoming->setForsale(1);
        $storageNameIncomingArray = array();
        while ($storageNameIncoming = $storageNamesIncoming->getNext()) {
            $storageNameIncomingArray[] = array(
                'id' => $storageNameIncoming->getId(),
                'name' => $storageNameIncoming->getName()
            );
        }
        $this->setValue('storageNameIncomingArray', $storageNameIncomingArray);
    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'storageId' => $this->getArgumentSecure($index.'_storagenameid_incoming')
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }

    public function processStatus(Events_Event $event) {
        $user = $this->getUserSecure();
        if (!$user) {
            $user = $this->_getUser($event);
        }

        $data = (Array) json_decode($this->getValue('data'));

        $storageId = $data['storageId'];

        // авторезервирование
        StorageReserveService::Get()->addLinksReserveAuto(
            $user,
            $this->_getOrder($event),
            $storageId
        );
    }

    public function processOrderEditAfter(Events_Event $event) {
        $this->processStatus($event);
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

    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

}