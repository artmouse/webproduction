<?php
class structure_index extends Engine_Class {

    public function process() {
        $block = Engine::GetContentDriver()->getContent('structure-block');
        $block->setValue('parentid', 0);
        $this->setValue('block_structure', $block->render());

        // выводим всех сотрудников списком
        $employer = Shop::Get()->getUserService()->getUsersAll();
        $employer->setEmployer(1);
        $a = array();
        while ($x = $employer->getNext()) {
            $employerRoleArray = array();
            $employerWorkflowArray = array();
            $employerIssueArray = array();

            try {
                $roleArray = $x->getRoleArray();
                $roleArray[] = -1;

                $role = RoleService::Get()->getRoleAll();
                $role->addWhereArray($roleArray, 'name');
                while ($r = $role->getNext()) {
                    $employerRoleArray[] = $r->getName();

                    $status = Shop::Get()->getShopService()->getStatusAll();
                    $status->setRoleid($r->getId());
                    while ($s = $status->getNext()) {
                        try {
                            $employerWorkflowArray[] = $s->getWorkflow()->getName().' / '.$s->makeName();
                        } catch (Exception $workflowEx) {

                        }
                    }
                }
            } catch (Exception $e) {

            }

            $a[] = array(
            'id' => $x->getId(),
            'namefirst' => $x->getName(),
            'namelast' => $x->getNamelast(),
            'namemiddle' => $x->getNamemiddle(),
            'phoneArray' => $x->getPhoneArray(),
            'emailArray' => $x->getEmailArray(),
            'url' => $x->makeURLEdit(),
            'workflowArray' => $employerWorkflowArray,
            'roleArray' => $employerRoleArray,
            );
        }
        $this->setValue('employerArray', $a);
    }

}