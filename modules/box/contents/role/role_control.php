<?php
class role_control extends Engine_Class {

    public function process() {
        $key = $this->getArgumentSecure('key');
        if ($key) {
            try{
                $role = RoleService::Get()->getRoleByID($key);
                if ($this->getControlValue('formsUpdate')) {
                    try {
                        SQLObject::TransactionStart();
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
                        $role->update();
                        SQLObject::TransactionCommit();
                    } catch (Exception $e) {
                        SQLObject::TransactionRollback();
                    }
                }
                if ($this->getControlValue('formsDelete')) {
                    try {
                        SQLObject::TransactionStart();
                        $role->delete();
                        SQLObject::TransactionCommit();
                        header('Location:'.Engine::GetLinkMaker()->makeURLByContentID('shop-admin-role'));
                    } catch (Exception $ex) {
                        SQLObject::TransactionRollback();
                    }
                }
               
                for ($i=1; $i<=10; $i++) {
                    $info = array();
                    $info['kpiid'] = $role->getField('kpi'.$i.'id');
                    $info['kpiparam'] = $role->getField('kpi'.$i.'param');
                    $info['kpivalue'] = $role->getField('kpi'.$i.'value');
                    $info['salaryworkflow'] = $role->getField('salary'.$i.'workflow');
                    $info['salarykoef'] = $role->getField('salary'.$i.'koef');
                    $arrayRoleControlValue[$i] = $info;
                }
                $this->setControlValue('name', $role->getName());
                $this->setControlValue('description', $role->getDescription());
                $this->setControlValue('blockcolor', $role->getBlockcolor());
                $this->setControlValue('parentid', $role->getParentid());
                $this->setValue('arrayRoleControlValue', $arrayRoleControlValue);
                
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
            } catch (Exception $ne) {
                Engine::Get()->getRequest()->setContentNotFound();
            }
        }
    }
}