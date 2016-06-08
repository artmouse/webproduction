<?php

class auth_registration extends Engine_Class
{

    public function process() {
        if ($this->isUserAuthorized()) {
            header('Location: /');
        }
        if ($this->getControlValue('ok')) {
            try {
                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                $user = Shop::Get()->getUserService()->addUser(
                    '',
                    $this->getControlValue('password'),
                    $this->getControlValue('email'),
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $this->getArgumentSecure('zakon') // distribution
                );

                if (Shop::Get()->getSettingsService()->getSettingValue('user-account-activate')) {
                    $this->setValue('message', 'activate');
                } else {

                    $login = $user->getLogin();
                    if (!$login) {
                        $login = $user->getEmail();
                    }

                    Shop::Get()->getUserService()->login(
                        $login,
                        $this->getControlValue('password')
                    );
                    $this->setValue('message', 'ok');
                    $this->setValue(
                        'linkclientprofile',
                        Engine::Get()->getProjectURL().
                        Engine::GetLinkMaker()->makeURLByContentID('shop-client-profile')
                    );
                }

                $this->setValue(
                    'registration_good_message', 
                    Shop::Get()->getSettingsService()->getSettingValue('registration-good-message')
                );
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $e->getErrorsArray());
            }
        }

        $this->setValue('used_user_info', Shop::Get()->getSettingsService()->getSettingValue('used-user-info'));
    }

}