<?php
class action_block_switch_status extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        // список статустов
        $status = $this->_getStatus();

        $statuses = $status->getWorkflow()->getStatuses();

        $statusArray = array();
        while ($x = $statuses->getNext()) {

            if ($x->getId() == $status->getId()) {
                continue;
            }

            $statusArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );
        }

        $this->setValue('statusArray', $statusArray);

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('statusid', $data['status']);

    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'status' => $this->getArgumentSecure($index.'_status')
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }


    public function processStatus(Events_Event $event) {
        $data = (Array) json_decode($this->getValue('data'));
        $statusId = $data['status'];
        if (!$statusId) {
            return;
        }

        $order = $this->_getOrder($event);
        $user = $this->_getUser($event);

        Shop::Get()->getShopService()->updateOrderStatus(
            $user,
            $order,
            $statusId
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