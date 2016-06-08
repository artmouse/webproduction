<?php
class user_files extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
            $this->getArgument('id')
            );

            if (!Shop::Get()->getUserService()->isUserChangeAllowed($user, $this->getUser())) {
                throw new ServiceUtils_Exception('user');
            }

            Engine::GetHTMLHead()->setTitle($user->makeName());

            $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
            $menu->setValue('selected', 'file');
            $menu->setValue('userid', $user->getId());
            $this->setValue('block_menu', $menu->render());

            $files = Shop::Get()->getFileService()->getFilesAll();
            $files->setUserid($user->getId());

            Engine::GetURLParser()->setArgument('filterauthorid', $user->getId());

            $block = Engine::GetContentDriver()->getContent('admin-file-block-list');
            $block->setValue('files', $files);
            $this->setValue('block_file', $block->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}