<?php
class action_block_role extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $status = $this->_getStatus();

        // список ролей
        $this->setValue('roleArray', RoleService::Get()->makeRoleListArray());

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('roleid', $data['role']);

    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'role' => $this->getArgumentSecure($index.'_roleid')
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );

        $status = $this->_getStatus();
        $status->setRoleid($this->getArgumentSecure($index.'_roleid'));
        $status->update();
    }

    public function processDataDelete() {
        $status = $this->_getStatus();
        $status->setRoleid(0);
        $status->update();
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