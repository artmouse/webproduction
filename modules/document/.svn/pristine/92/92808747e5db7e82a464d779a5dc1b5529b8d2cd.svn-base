<?php
class orders_document extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            $user = $this->getUser();

            $this->setValue('orderid', $order->getId());
            $this->setValue('orderName', $order->makeName());

            Engine::GetHTMLHead()->setTitle('Документы заказа '.$order->makeName());

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'document');
            $this->setValue('block_menu', $menu->render());

            // блок документов
            Engine::GetURLParser()->setArgument('filterorderid', $order->getId());
            $block_documents = Engine::Get()->GetContentDriver()->getContent('shop-admin-document-list-block');
            $block_documents->setValue('linkkey', $order->getClassname().'-'.$order->getId());
            $this->setValue('block_documents', $block_documents->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}