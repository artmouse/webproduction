<?php
class role_add extends Engine_Class {

    public function process() {
        if ($this->getControlValue('formsInsert')) {
            try {
                SQLObject::TransactionStart();
                $role = new XShopRole();
                $role->setName($this->getControlValue('name'));
                $role->setDescription($this->getControlValue('description'));
                $role->setBlockcolor($this->getControlValue('blockcolor'));
                $role->setParentid($this->getControlValue('parentid'));
                for ($i=1; $i<=10; $i++) {
                    $role->setField('kpi'.$i.'id', $this->getControlValue('kpi'.$i.'id'));
                    $role->setField('kpi'.$i.'param', $this->getControlValue('kpi'.$i.'param'));
                    $role->setField('kpi'.$i.'value', $this->getControlValue('kpi'.$i.'value'));
                    $role->setField('salary'.$i.'workflowid', $this->getControlValue('salary'.$i.'workflowid'));
                    $role->setField('salary'.$i.'koef', $this->getControlValue('salary'.$i.'koef'));
                }
                $role->insert();
                SQLObject::TransactionCommit();
            } catch (Exception $e) {
                SQLObject::TransactionRollback();
            }
        }
        $arrayRole = RoleService::Get()->makeRoleListArray();
        $this->setValue('arrayRole', $arrayRole);
        $kpiall = KPIService::Get()->getKPIAll();
        $arrayKpi = array();
        while ($x = $kpiall->getNext()) {
            $info = array();
            $info['id'] = $x->getId();
            $info['name'] = $x->getName();
            $arrayKpi[] = $info;
        }
        $this->setValue('arrayKpi', $arrayKpi);
        $workflow = Shop::Get()->getShopService()->getWorkflowsAll();
        $arrayWorkflow = array();
        while ($x = $workflow->getNext()) {
            $info = array();
            $info['id'] = $x->getId();
            $info['name'] = $x->getName();
            $arrayWorkflow[] = $info;
        }
        $this->setValue('arrayWorkflow', $arrayWorkflow);
        $this->setValue('arrayid', array(1,2,3,4,5,6,7,8,9,10));
    }
}