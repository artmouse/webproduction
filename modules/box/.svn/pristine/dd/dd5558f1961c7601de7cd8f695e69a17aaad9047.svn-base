<?php
class file_control extends Engine_Class {

    public function process() {
        try {
            PackageLoader::Get()->registerJSFile('/_js/dropzone.min.js');
            PackageLoader::Get()->registerJSFile('/_js/dropuploader.js');

            // получаем файл
            $file = Shop::Get()->getFileService()->getFileByID(
            $this->getArgument('id')
            );

            // текущий авторизированный пользователь
            $cuser = $this->getUser();

            $menuOK = false;
            if (preg_match("/^order-(\d+)$/ius", $file->getKey(), $r)) {
                $orderID = $r[1];

                try {
                    $order = Shop::Get()->getShopService()->getOrderByID($orderID);

                    $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
                    $menu->setValue('order', $order);
                    $menu->setValue('selected', 'file');
                    $this->setValue('block_menu', $menu->render());

                    $menuOK = true;
                } catch (ServiceUtils_Exception $se) {

                }
            }

            if (!$menuOK) {
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($file->getUserid());

                    $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
                    $menu->setValue('selected', 'edit');
                    $menu->setValue('userid', $user->getId());
                    $this->setValue('block_menu', $menu->render());
                } catch (ServiceUtils_Exception $se) {

                }
            }

            if ($this->getControlValue('ok')) {
                try {
                    if ($this->getControlValue('delete')) {
                        Shop::Get()->getFileService()->deleteFile($cuser, $file);
                    }

                    if ($this->getControlValue('file')) {
                        $files = $this->getControlValue('file', 'array');

                        $path = $files['tmp_name'];
                        $name = $files['name'];
                        $type = $files['type'];

                        Shop::Get()->getFileService()->editFile($cuser, $file, $path, $type);
                    }
                } catch (Exception $e) {

                }
            }

            if (substr_count($file->getContenttype(), 'image/')) {
                $this->setValue('imageURL', $file->makeURL());
            }

            $this->setValue('name', $file->getName());
            $this->setValue('downloadURL', $file->makeURL());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}