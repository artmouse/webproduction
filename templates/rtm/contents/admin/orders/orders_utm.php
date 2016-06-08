<?php
class orders_utm extends Engine_Class {

    public function process() {
        try{
            $id = $this->getArgument('id');
            $order = Shop::Get()->getShopService()->getOrderByID($id);

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'utm-label');
            $this->setValue('block_menu', $menu->render());

            $this->setValue('utm_campaign', urldecode($order->getUtm_campaign()));
            $this->setValue('utm_content', urldecode($order->getUtm_content()));
            $this->setValue('utm_term', urldecode($order->getUtm_term()));
            $this->setValue('utm_date', $order->getUtm_date() != '0000-00-00 00:00:00' ? $order->getUtm_date():false);
            $this->setValue('utm_referrer', urldecode($order->getUtm_referrer()));
            $this->setValue('utm_medium', urldecode($order->getUtm_medium()));
            $this->setValue('utm_source', urldecode($order->getUtm_source()));
        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}