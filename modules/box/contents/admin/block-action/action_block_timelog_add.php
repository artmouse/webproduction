<?php
class action_block_timelog_add extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('minute', $data['minute']);

    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'minute' => $this->getArgumentSecure($index.'_minute')
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
        $minute = $data['minute'];
        if ($minute) {
            $timeLog = new XShopTimeLog();
            $timeLog->setOrderid($this->_getOrder($event)->getId());
            $timeLog->setCdate(DateTime_Object::Now()->__toString());
            $timeLog->setTime($minute);
            $timeLog->insert();
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