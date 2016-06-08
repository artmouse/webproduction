<?php
class storage_barcode_read extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();

        // добавление в приход товаров по штрих-кодам
        if ($this->getControlValue('toincoming')) {
            try {
                SQLObject::TransactionStart();
                
                if (!$cuser->isAllowed('storage-incoming')) {
                    throw new ServiceUtils_Exception('permission');
                }

                $productIDArray = $this->getArgumentSecure('id', 'array');

                $added = false;

                foreach ($productIDArray as $productID) {

                    try {
                        $product = Shop::Get()->getShopService()->getProductByID($productID);

                        // добавляем товар в приходную накладную
                        StorageIncomingService::Get()->addIncoming(
                        $cuser,
                        $product->getId(),
                        false,
                        ((int)$product->getDivisibility() > 0)?$product->getDivisibility():1,
                        $product->getPrice(),
                        $product->getCurrencyid(),
                        false,
                        false,
                        false,
                        false,
                        false
                        );

                        $added = true;
                    } catch (ServiceUtils_Exception $e) {

                    }
                }

                SQLObject::TransactionCommit();

                if ($added) {
                    $this->setValue('message', 'ok');

                    $this->setValue('urlredirect', Engine::GetLinkMaker()->makeURLByContentID(
                    'shop-admin-storage-incoming'
                    ));
                }

            } catch (ServiceUtils_Exception $ge) {
                SQLObject::TransactionRollback();

                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $ge->getErrorsArray());

                if (PackageLoader::Get()->getMode('debug')) {
                    print $ge;
                }
            }
        }

        // добавление в перемещение товаров по штрих-кодам
        if ($this->getControlValue('totransfer')) {
            try {
                SQLObject::TransactionStart();
                
                if (!$cuser->isAllowed('storage-transfer')) {
                    throw new ServiceUtils_Exception('permission');
                }

                $productIDArray = $this->getArgumentSecure('id', 'array');

                $added = false;

                foreach ($productIDArray as $productID) {

                    try {
                        $product = Shop::Get()->getShopService()->getProductByID($productID);

                        // добавляем товар в приходную накладную
                        StorageTransferService::Get()->addTransfer(
                        $cuser,
                        $this->getControlValue('storagefromid'),
                        $product->getId(),
                        false,
                        ((int)$product->getDivisibility() > 0)?$product->getDivisibility():1,
                        false
                        );

                        $added = true;
                    } catch (ServiceUtils_Exception $e) {

                    }
                }

                SQLObject::TransactionCommit();

                if ($added) {
                    $this->setValue('message', 'ok');

                    $this->setValue('urlredirect', Engine::GetLinkMaker()->makeURLByContentID(
                    'shop-admin-storage-transfer'
                    ));
                }

            } catch (ServiceUtils_Exception $ge) {
                SQLObject::TransactionRollback();

                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $ge->getErrorsArray());

                if (PackageLoader::Get()->getMode('debug')) {
                    print $ge;
                }
            }
        }
        
        // добавление в быстру продажу товаров по штрих-кодам
        if ($this->getControlValue('tosale')) {
            try {
                SQLObject::TransactionStart();
                
                if (!$cuser->isAllowed('storage-sale-quick')) {
                    throw new ServiceUtils_Exception('permission');
                }

                $productIDArray = $this->getArgumentSecure('id', 'array');

                $added = false;

                foreach ($productIDArray as $productID) {

                    try {
                        $product = Shop::Get()->getShopService()->getProductByID($productID);

                        // добавляем товар в приходную накладную
                        StorageSaleService::Get()->addSaleQuick(
                        $cuser,
                        $this->getControlValue('storagefromid'),
                        $product->getId(),
                        ((int)$product->getDivisibility() > 0)?$product->getDivisibility():1,
                        $product->getPrice(),
                        $product->getCurrencyid()
                        );

                        $added = true;
                    } catch (ServiceUtils_Exception $e) {

                    }
                }

                SQLObject::TransactionCommit();

                if ($added) {
                    $this->setValue('message', 'ok');

                    $this->setValue('urlredirect', Engine::GetLinkMaker()->makeURLByContentID(
                    'shop-admin-storage-sale-quick'
                    ));
                }

            } catch (ServiceUtils_Exception $ge) {
                SQLObject::TransactionRollback();

                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $ge->getErrorsArray());

                if (PackageLoader::Get()->getMode('debug')) {
                    print $ge;
                }
            }
        }
        
        // все склады с которых можно перемещать
        $storageNames = StorageNameService::Get()->getStorageNamesForTransferFromByUser(
        $cuser
        );
        $this->setValue('storagesfromArray', $storageNames->toArray());
        
        // все склады с которых можно перемещать
        $storageNames = StorageNameService::Get()->getStorageNamesForSaleByUser(
        $cuser
        );
        $this->setValue('storageSaleArray', $storageNames->toArray());
        
        $this->setValue('incomingAllowed', $cuser->isAllowed('storage-incoming'));
        $this->setValue('transferAllowed', $cuser->isAllowed('storage-transfer'));
        $this->setValue('saleAllowed', $cuser->isAllowed('storage-sale-quick'));
    }

}