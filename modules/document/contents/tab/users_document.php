<?php
class users_document extends Engine_Class {

    public function process() {

        try {
            $user = Shop::Get()->getUserService()->getUserByID($this->getArgument('id'));

            Engine::GetHTMLHead()->setTitle('Документы пользователя '.$user->makeName());

            // меню
            $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
            $menu->setValue('selected', 'document');
            $menu->setValue('userid', $user->getId());
            $this->setValue('menu', $menu->render());

            // блок документов
            Engine::GetURLParser()->setArgument('filterclientid', $user->getId());
            $block_documents = Engine::Get()->GetContentDriver()->getContent('shop-admin-document-list-block');
            $block_documents->setValue('linkkey', $user->getClassname().'-'.$user->getId());
            $this->setValue('block_documents', $block_documents->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}