<?php
class admin_sub_workflow_block extends Engine_Class {

    public function process() {
        try {
            $status = Shop::Get()->getShopService()->getStatusByID(
                $this->getArgument('id')
            );
            if ($this->getArgumentSecure('send_edit')) {
                // делаем backup записей
                $this->_backupFile($status);

                $arguments = $this->getArguments();


                $count = 0;
                foreach ($arguments as $argumentKey => $argument) {

                    if (strpos($argumentKey, 'subworkflowId') === 0) {
                        try{
                            $count++;
                            $subWorkflowIndex = str_replace('subworkflowId', '', $argumentKey);

                            $subWorkflowID = $argument;
                            $subWorkflowName = $this->getArgument('subworkflowName'.$subWorkflowIndex);

                            $subWorkflowDate = $this->getArgument('subworkflowDate'.$subWorkflowIndex);
                            $subWorkflowDescription = $this->getArgument('subworkflowDescription'.$subWorkflowIndex);
                            $sort = $this->getArgumentSecure('subworkflowSort'.$subWorkflowIndex);

                            $subWorkflow = new XShopOrderStatusSubWorkflow();
                            $subWorkflow->setStatusid($status->getId());

                            if ($sort) {
                                $subWorkflow->setSort($sort);
                            } else {
                                $subWorkflow->setSort($count);
                            }

                            if (!$subWorkflow->select()) {
                                $subWorkflow->insert();
                            }

                            $subWorkflow->setSubworkflowid($subWorkflowID);
                            $subWorkflow->setSubworkflowname($subWorkflowName);
                            $subWorkflow->setSubworkflowdate($subWorkflowDate);
                            $subWorkflow->setSubworkflowdescription($subWorkflowDescription);
                            $subWorkflow->update();

                        } catch (Exception $ee) {

                        }

                    }
                }

                $status->setNo_communication($this->getControlValue('noCommunication'));
                $status->setNo_communication_call($this->getControlValue('noCommunicationCall'));
                $status->setNo_communication_email($this->getControlValue('noCommunicationEmail'));
                $status->setAutorepeat($this->getControlValue('autorepeat'));
                $status->setNextdate($this->getControlValue('nextdate'));
                $status->update();
            }

            $a = array();
            $b = array();
            $c = array();
            $d = array();

            $subWorkflow = new XShopOrderStatusSubWorkflow();
            $subWorkflow->setStatusid($status->getId());
            $subWorkflow->setOrder('sort');

            $filledCount = 0;
            while ($x = $subWorkflow->getNext()) {
                $sort = $x->getSort();
                $a[$sort] = $x->getSubworkflowid();
                $b[$sort] = $x->getSubworkflowname();
                $c[$sort] = $x->getSubworkflowdate();
                $d[$sort] = $x->getSubworkflowdescription();

                // количество заполненых строк
                if ($x->getSubworkflowid() || $x->getSubworkflowname()
                    || $x->getSubworkflowdate() || $x->getSubworkflowdescription()
                ) {
                    $filledCount++;
                }
            }

            $fullCount = count($a);
            // Добавляем 10 новых колонок
            if ($fullCount == $filledCount && !($filledCount % 10)) {
                for ($i = 0; $i < 10; $i++) {
                    $a[count($a)+1] = 0;
                }
            }

            $this->setValue('subworkflowArray', $a);
            $this->setValue('subworkflowNameArray', $b);
            $this->setValue('subworkflowDateArray', $c);
            $this->setValue('subworkflowDescriptionArray', $d);

            // список workflow
            $workflow = Shop::Get()->getShopService()->getOrderCategoryAll();
            $a = array();
            while ($x = $workflow->getNext()) {
                $a[$x->getId()] = $x->makeName();
            }
            $this->setValue('workflowArray', $a);

            $this->setControlValue('noCommunication', $status->getNo_communication());
            $this->setControlValue('noCommunicationCall', $status->getNo_communication_call());
            $this->setControlValue('noCommunicationEmail', $status->getNo_communication_email());
            $this->setControlValue('autorepeat', $status->getAutorepeat());
            $this->setControlValue('nextdate', $status->getNextdate());

        } catch (Exception $e) {

        }
    }

    private function _backupFile (ShopOrderStatus $status) {
        $text = '';
        $subWorkflow = new XShopOrderStatusSubWorkflow();
        $subWorkflow->setStatusid($status->getId());
        $subWorkflow->setOrder('sort');

        while ($x = $subWorkflow->getNext()) {
            if ($x->getSubworkflowid() || $x->getSubworkflowname()
                || $x->getSubworkflowdate() || $x->getSubworkflowdescription()
            ) {
                $text.='№ '.$x->getSort()."\r\n";
                if ($x->getSubworkflowid()) {
                    $text.=Shop::Get()->getTranslateService()->getTranslateSecure('translate_biznesprotsess_').
                        $x->getSubworkflowid()."\r\n";
                }

                if ($x->getSubworkflowname()) {
                    $text.=Shop::Get()->getTranslateService()->getTranslateSecure('translate_imya_zadachi_').
                        $x->getSubworkflowname()."\r\n";
                }

                if ($x->getSubworkflowdate()) {
                    $text.=Shop::Get()->getTranslateService()->getTranslateSecure('translate_smeshchenie_v_dnyah_').
                        $x->getSubworkflowdate()."\r\n";
                }

                if ($x->getSubworkflowdescription()) {
                    $text.=Shop::Get()->getTranslateService()->getTranslateSecure('translate_opisanie_').
                        $x->getSubworkflowdescription()."\r\n\r\n";
                }
            }
        }

        file_put_contents(
            PackageLoader::Get()->getProjectPath().'/media/backup/workflow/workflowStatus'.
            $status->getId().'_'.DateTime_Object::Now()->setFormat('YmdHis').'.txt',
            $text,
            LOCK_EX
        );
    }

}