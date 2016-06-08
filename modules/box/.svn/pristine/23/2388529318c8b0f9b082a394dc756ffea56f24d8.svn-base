<?php
class order_event extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            $user = $this->getUser();

            // заголовок страницы
            Engine::GetHTMLHead()->setTitle($order->makeName());

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'event');
            $this->setValue('block_menu', $menu->render());

            try {
                $client = $order->getClient();

                $block = Engine::GetContentDriver()->getContent('event-list-block');
                $block->setValue('events', $client->getEvents());
                $this->setValue('block_event', $block->render());
            } catch (Exception $e) {

            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}