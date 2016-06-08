<?php
class ticket_index extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/dropzone.min.js');
        PackageLoader::Get()->registerJSFile('/_js/dropuploader.js');
        if ($this->getArgumentSecure('ok')) {
            try {  
                $message = 'Ф.И.О.: '.$this->getControlValue('name')."\n";
                $message .= 'Email: '.$this->getControlValue('email')."\n";
                if ($this->getControlValue('phone')) {
                    $message .=
                        Shop::Get()->getTranslateService()->getTranslateSecure('translate_telefon_').
                        $this->getControlValue('phone')."\n";
                }
                $message .= 'Project host: '.Engine::Get()->getProjectURL()."\n\n";
                $message .= 'Cообщение'.  $this->getControlValue('message')."\n";
                $emailTo = 'support@webproduction.ua';
                $subject = 'projecthost OneBox support request';
                $fileIDArray = $this->getArgumentSecure('fileid', 'array');                
                if ($fileIDArray) {
                    foreach ($fileIDArray as $fileID) {
                        try {                            
                            $file = Shop::Get()->getFileService()->getFileByID($fileID);
                            $fileAttachedArray[] = array(
                                'name' => $file->getName(),
                                'type' => $file->getContenttype(),
                                'tmp_name' => $file->makePath(),
                            );
                        } catch (ServiceUtils_Exception $fse) {

                        }
                    }
                }
                Shop::Get()->getUserService()->sendEmail(
                    $this->getControlValue('email'),
                    $emailTo, 
                    $subject,
                    $message,
                    'text',
                    $fileAttachedArray,
                    Shop::Get()->getShopService()->getMailTemplate()
                );

                $this->setValue('message', 'ok');
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $e->getErrorsArray());
            }
        }

        $this->setValue('branding', Engine::Get()->getConfigFieldSecure('project-branding'));

        try {
            $user = $this->getUser();
            if ($email = $user->getEmail()) {
                $this->setControlValue('email', $email);
            } else {
                $this->setControlValue('email', Shop::Get()->getSettingsService()->getSettingValue('header-email'));
            }
            if ($phone = $user->getPhoneSMS()) {
                $this->setControlValue('phone', $phone);  
            }
            
        } catch (Exception $e) {

        }

    }
    
}