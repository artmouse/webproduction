<?php
class action_block_status_change extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $status = $this->_getStatus();

        $data =json_decode($this->getValue('data'));

        // список бизнес процессов
        $workflows = Shop::Get()->getShopService()->getWorkflowsAll($this->getUser());
        $workflowId = $status->getCategoryid();
        $nextWorkflowArray = array();
        while ($x = $workflows->getNext()) {
            // наш workflow не берем
            if ($workflowId == $x->getId()) {
                continue;
            }

            $nextWorkflowArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );
        }

        $this->setValue('nextWorkflowArray', $nextWorkflowArray);
        $this->setValue('nextworkflowid', $data->nextworkflowid);
        $this->setValue('nextstatusid', $data->nextstatusid);
    }

    public function processData() {
        $index = $this->getValue('index');

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode(
                array(
                    'nextworkflowid' => $this->getArgumentSecure($index.'_nextworkflowid'),
                    'nextstatusid' => $this->getArgumentSecure($index.'_nextstatusid')
                )
            )
        );
    }

    public function processStatus(Events_Event $event) {
        $status = $this->_getStatus();
        $order = $this->_getOrder($event);
        $user = $this->_getUser($event);

        $data = json_decode($this->getValue('data'));

        try {
            $workflow = Shop::Get()->getShopService()->getOrderCategoryByID(
                $data->nextworkflowid
            );

            $order->setCategoryid($workflow->getId());
            $order->setOutcoming($workflow->getOutcoming());
            $order->update();

            $statusID = $data->nextstatusid;
            if (!$statusID) {
                $statusID = $workflow->getStatusDefault()->getId();
            }

            Shop::Get()->getShopService()->updateOrderStatus($user, $order, $statusID);
        } catch (Exception $es) {

        }
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
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

}