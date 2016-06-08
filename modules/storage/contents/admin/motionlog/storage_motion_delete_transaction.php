<?php
class storage_motion_delete_transaction extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            // один из товаров в перемещении
            $storageProduct = StorageService::Get()->getStorageByID(
            $this->getArgument('id')
            );

            if ($storageProduct->getAmount() < 0) {
                // разрешено править только прямые записи
                throw new ServiceUtils_Exception();
            }
            
            $transaction = StorageService::Get()->getStorageTransactionByID($storageProduct->getTransactionid());

            if ($this->getControlValue('ok')) {
                try {
                    StorageService::Get()->deleteStorageTransaction(
                    $transaction,
                    $cuser
                    );

                    $this->setValue('message', 'ok');
                    $this->setValue('urlredirect', Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-motion-list'));
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }

            $this->setValue('urlcancel', Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-motion-view', $storageProduct->getId()));

            // информация о транзакции

            // список товаров перемещения
            $storage = StorageService::Get()->getStorageMotion(
            $cuser,
            $storageProduct->getTransactionid()
            );

            $sum = 0;
            while ($x = $storage->getNext()) {
                $sum += $x->getAmount() * $x->getPricebase();
            }
            $this->setValue('sum', $sum);

            // валюта по умолчанию
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('currency', $currencyDefault->getSymbol());

            $this->setValue('date', DateTime_Formatter::DateTimeRussianGOST($storageProduct->getDate()));
            $this->setValue('type', $storageProduct->makeType());
            $this->setValue('isReturn', $storageProduct->getReturn());

            $storageNameFrom = StorageNameService::Get()->getStorageNameByID($transaction->getStoragenamefromid());
            $storageNameTo = StorageNameService::Get()->getStorageNameByID($transaction->getStoragenametoid());

            $this->setValue('storagenamefrom', $storageNameFrom->getName());
            $this->setValue('storagenamefromURL', $storageNameFrom->makeURLMotionlog());
            $this->setValue('storagenameto', $storageNameTo->getName());
            $this->setValue('storagenametoURL', $storageNameTo->makeURLMotionlog());

            try {
                $this->setValue('username', $storageProduct->getUser()->getName());
            } catch (ServiceUtils_Exception $se) {

            }

            // если продажа
            if ($storageProduct->getType() == 'sale') {
                try {
                    $orderProduct = Shop::Get()->getShopService()->getOrderProductById($storageProduct->getOrderproductid());
                    $order = Shop::Get()->getShopService()->getOrderByID($orderProduct->getOrderid());

                    $this->setValue('orderid', $order->getId());
                    $this->setValue('orderURL', $order->makeURLEdit());
                    $this->setValue('client', $order->getClientname());
                    $this->setValue('clientphone', $order->getClientphone());
                    $this->setValue('clientaddress', $order->getClientaddress());
                    $this->setValue('clientemail', $order->getClientemail());
                } catch (ServiceUtils_Exception $se) {

                }
            }

            // ссылка на журнал
            $this->setValue('urlMotion', Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-admin-storage-motion-view',
            $storageProduct->getId()
            ));
            
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}