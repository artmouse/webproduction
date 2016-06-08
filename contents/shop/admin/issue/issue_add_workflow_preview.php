<?php
class issue_add_workflow_preview extends Engine_Class {

    public function process() {
        try {
            $workflow = Shop::Get()->getShopService()->getOrderCategoryByID(
                $this->getArgument('workflowid')
            );

            $block = Engine::GetContentDriver()->getContent('issue-workflow-preview');
            $block->setValue('workflow', $workflow);

            $statusArray = array();
            $statuses = $workflow->getStatuses();
            while ($s = $statuses->getNext()) {
                $statusArray[] = array(
                    'id' => $s->getId(),
                    'name' => $s->getName(),
                    'default' => $s->getDefault()
                );
            }

            try {
                $statusDefaultID = $workflow->getStatusDefault()->getId();
            } catch (Exception $e) {
                $statusDefaultID = 0;
            }

            echo json_encode(
                array(
                    'userid' => $workflow->getManagerid(),
                    'html' => $block->render(),
                    'statusArray' => $statusArray,
                    'statusDefaultID' => $statusDefaultID,
                )
            );
        } catch (Exception $ge) {

        }

        exit();
    }

}