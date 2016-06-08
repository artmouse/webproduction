<?php
class workflow_filter_block extends Engine_Class {

    public function process() {
        $a = array();

        $workflow = Shop::Get()->getShopService()->getWorkflowsActive(
        $this->getUser()
        );

        $statusSelectedArray = $this->getArgumentSecure('statusid', 'array');
        $workflowSelectedArray = $this->getArgumentSecure('workflowid', 'array');

        $issueFilter = $this->getValue('issueFilter');
        if ($issueFilter) {
            $workflow->addWhereQuery("id IN (SELECT categoryid FROM shoporder WHERE ".$issueFilter->makeWhereString().")");
        }

        while ($w = $workflow->getNext()) {
            $statusArray = array();

            $status = $w->getStatuses();
            while ($s = $status->getNext()) {
                $statusArray[] = array(
                'id' => $s->getId(),
                'name' => $s->makeName(),
                'color' => $s->getColour(),
                'selected' => in_array($s->getId(), $statusSelectedArray),
                );
            }

            $a[] = array(
            'id' => $w->getId(),
            'name' => $w->makeName(),
            'selected' => in_array($w->getId(), $workflowSelectedArray),
            'statusArray' => $statusArray,
            );
        }

        $this->setValue('workflowArray', $a);
    }

}