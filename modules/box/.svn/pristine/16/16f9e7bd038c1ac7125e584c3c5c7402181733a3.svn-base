<?php
class project_products extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID($this->getArgument('id'));
            $user = $this->getUser();

            // заголовок страницы
            Engine::GetHTMLHead()->setTitle($order->makeName());

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'products');
            $this->setValue('block_menu', $menu->render());

            // записываем в лог, что я посмотрел заказ
            Shop::Get()->getShopService()->addOrderLogView($order, $user);

            $block_product_list = Engine::GetContentDriver()->getContent(
                'shop-admin-orders-control-block-product-list'
            );
            $this->setValue('block_product_list', $block_product_list->render());

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            $this->setValue('canEdit', $canEdit);
        } catch (Exception $ge) {
            if ($ge->getMessage() == 'access') {
                Engine::Get()->getRequest()->setContentID(403);
            } else {
                Engine::Get()->getRequest()->setContentNotFound();
            }
        }
    }

}