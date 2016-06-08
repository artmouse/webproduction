<?php
class orders_payment extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            $user = $this->getUser();

            $this->setValue('orderid', $order->getId());
            $this->setValue('orderName', $order->makeName());

            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_platezhi_').$order->makeName()
            );

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'finance');
            $this->setValue('block_menu', $menu->render());

            // блок платежей
            $block_payments = Engine::Get()->GetContentDriver()->getContent('shop-finance-payment-block');
            $block_payments->setValue('linkkey', 'order-'.$order->getId());
            $this->setValue('block_payments', $block_payments->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}