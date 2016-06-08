<?php
class account_activate extends Engine_Class {

    public function process() {
        try {
            $email = $this->getArgumentSecure('email');
            $code = $this->getArgumentSecure('code');

            if (!$code || !$email) {
                throw new ServiceUtils_Exception();
            }

            $user = Shop::Get()->getUserService()->activateUser(
                $email,
                $code
            );

            $this->setValue('message', 'ok');
            $this->setValue('userLogin', $user->getLogin());
        } catch(Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}