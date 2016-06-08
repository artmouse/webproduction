<?php
class action_block_manager_change extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        // список менеджеров
        $a = array();
        $manager = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $manager->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(true, 'lfm'),
            );
        }
        $this->setValue('managerArray', $a);

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('managerid', $data['manager']);
    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'manager' => $this->getArgumentSecure($index.'_managerid')
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );

        $status = $this->_getStatus();
        $status->setManagerid($this->getArgumentSecure($index.'_managerid'));
        $status->update();
    }

    public function processDataDelete() {
        $status = $this->_getStatus();
        $status->setManagerid(0);
        $status->update();
    }

    public function processStatus(Events_Event $event) {
        $order = $this->_getOrder($event);
        $status = $this->_getStatus($event);
        $user = $this->_getUser($event);

        $data = (Array) json_decode($this->getValue('data'));

        $jumpManager = false;

        // прыжок на автора
        if ($status->getManagerid() == -1) {
            try {
                $jumpManager = $order->getAuthor();
            } catch (Exception $e) {

            }
        } else {
            try {
                $managerID = $data['manager'];
                $jumpManager = Shop::Get()->getUserService()->getUserByID($managerID);
            } catch (Exception $workflowEx) {

            }
        }

        if ($jumpManager) {
            Shop::Get()->getShopService()->updateOrderManager(
                $order,
                $user,
                $jumpManager
            );
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