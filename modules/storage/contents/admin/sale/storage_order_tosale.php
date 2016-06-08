<?php
class storage_order_tosale extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            $this->setValue('orderid', $order->getId());

            if ($this->getControlValue('select')) {
                try {
                    SQLObject::TransactionStart();

                    if (StorageSaleService::Get()->getSalesByUser($cuser)->getNext()) {
                        // если в корзине уже есть товары

                        if ($this->getControlValue('okempty')) {
                            // удалить старые товары из корзины, чтобы добавить новые
                            StorageSaleService::Get()->clearSales($cuser);
                        } else {
                            // выдаем сообщение о том, что корзина не пуста
                            $this->setValue('message', 'basketNotEmpty');
                            throw new ServiceUtils_Exception();
                        }
                    }

                    // добавляем товары заказа в корзину отгрузки
                    $added = StorageSaleService::Get()->moveOrderToSale(
                    $cuser,
                    $order,
                    $this->getControlValue('storagefromid')
                    );

                    SQLObject::TransactionCommit();

                    if ($added) {
                        $this->setValue('message', 'ok');

                        $this->setValue(
                        'urlredirect',
                        Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-sale')
                        );
                    } else {
                        $this->setValue('message', 'error');
                        $this->setValue('errorsArray', $ex->getErrorsArray());
                    }
                } catch (Exception $ge) {
                    SQLObject::TransactionRollback();
                }
            }

            // все склады с которых можно продавать
            $storageNames = StorageNameService::Get()->getStorageNamesForSaleByUser(
            $cuser
            );
            $this->setValue('storagesfromArray', $storageNames->toArray());

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}