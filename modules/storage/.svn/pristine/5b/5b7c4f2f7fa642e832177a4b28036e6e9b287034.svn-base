<?php
class storage_order_totransfer extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $order = StorageOrderService::Get()->getStorageOrderByID(
            $this->getArgument('id')
            );
            
            if (!$cuser->isAllowed('storage-transfer')) {
                throw new ServiceUtils_Exception();
            }

            $this->setValue('orderid', $order->getId());

            if ($transfer = StorageTransferService::Get()->getTransfersByUser($cuser)->getNext()) {
                // если в корзине прихода уже есть товары

                if ($this->getControlValue('okempty')) {
                    // удалить старые товары из корзины, чтобы добавить новые
                    StorageTransferService::Get()->clearTransfers($cuser);
                } elseif (!$this->getControlValue('okadd')) {
                    // если не выбран пункт добавить в корзину еще
                    // выдаем сообщение о том, что корзина не пуста
                    $this->setValue('message', 'basketNotEmpty');

                    try {
                        $this->setValue('basketStorageName', $transfer->getStorageName()->getName());
                    } catch (ServiceUtils_Exception $be) {}

                    return ;
                }
            }

            $orderProducts = StorageOrderService::Get()->getStorageOrderProductsNotShipped($order);
            $added = false;
            $alreadyInBasket = false;

            $storageName = false;
            try {
                $storageName = $order->getStorageNameFrom();
            } catch (ServiceUtils_Exception $se) {}

            if ($storageName) {
                // добавляем каждый товар заказа в перемещение
                try {
                    SQLObject::TransactionStart();

                    while ($orderProduct = $orderProducts->getNext()) {
                        try {
                            $transfers = StorageTransferService::Get()->getTransfersByUser($cuser);
                            $transfers->setStorageorderproductid($orderProduct->getId());

                            if (!$transfers->getNext()) {
                                StorageTransferService::Get()->addTransfer(
                                $cuser,
                                $storageName->getId(),
                                $orderProduct->getProductid(),
                                false,
                                $orderProduct->getAmount(),
                                $orderProduct->getId()
                                );

                                $added = true;
                            } else {
                                $alreadyInBasket = true;
                            }
                        } catch (ServiceUtils_Exception $se) {

                        }
                    }
                    
                    SQLObject::TransactionCommit();
                } catch (Exception $ge) {
                    SQLObject::TransactionRollback();
                }
                
            } else {
                // не выбран склад, с которого будет перемещение
                $this->setValue('message', 'noStorageName');

                $this->setValue('urlredirect', Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-admin-storage-order-control',
                $order->getId()
                ));
            }

            if ($added) {
                $this->setValue('message', 'ok');

                $this->setValue('urlredirect', str_replace('&amp;', '&', Engine::GetLinkMaker()->makeURLByContentIDParams(
                'shop-admin-storage-transfer',
                array(
                'storagetoid' => $order->getStoragenametoid()
                ))));
            } elseif ($alreadyInBasket) {
                $this->setValue('message', 'alreadyInBasket');

                $this->setValue('urlredirect', str_replace('&amp;', '&', Engine::GetLinkMaker()->makeURLByContentIDParams(
                'shop-admin-storage-transfer',
                array(
                'storagetoid' => $order->getStoragenametoid()
                ))));
            } elseif ($storageName) {
                $this->setValue('message', 'error');
            }

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}