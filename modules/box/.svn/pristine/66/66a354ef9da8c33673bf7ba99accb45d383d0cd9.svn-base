<?php
class forms_index extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('add')) {
            try {
                $name = $this->getArgument('name', 'string');
                if (!$name) {
                    throw new Exception('name');
                }
                $tmp = FormSettingsService::Get()->getFormSettingsAll();
                $tmp->setName($name);             
                if ($tmp->select()) {
                    throw new Exception('name');
                }
                if ($this->getArgumentSecure('description')) {
                    $tmp->setDescription($this->getArgumentSecure('description'));
                }
                $tmp->insert();
                $this->setValue('message', 'ok');
                
                $url = Engine::GetLinkMaker()->makeURLByContentID('shop-forms-settings-edit');
                header('Location: /admin/forms/'.$tmp->getId().'/edit/', true, 301);
            } catch (Exception $e) {
                if ($e->getMessage() == 'name') {
                    $this->setValue('message', 'name');
                }
                
            }
        }

        $table = new Shop_ContentTable(new Datasource_FormsSettings());
        $field = new Forms_ContentFieldControlLink('name', 'shop-forms-settings-edit', 'id');
        $table->addField($field);     
        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_forma'));
        $this->setValue('table', $table->render());
    }

}