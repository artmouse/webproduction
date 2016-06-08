<?php
class issue_delete extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );
            $this->setValue('makeUrl', $order->makeURLEdit());

            $type = $this->getArgument('type');
            $this->setValue('type', $type);
            $this->setValue('typeName', $order->getTypeName());

            if ($order->getType() == 'project') {
                $this->setValue('isProject', 1);
            } elseif ($order->getType() == 'issue') {
                $this->setValue('isIssue', 1);
            }

            $user = $this->getUser();

            if ($user->isDenied($type)) {
                // вычисляем путь к шаблону
                $templateName = Engine::Get()->getConfigFieldSecure('shop-template');
                $templatePath = PackageLoader::Get()->getProjectPath().'/templates/'.$templateName.'/';

                $this->setField('filehtml', $templatePath.'/error/error_deny.html');
                $this->setField('filephp', false);
                return;
            }

            $this->setValue('orderid', $order->getId());

            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_udalenie_').
                $order->getTypeName().' #'.$order->getId()
            );

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
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

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}