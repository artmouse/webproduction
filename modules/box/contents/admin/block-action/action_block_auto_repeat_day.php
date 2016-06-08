<?php
class action_block_auto_repeat_day extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $this->setValue('day', $this->getValue('data'));
    }

    public function processData() {
        $index = $this->getValue('index');

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            $this->getArgumentSecure($index.'_day')
        );
    }

    public function processCronDay(Events_Event $event) {
        $event;

        $status = $this->_getStatus();
        $everyDay = $this->getValue('data');
        if (!$everyDay) {
            return;
        }

        $dateNow = DateTime_Object::Now();
        $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $orders->setStatusid($status->getId());
        while ($order = $orders->getNext()) {
            try {
                // сколько прошло дней от момента создания?
                $diffDate = DateTime_Differ::DiffDay($dateNow, $order->getCdate());

                if ($diffDate && $diffDate % $everyDay === 0) {
                    // создаем задачу
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