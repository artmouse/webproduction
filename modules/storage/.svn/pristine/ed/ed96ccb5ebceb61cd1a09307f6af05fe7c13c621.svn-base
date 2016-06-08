<?php
class orders_storage extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            $user = $this->getUser();

            $this->setValue('orderid', $order->getId());
            $this->setValue('orderName', $order->makeName());

            Engine::GetHTMLHead()->setTitle('Склады '.$order->makeName());

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'storage');
            $this->setValue('block_menu', $menu->render());

            // блок складов
            $block_storage = Engine::Get()->GetContentDriver()->getContent('shop-admin-storage-motion-block-list');
            $block_storage->setValue('orderid', $order->getId());
            $this->setValue('block_storage', $block_storage->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}