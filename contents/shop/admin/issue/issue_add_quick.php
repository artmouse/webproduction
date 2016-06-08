<?php
class issue_add_quick extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('addissueok')) {
            $name = $this->getControlValue('newname');
            $content = $this->getControlValue('newcontent');
            $managerID = $this->getControlValue('newmanagerid');
            $workflowID = $this->getControlValue('newworkflowid');
            $dateto = $this->getControlValue('newdateto');

            try {
                $issue = IssueService::Get()->addIssue(
                $this->getUser(),
                $name,
                $content,
                $managerID,
                $workflowID,
                $dateto,
                false,
                $this->getValue('projectid')
                );
            } catch (Exception $issueAddEx) {

            }
        }

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
        if ($typeArray = $this->getValue('typeArray')) {
            $workflows->addWhereArray($typeArray, 'type');
        }
        while ($x = $workflows->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            );
        }
        $this->setValue('workflowArray', $a);
    }

}