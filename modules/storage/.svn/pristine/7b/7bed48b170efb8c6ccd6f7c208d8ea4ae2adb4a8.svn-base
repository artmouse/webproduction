<?php
class storage_order_toincoming extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            if (!$cuser->isAllowed('storage-incoming')) {
                throw new ServiceUtils_Exception();
            }

            $this->setValue('orderid', $order->getId());

            if (StorageIncomingService::Get()->getIncomingsByUser($cuser)->getNext()) {
                // если в корзине прихода уже есть товары

                if ($this->getControlValue('okempty')) {
                    // удалить старые товары из корзины, чтобы добавить новые
                    StorageIncomingService::Get()->clearIncomings($cuser);
                } elseif (!$this->getControlValue('okadd')) {
                    // если не выбран пункт добавить в корзину еще
                    // выдаем сообщение о том, что корзина не пуста
                    $this->setValue('message', 'basketNotEmpty');
                    return ;
                }
            }

            // добавить товары в корзину оприходования
            $added = StorageIncomingService::Get()->moveOrderToIncoming($cuser, $order);

            if ($added) {
                $this->setValue('message', 'ok');
                $this->setValue('urlredirect', str_replace('&amp;', '&', Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-incoming')));
            } else {
                $this->setValue('message', 'error');
            }

        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}