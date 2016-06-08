<?php
class action_block_change_status_overdue_dateto extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        // список статустов
        $status = $this->_getStatus();

        $statuses = $status->getWorkflow()->getStatuses();

        $statusArray = array();
        while ($x = $statuses->getNext()) {

            if ($x->getId() == $status->getId()) {
                continue;
            }

            $statusArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );
        }

        $this->setValue('statusArray', $statusArray);

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('statusid', $data['status']);
    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'status' => $this->getArgumentSecure($index.'_status')
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
        $statusId = $data['status'];
        if (!$statusId) {
            return;
        }

        $now = DateTime_Object::Now();
        // получить задачи с контролируемым этапом
        $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $orders->filterDateclosed('0000-00-00 00:00:00');
        $orders->filterStatusid($status->getId());
        $orders->addWhere('dateto', '0000-00-00 00:00:00', '<>');
        $orders->addWhere('dateto', $now->__toString(), '<');

        while ($order = $orders->getNext()) {
            try {
                Shop::Get()->getShopService()->updateOrderStatus(
                    $order->getManagerOrAuthor(),
                    $order,
                    $statusId
                );
            } catch (Exception $emanager) {
                try {
                    Shop::Get()->getShopService()->updateOrderStatus(
                        false,
                        $order,
                        $statusId
                    );
                } catch (Exception $emanager2) {

                }
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