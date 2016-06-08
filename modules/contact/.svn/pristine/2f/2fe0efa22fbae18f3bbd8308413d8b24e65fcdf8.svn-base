<?php
class users_delete extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
                $this->getArgument('id')
            );

            $currentUser = $this->getUser();

            $this->setValue('userid', $user->getId());

            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure(
                    'translate_udalenie_polzovatelya_'
                ).$user->getId()
            );

            // проверка прав пользователя на управление пользователем
            if (!Shop::Get()->getUserService()->isUserChangeAllowed($user, $currentUser)) {
                throw new ServiceUtils_Exception('Access denied');
            }

            if ($this->getControlValue('ok')) {
                try {
                    Shop::Get()->getUserService()->deleteUser($user, $currentUser);

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            } else {
                $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
                $menu->setValue('selected', 'delete');
                $menu->setValue('userid', $user->getId());
                $this->setValue('menu', $menu->render());
            }
        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}