<?php
class orders_delete extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            if ($order->getType() == 'project') {
                $this->setValue('isProject', 1);
            } elseif ($order->getType() == 'issue') {
                $this->setValue('isIssue', 1);
            }

            $user = $this->getUser();

            $this->setValue('orderid', $order->getId());

            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_udalenie_zakaza_').$order->getId()
            );

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception('access');
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'delete');
            $this->setValue('block_menu', $menu->render());

            if ($this->getControlValue('ok')) {
                try {
                    Shop::Get()->getShopService()->deleteOrder($order);
                    $this->setValue('orderReferer', @$_SESSION['order-referer']);

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            if ($ge->getMessage() == 'access') {
                Engine::Get()->getRequest()->setContentID(403);
            } else {
                Engine::Get()->getRequest()->setContentNotFound();
            }
        }
    }

}