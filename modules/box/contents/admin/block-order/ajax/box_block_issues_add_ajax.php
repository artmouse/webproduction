<?php
class box_block_issues_add_ajax extends Engine_Class {

    public function process() {
        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers($this->getUser());
        while ($x = $managers->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(true, 'lfm'),
            );
        }
        $this->setValue('managerArray', $a);

        $a = array();
        $workflows = Shop::Get()->getShopService()->getWorkflowsActive($this->getUser());
        while ($x = $workflows->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
            );
        }
        $this->setValue('workflowArray', $a);

        $this->setValue('time', time());
    }


}