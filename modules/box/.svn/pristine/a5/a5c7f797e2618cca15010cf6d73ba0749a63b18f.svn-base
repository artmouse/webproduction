<?php
class action_block_auto_transfer extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('nextdate', $data['nextdate']);

    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'nextdate' => $this->getArgumentSecure($index.'_nextdate')
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }

    public function processCronHour(Events_Event $event) {
        $event;

        $status = $this->_getStatus();

        $data = (Array) json_decode($this->getValue('data'));
        $data = $data['nextdate'];

        $date = DateTime_Object::Now()->setFormat('Y-m-d 00:00:00');
        $dateNow = DateTime_Object::Now()->setFormat('Y-m-d');

        $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $orders->setStatusid($status->getId());
        $orders->addWhere('dateto', $dateNow, '<');
        $orders->addWhere('dateto', '0000-00-00 00:00:00', '!=');
        $orders->setDateclosed('0000-00-00 00:00:00');

        if ($data == 'start') {
            $orders->setOrder('priority', 'DESC');
        } else {
            $orders->setOrder('priority');
        }

        while ($order = $orders->getNext()) {
            try {
                IssueService::Get()->updateIssueDateto(
                    $order,
                    false, // user
                    $date,
                    false, // priority
                    $order->getPriority() ? $data : false,
                    true
                );
            } catch (Exception $ex) {

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