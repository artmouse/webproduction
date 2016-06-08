<?php
class workflow_type_add extends Engine_Class {

    public function process() {
        try {
            if ($this->getArgumentSecure('ok')) {
                try{
                    $ex = new ServiceUtils_Exception();

                    $name = $this->getControlValue('name');
                    $type = $this->getControlValue('type');

                    $type = trim($type);
                    $type = strtolower($type);
                    $type = StringUtils_Transliterate::TransliterateRuToEn($type);
                    $type = preg_replace("/[^a-z0-9-_\s]/ius", '', $type);
                    $type = preg_replace("/\s+/ius", '-', $type);
                    $type = strtolower($type);

                    if (!$name) {
                        $ex->addError('name');
                    }

                    if (!$type) {
                        $ex->addError('type');
                    } else {
                        // проверка типа на уникальность
                        $workflowType = new XShopWorkflowType();
                        $workflowType->setType($type);
                        if ($workflowType->select()) {
                            $ex->addError('typeUnique');
                        }
                    }

                    if ($ex->getCount()) {
                        throw $ex;
                    }


                    $workflowType = new XShopWorkflowType();
                    $workflowType->setType($type);
                    $workflowType->setName($name);
                    $workflowType->setContentId($this->getArgumentSecure('contentId'));
                    $workflowType->setTypeaddpage($this->getControlValue('addtype'));
                    $workflowType->insert();

                    $this->setValue('message', 'ok');

                } catch (ServiceUtils_Exception $ee) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorArray', $ee->getErrorsArray());
                }

            }

        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}