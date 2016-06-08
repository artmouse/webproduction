<?php
class forms_index_edit extends Engine_Class {

    public function process() {
        try {
            $formId = $this->getArgument('id');
            $this->setValue('formid', $formId);
        
            $form = FormSettingsService::Get()->getFormSettingsByID($formId);
            
            $formItems = FormSettingsService::Get()->getFormItemsByIdForm($formId);
            
            if ($this->getArgumentSecure('send_edit')) {
                if (!$this->getArgumentSecure('name')) {
                    throw new Exception('name');
                }
                $form->setName($this->getArgumentSecure('name'));
                $form->setDescription($this->getArgumentSecure('description'));
                $form->update();
                
                // редактирование 
                while ($x = $formItems->getNext()) {
                    if ($this->getArgumentSecure("delete_{$x->getId()}")) {
                        $x->delete();
                    } else {
                        // обновляем элемент                           
                        $x->setName($this->getArgumentSecure('name_'.$x->getId()));
                        $x->setDescription($this->getArgumentSecure('description_'.$x->getId()));
                        $x->setType($this->getArgumentSecure('type_'.$x->getId()));                       
                        $x->setRequired($this->getArgumentSecure('required_'.$x->getId()));                      
                        $x->setSort($this->getArgument('sort_'.$x->getId()));
                        $x->update();  
                    }
                }
                
                if ($this->getArgumentSecure('item-name')) {
                    $x = new XShopFormsSettingsItem();                   
                    $x->setOrder('sort', $type = 'DESC');
                    $x->setLimitCount(1);
                    $s = $x->getNext();
                    $default = false;
                    if ($s) {
                        $maxSort = $s->getSort();
                        $maxSort++;
                    } else {
                        $default = true;
                        $maxSort = 1;
                    }
                    $formItem = new XShopFormsSettingsItem();
                    $formItem->setSort($maxSort);
                    $formItem->setName($this->getArgumentSecure('item-name'));
                    $formItem->setDescription($this->getArgumentSecure('item-description'));
                    $formItem->setType($this->getArgumentSecure('typeforms'));
                    $formItem->setRequired($this->getArgumentSecure('required'));
                    $formItem->setFormid($formId);
                    $formItem->insert();
                }
                
                $this->setValue('edit_ok', true);
            }

            $this->setValue('name', $form->getName());
            $this->setValue('description', $form->getDescription());
            $formItems->setOrderBy('sort');
            $this->setValue('elementArray', $formItems->toArray());
            
        } catch (Exception $ex) {
            if ($ex->getMessage() == 'name') {
                $this->setValue('message', 'name');
            } else {
                $this->setValue('message', 'error');
            }
        }
        
    }

}