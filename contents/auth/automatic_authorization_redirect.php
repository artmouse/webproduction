<?php
class automatic_authorization_redirect extends Engine_Class {

    public function process() {
        try {
            $redirect = $this->getArgument('redirect');
            try {
                $user = Shop::Get()->getUserService()->getUserByIdentifier($this->getArgument('identifier'));
                // логиним только если level = 1
                if ($user->getLevel() != 1) {
                    throw new Exception('bad level');
                }
                // автоматически логиним пользователя
                $user = Shop::Get()->getUserService()->automaticalLogin($user);
            } catch (Exception $ee) {

            }

            header('Location: '.Engine::GetLinkMaker()->makeURLByContentID($redirect));
            exit();

        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}