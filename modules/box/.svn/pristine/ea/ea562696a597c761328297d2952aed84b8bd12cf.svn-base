<?php
class orders_files extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            $cuser = $this->getUser();

            // заголовок страницы
            Engine::GetHTMLHead()->setTitle($order->makeName());

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $cuser)) {
                throw new ServiceUtils_Exception();
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'file');
            $this->setValue('block_menu', $menu->render());

            $files = Shop::Get()->getFileService()->getFilesAll();
            $files->setKey('order-'.$order->getId());

            Engine::GetURLParser()->setArgument('filterlinkname', $order->makeName());
            Engine::GetURLParser()->setArgument('filterlink', $order->getId());

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