<?php
class orders_log extends Engine_Class {

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
            $menu->setValue('selected', 'log');
            $this->setValue('block_menu', $menu->render());

            // информация о просмотре заказа
            $log = Shop::Get()->getShopService()->getOrderLogViews($order);
            $a = array();
            $b = array();
            while ($x = $log->getNext()) {
                try {
                    $b[] = array(
                        'date' => $x->getCdate(),
                        'name' => Shop::Get()->getUserService()->getUserByID($x->getUserid())->makeName(),
                    );
                } catch (Exception $e) {

                }

                try {
                    if (!isset($a[$x->getUserid()])) {
                        $a[$x->getUserid()] = array(
                            'name' => Shop::Get()->getUserService()->getUserByID($x->getUserid())->makeName(),
                            'start' => $x->getCdate(),
                        );
                    } else {
                        $a[$x->getUserid()]['end'] = $x->getCdate();
                    }
                } catch (Exception $e) {

                }
            }
            $this->setValue('logViewArray', $a);
            $this->setValue('logArray', $b);

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}