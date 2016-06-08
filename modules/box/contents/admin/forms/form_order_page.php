<?php
class form_order_page extends Engine_Class {

    public function process() {
        try {
            
            $projectId = $this->getArgument('id');
            $formId = $this->getArgument('key');
            
            $form = FormSettingsService::Get()->getFormSettingsByID($formId);
            
            $this->setValue('formname', $form->getName());
            $this->setValue('formdescription', $form->getDescription());
            
            $logoImage = false;
            $host = Engine::Get()->getProjectURL();

            $phones = Shop::Get()->getSettingsService()->getSettingValue('header-phone');
            $phones = str_replace(';', ',', $phones);
            $phones = str_replace(',,', ',', $phones);
            $phones = explode(',', $phones);
            $email = Shop::Get()->getSettingsService()->getSettingValue('header-email');
         
            $formItem = FormSettingsService::Get()->getFormItemsByIdForm($formId);
            $formItem->setOrderBy('sort');           
            $data = array();       
            while ($f = $formItem->getNext()) {
                    $a = array();
                    $a['id'] = $f->getId();
                    $a['formid'] = $f->getFormid();
                    $a['title'] = $f->getName();
                    $a['description'] = $f->getDescription();
                    $a['type'] = $f->getType();
                    $a['required'] = $f->getRequired();
                    $a['name'] = $f->getType()."_".$f->getId();  
                    $a['value'] =
                        htmlspecialchars($this->getControlValue($f->getType()."_".$f->getId()));               
                    $data[] = $a;
            }
            $this->setValue('fieldArray', $data);
            
            try {
                $logo = Shop::Get()->getShopService()->getLogoCurrent();
                $logoImage = $logo->makeImage();
                $imageSize = getimagesize(PackageLoader::Get()->getProjectPath().$logoImage);

                if ($imageSize[0] > 60 || $imageSize[1] > 500) {
                    $logoImage = ImageProcessor_Thumber::MakeThumbProportional(
                        PackageLoader::Get()->getProjectPath().$logoImage, 500, 60
                    );
                    $logoImage = str_replace(PackageLoader::Get()->getProjectPath(), '', $logoImage);
                }
            } catch (Exception $elogo) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $elogo;
                }
            }

            $this->setValue('logosrc', $logoImage);
            $this->setValue('host', $host);
            $this->setValue('phones', $phones);
            $this->setValue('email', $email);    
            $string = '';

            if ($this->getArgumentSecure('ok')) {
                $string .= "\nРезультат заполнения формы ".$form->getName().":\n";
                $formData = FormSettingsService::Get()->getFormItemsByIdForm($formId);
                $formData->setOrderBy('sort');
                $isPut = false;
                
                $order = Shop::Get()->getShopService()->getOrderByID($projectId);

                if ($order->getClient()) {
                    $user = $order->getClient();
                } else {
                    $user = $order->getManager();
                }
                
                while ($x = $formData->getNext()) {
                    $item = $this->getControlValue($x->getType()."_".$x->getId());
                    if ($x->getRequired() && !$item) {
                        throw new Exception("field");
                    }
                    $values = new XShopFormsSettingsValue();
                    $values->setFormid($formId);
                    $values->setProjectid($projectId);
                    $values->setUserid($user->getId());
                    $values->setCdate(DateTime_Object::Now()->setFormat('Y-m-d H:i:s')->__toString());
                    $values->setFieldid($x->getId());
                    $values->setValue($item);
                    $values->insert();
                    
                    if ($x->getType() == 'checkbox') {
                        if ($item) {
                            $item = Shop::Get()->getTranslateService()->getTranslate('translate_yes');
                        } else {
                            $item = Shop::Get()->getTranslateService()->getTranslate('translate_no');
                        }
                    }
                    $string .= $x->getName()." : ".$item."\n";
                    
                    $isPut = true;
                }
                if ($isPut) {
                    $order = Shop::Get()->getShopService()->getOrderByID($projectId);

                    if ($order->getClient()) {
                        $user = $order->getClient();
                    } else {
                        $user = $order->getManager();
                    }
                    try {
                        Shop::Get()->getShopService()->addOrderResult(
                            $order,
                            $user,
                            $string
                        ); 
                    } catch (Exception $ex) {
                        
                    }
                }
                $this->setValue('message', 'ok');
            }
            
            $formItem = FormSettingsService::Get()->getFormItemsByIdForm($formId);
            $formItem->setOrderBy('sort');
            $data = array();
            while ($f = $formItem->getNext()) {
                    $a = array();
                    $a['id'] = $f->getId();
                    $a['formid'] = $f->getFormid();
                    $a['title'] = $f->getName();
                    $a['description'] = $f->getDescription();
                    $a['type'] = $f->getType();
                    $a['required'] = $f->getRequired();                
                    $a['name'] = $f->getType()."_".$f->getId();                
                    $a['value'] = 
                        htmlspecialchars($this->getControlValue($f->getType()."_".$f->getId()));                    
                    $data[] = $a;
            }
           
            $this->setValue('fieldArray', $data);

        } catch (Exception $ex) {
            if ($ex->getMessage() == 'field') {
                $this->setValue('message', 'field');
            } else {
                $this->setValue('message', 'error');
            }
        }
        
    }

}