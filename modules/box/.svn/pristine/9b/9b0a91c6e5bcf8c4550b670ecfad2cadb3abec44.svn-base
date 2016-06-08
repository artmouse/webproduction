<?php
class action_block_auto_repeat_week extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));
        $arr = json_decode($this->getValue('data'));

        $dataArray = array();
        foreach ($arr as $arg) {
            if ($arg) {
                $dataArray[$arg] = $arg;
            }
        }

        $this->setValue('weekArray', $dataArray);
    }

    public function processData() {
        $index = $this->getValue('index');

        $week = $this->getArgumentSecure($index.'_week');
        $returnArray = array();
        foreach ($week as $w) {
            if (!$w) {
                continue;
            }

            $returnArray[$w] = $w;
        }

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($returnArray)
        );
    }

    public function processCronDay(Events_Event $event) {
        $event;
        $dateNow = DateTime_Object::Now()->setFormat('Y-m-d');
        $status = $this->_getStatus();

        $weekDay = date("w", strtotime($dateNow->__toString()));
        if (!$weekDay) {
            // воскресенье приходит нулем, переделываем в 7
            $weekDay = 7;
        }
        $data = (Array) json_decode($this->getValue('data'));

        if (!in_array($weekDay, $data)) {
            return;
        }

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