<?php
class workflow_type_edit extends Engine_Class {

    public function process() {
        try {
            $id = $this->getArgument('id');
            $workflowType = new XShopWorkflowType($id);

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
                        $workflowTypeTmp = new XShopWorkflowType();
                        $workflowTypeTmp->addWhere('id', $id, '<>');
                        $workflowTypeTmp->setType($type);
                        $workflowTypeTmp = $workflowTypeTmp->getNext();
                        if ($workflowTypeTmp) {
                            $ex->addError('typeUnique');
                        }
                    }

                    if ($ex->getCount()) {
                        throw $ex;
                    }

                    $workflowType->setType($type);
                    $workflowType->setName($name);
                    $workflowType->setContentId($this->getArgumentSecure('contentId'));
                    $workflowType->setMultiplename($this->getControlValue('mname'));
                    $workflowType->setIcon($this->getControlValue('icon'));
                    $workflowType->setTypeaddpage($this->getControlValue('addtype'));
                    $workflowType->update();

                    $this->setValue('message', 'ok');

                } catch (ServiceUtils_Exception $ee) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorArray', $ee->getErrorsArray());
                }

            }

            if ($this->getArgumentSecure('delete')) {
                $workflowType->delete();
                header('Location: /admin/shop/workflowtype/');
                exit;
            }

            $this->setControlValue('name', $workflowType->getName());
            $this->setControlValue('contentId', $workflowType->getContentId());
            $this->setControlValue('type', $workflowType->getType());
            $this->setControlValue('addtype', $workflowType->getTypeaddpage());
            $this->setControlValue('icon', $workflowType->getIcon());
            $this->setControlValue('mname', $workflowType->getMultiplename());
        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}