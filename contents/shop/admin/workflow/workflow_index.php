<?php

class workflow_index extends Engine_Class {

    public function process() {
        $isBox = Engine::Get()->getConfigFieldSecure('project-box');
        $this->setValue('box', $isBox);

        // set content title
        Engine_HTMLHead::Get()->setTitle(Shop_TranslateService::Get()->getTranslate('translate_biznes_protsessi'));

        if ($this->getArgumentSecure('add')) {
            try {
                $name = $this->getArgument('name', 'string');

                if (!$name) {
                    throw new ServiceUtils_Exception();
                }

                $tmp = new ShopOrderCategory();
                $tmp->setName($name);
                $tmp->setType($this->getArgumentSecure('type'));
                if ($tmp->select()) {
                    throw new ServiceUtils_Exception();
                }

                $tmp->insert();

                $this->setValue('urlredirect', $tmp->makeURL());

                $this->setValue('message', 'ok');
            } catch (Exception $e) {
                $this->setValue('message', 'error');
            }
        }

        $workflowTypeArray = array();
        $workflowType = new XShopWorkflowType();
        while ($x = $workflowType->getNext()) {
            $workflowTypeArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'type' => $x->getType(),
            );
        }

        $this->setValue('workflowTypeArray', $workflowTypeArray);

        // Ответственныe сотрудники
        $responsibleArray = array();
        $responsible = new User();
        $responsible->setEmployer(1);
        $responsible->setOrder('name');
        while ($x = $responsible->getNext()) {
            if ($x->makeName()) {
                $responsibleArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                );
            }
        }
        $this->setValue('responsibleArray', $responsibleArray);
        
        $workflows = Shop::Get()->getShopService()->getWorkflowsAll();
        $workflows->setOrder('id', 'DESC');
        if ($this->getControlValue('title')) {
            $workflows->addWhere('name', "%" . $this->getControlValue('title') . "%", "LIKE");
        }
        if ($this->getControlValue('filterworkflowtype')) {
            $type = new XShopWorkflowType(($this->getControlValue('filterworkflowtype')));
            $workflows->setType($type->getType());
        }
        if ($this->getControlValue('filterresponsible')) {
            $workflows->setManagerid($this->getControlValue('filterresponsible'));
        }
        if ($this->getControlValue('keywords')) {
            $workflows->addWhere('keywords', "%" . $this->getControlValue('keywords') . "%", "LIKE");
        }

        $table = new Shop_ContentTable(new Datasource_Workflow($workflows));

        $field = new Forms_ContentFieldControlLink('name', 'shop-workflow-edit', 'id');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_workflow'));

        $this->setValue('table', $table->render());
    }

}