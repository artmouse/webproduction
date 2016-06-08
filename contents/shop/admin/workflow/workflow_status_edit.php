<?php
class workflow_status_edit extends Engine_Class {

    public function process() {
        try {
            $isBox = Engine::Get()->getConfigFieldSecure('project-box');
            $this->setValue('box', $isBox);

            $statusID = $this->getArgument('id');
            $status = WorkflowService::Get()->getStatusByID($statusID);
            $this->setValue('statusid', $statusID);
            $this->setValue('name', $status->makeName());

            $category = $status->getWorkflow();

            // set workflow status name as title
            Engine_HTMLHead::Get()->setTitle($status->makeName() . ' - ' . $category->makeName());

            // сохранение формы
            if ($this->getArgumentSecure('send_edit')) {
                try {
                    $status->setName($this->getControlValue('name'));
                    $status->setColour($this->getControlValue('colour'));

                    if ($isBox) {
                        $status->setContent($this->getControlValue('description'));
                        $status->setProcessorform($this->getControlValue('processorform'));
                    }

                    $status->update();

                    $this->setValue('edit_ok', true);
                } catch (ServiceUtils_Exception $e) {
                    Engine::GetURLParser()->setArgument('error', 1);
                    $this->setValue('error_edit', $e->getErrors());
                }
            }

            $this->setControlValue('name', htmlspecialchars($status->getName()));
            $this->setControlValue('colour', $status->getColour());

            $this->setValue('categoryid', $category->getId());
            $this->setValue('categoryName', $category->makeName());


            if ($isBox) {
                $this->setControlValue('description', $status->getContent());
                $this->setControlValue('processorform', $status->getProcessorform());


                $a = Engine::Get()->getConfigFieldSecure('box-workflow-smart-contents');
                $this->setValue('processorFormArray', $a);
            }
        } catch (Exception $e) {
            print $e;
        }
    }

}