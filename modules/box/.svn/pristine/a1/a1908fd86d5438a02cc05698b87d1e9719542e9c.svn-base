<?php
class action_block_notify_overdue extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('time', $data['time']);

    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'time' => (int) trim($this->getArgumentSecure($index.'_time'))
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }

    public function processCronMinute(Events_Event $event) {
        $event;

        $status = $this->_getStatus();
        $data = (Array) json_decode($this->getValue('data'));
        $minute = $data['time'];

        if (!$minute) {
            return;
        }

        $now = DateTime_Object::Now();
        // получить задачи с контролируемым этапом
        $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $orders->filterDateclosed('0000-00-00 00:00:00');
        $orders->filterStatusid($status->getId());
        $orders->addWhere('dateto', '0000-00-00 00:00:00', '<>');
        $orders->addWhere('dateto', $now->__toString(), '>');
        $orders->addWhere('dateto', $now->addMinute($minute), '<');

        while ($order = $orders->getNext()) {

            if (DateTime_Object::FromString($order->getDateto())->setFormat('H:i')->__toString() == '00:00') {
                continue;
            }

            $comment = new CommentsAPI_XComment();
            $comment->setKey('shop-order-'.$order->getId());
            $comment->setIp('status-'.$status->getId());
            if ($comment->getNext()) {
                continue;
            }

            $comment = "Крайник срок задачи определен ".$order->getDateto()." Осталось ".
                DateTime_Differ::DiffMinute($order->getDateto(), DateTime_Object::Now()).
                " минут до конечной даты ее выполнения.";

            try {
                $notify = Shop::Get()->getShopService()->addOrderNotify($order, false, $comment);
                $notify->setIp('status-'.$status->getId());
                $notify->update();
            } catch (Exception $e) {

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
}