<?php
class action_block_notice_overdue_dateto extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));
    }

    public function processData() {
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

    public function processCronMinute(Events_Event $event) {
        $event;

        $status = $this->_getStatus();

        $now = DateTime_Object::Now();
        // получить задачи с контролируемым этапом
        $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $orders->filterDateclosed('0000-00-00 00:00:00');
        $orders->filterStatusid($status->getId());
        $orders->addWhere('dateto', '0000-00-00 00:00:00', '<>');
        $orders->addWhere('dateto', $now->__toString(), '<');

        while ($order = $orders->getNext()) {

            /*if (DateTime_Object::FromString($order->getDateto())->setFormat('H:i')->__toString() == '00:00') {
                continue;
            }*/

            $comment = new CommentsAPI_XComment();
            $comment->setKey('shop-order-'.$order->getId());
            $comment->setIp('status-'.$status->getId());
            if ($comment->getNext()) {
                continue;
            }

            $comment = "Крайник срок выполнения задачи определен на ".$order->getDateto()." Задача не выполнена!";

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