<?php
class project_info extends Engine_Class {

    public function process() {
        try{
            $order = Shop::Get()->getShopService()->getOrderByID($this->getArgument('id'));
            // заголовок страницы
            Engine::GetHTMLHead()->setTitle($order->makeName());

            // текущий авторизированный пользователь
            $user = $this->getUser();

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'info');
            $this->setValue('block_menu', $menu->render());

            // записываем в лог, что я посмотрел заказ
            Shop::Get()->getShopService()->addOrderLogView($order, $user);

            $block_info = Engine::GetContentDriver()->getContent('admin-project-block-info');
            $this->setValue('block_info', $block_info->render());

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $this->getUser());
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