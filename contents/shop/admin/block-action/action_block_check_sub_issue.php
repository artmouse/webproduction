<?php
class action_block_check_sub_issue extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));
    }

    public function processData() {
        $index = $this->getValue('index');

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

        $status = $this->_getStatus();
        $status->setNeedcontent(1);
        $status->update();
    }

    public function processStatus(Events_Event $event) {
        $order = $this->_getOrder($event);

        $change = new XShopOrderChange();
        $change->setOrderid($order->getId());
        $change->setKey('statusid');
        $change->setOrder('id', 'DESC');

        // этот говнокод получает предыдущий статус
        $tmpChange = $change->getNext();

        if (!$tmpChange) {
            return;
        }

        $change = $change->getNext();

        if (!$change) {
            return;
        }

        try {
            $oldStatus = Shop::Get()->getShopService()->getStatusByID($change->getValue());

            $tmp = Shop::Get()->getShopService()->getOrdersAll(false, true);
            $tmp->setParentid($order->getId());
            $tmp->setParentstatusid($oldStatus->getId());
            $tmp->setDateclosed('0000-00-00 00:00:00');
            $tmp->setLimitCount(1);
            if ($tmp->getNext()) {
                throw new ServiceUtils_Exception('issue-stop');
            }

        } catch (Exception $estatus) {

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


}