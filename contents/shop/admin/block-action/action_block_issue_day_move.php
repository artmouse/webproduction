<?php
class action_block_issue_day_move extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('dateto', $data['dateto']);
    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'dateto' => (int) $this->getArgumentSecure($index.'_dateto')
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

        $data = (Array) json_decode($this->getValue('data'));
        $days = (int) $data['dateto'];
        $order->setDateto(DateTime_Object::FromString($order->getDateto())->addDay($days)->setFormat('Y-m-d H:i:s'));
        $order->update();
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
}