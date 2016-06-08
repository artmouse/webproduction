<?php
class auth_remindpassword extends Engine_Class {

    public function process() {
        if ($this->isUserAuthorized()) {
            header('Location: /');
        }

        Engine::GetHTMLHead()->setMetaTag('robots', 'noindex, follow');

        if ($this->getControlValue('ok')) {
            try {
                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }
                if (!$this->getControlValue('login')) {
                    throw new ServiceUtils_Exception('login_empty');
                }

                Shop::Get()->getUserService()->remindPassword(
                    $this->getControlValue('login')
                );

                $this->setValue('message', 'ok');
            } catch (Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errors', $e->getMessage());
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }
    }

}