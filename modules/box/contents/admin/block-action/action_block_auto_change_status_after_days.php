<?php
class action_block_auto_change_status_after_days extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $statusArray = array();
        $status = $this->_getStatus();

        $statuses = $status->getWorkflow()->getStatuses();
        while ($tmpStatus = $statuses->getNext()) {
            if ($tmpStatus->getId() == $status->getId()) {
                continue;
            }

            $statusArray[] = array(
                'id' => $tmpStatus->getId(),
                'name' => $tmpStatus->getName()
            );
        }

        $data = unserialize($this->getValue('data'));

        $this->setValue('statusid', $data['status']);
        $this->setValue('day', $data['day']);
        $this->setValue('statusArray', $statusArray);
    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'status' => $this->getArgumentSecure($index.'_status'),
            'day' =>(int) $this->getArgumentSecure($index.'_day')
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            serialize($data)
        );
    }

    public function processCronDay(Events_Event $event) {
        $event;

        $status = $this->_getStatus();

        $data = unserialize($this->getValue('data'));
        $statusId = $data['status'];

        $day = $data['day'];
        if (!$day) {
            return;
        }

        $dateNow = DateTime_Object::Now();
        $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $orders->setStatusid($status->getId());
        while ($order = $orders->getNext()) {
            try {
                // сколько прошло дней от момента создания?
                $change = new XShopOrderChange();
                $change->setKey('statusid');
                $change->setOrderid($order->getId());
                $change->setValue($status->getId());
                $change = $change->getNext();
                if (!$change) {
                    continue;
                }
                $dateChange = $change->getCdate();

                $diffDate = DateTime_Differ::DiffDay($dateNow, $dateChange);

                if ($diffDate && $diffDate > $day) {
                    Shop::Get()->getShopService()->updateOrderStatus(
                        $order->getManagerOrAuthor(),
                        $order,
                        $statusId
                    );
                }

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