<?php
class storage_order_status_action_block_reserve_unset extends Engine_Class {

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
        // автоснятие резерва
        StorageReserveService::Get()->deleteLinksReserveAuto(
            $this->_getOrder($event)
        );
    }

    public function processOrderDeleteBefore(Events_Event $event) {
        // автоснятие резерва
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
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }
}