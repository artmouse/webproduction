<?php
class action_block_auto_repeat_month extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));
        $returnArray = array();
        foreach ($data as $day) {
            if (!$day) {
                continue;
            }

            $returnArray[$day] = $day;
        }

        $this->setValue('dateArray', $returnArray);

    }

    public function processData() {
        $index = $this->getValue('index');

        $data = $this->getArgumentSecure($index.'_day');
        $resultArray = array();
        foreach ($data as $day) {
            if (!$day) {
                continue;
            }
            $resultArray[$day] = $day;
        }

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($resultArray)
        );

    }

    public function processCronDay(Events_Event $event) {
        $event;

        $status = $this->_getStatus();

        $data = (Array) json_decode($this->getValue('data'));
        $dayNow = DateTime_Object::Now()->setFormat('d');

        if (!in_array($dayNow, $data)) {
            return;
        }

        $dateNow = DateTime_Object::Now()->setFormat('Y-m-d');

        $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $orders->setStatusid($status->getId());
        $orders->addWhere('dateto', $dateNow, '<');
        $orders->addWhere('dateto', '0000-00-00 00:00:00', '!=');
        while ($order = $orders->getNext()) {
            try {

                // проверка на уже созданую задачу
                $newOrder = Shop::Get()->getShopService()->getOrdersAll(false, true);
                $newOrder->setPrevid($order->getId());
                if ($newOrder->select()) {
                    continue;
                }

                // dateto=now + (oldcdate - olddateto)
                $dateTo = DateTime_Object::Now()->addDay(
                    DateTime_Differ::DiffDay(
                        $order->getDateto(),
                        DateTime_Object::FromString($order->getCdate())->setFormat('Y-m-d')
                    )
                )->setFormat('Y-m-d');

                $newOrder = Shop::Get()->getShopService()->cloneOrder($order);
                $newOrder->setNumber($newOrder->getId());
                $newOrder->setPrevid($order->getId());
                $newOrder->setDateto($dateTo);
                $newOrder->update();
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