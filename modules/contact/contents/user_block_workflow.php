<?php
class user_block_workflow extends Engine_Class {

    /**
     * @return User
     */
    private function _getUser() {
        return $this->getValue('user');
    }

    public function process() {
        $user = $this->_getUser();

        // получаем список ролей
        $titleArray = $user->getRoleArray();
        $titleArray[] = -1;

        // получаем массив ролей
        $role = RoleService::Get()->getRoleAll();
        $role->addWhereArray($titleArray, 'name');
        $roleIDArray = array(-1);
        while ($x = $role->getNext()) {
            $roleIDArray[] = $x->getId();
        }

        // получаем список этапов
        $statuses = Shop::Get()->getShopService()->getStatusAll();
        $statuses->addWhereArray($roleIDArray, 'roleid');
        $a = array();
        while ($x = $statuses->getNext()) {
            try {
                $workflow = $x->getWorkflow();

                $a[$x->getRoleid()][] = array(
                'name' => $x->getName(),
                'content' => $x->getContent(),
                'workflow' => $workflow->getName(),
                );
            } catch (Exception $e) {

            }
        }
        $this->setValue('workflowArray', $a);
    }

}