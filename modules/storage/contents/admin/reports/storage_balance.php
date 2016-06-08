<?php
class storage_balance extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('JSPrototypeTableKit');
        try {
            $cuser = $this->getUser();

            // фильтры
            $productID = (int) $this->getControlValue('productid');
            $productname = $this->getControlValue('productname');
            $categoryID = $this->getControlValue('categoryid');

            $product = false;
            if ($productID) {
                try {
                    $product = Shop::Get()->getShopService()->getProductByID($productID);
                } catch (ServiceUtils_Exception $se) {

                }
            }

            $category = false;
            if ($categoryID) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID($categoryID);
                } catch (ServiceUtils_Exception $se) {

                }
            }

            // определяем склад текущего перемещения пользователя (если оно есть)
            try {
                $transfer = StorageTransferService::Get()->getTransferCurrentByUser(
                $cuser
                );

                $transferStorageNameID = $transfer->getStoragenamefromid();
            } catch (ServiceUtils_Exception $se) {
                $transferStorageNameID = 0;
            }

            // если выбран склад
            if ($storageNameID = $this->getArgumentSecure('storagenameid')) {
                try {
                    $storageName = StorageNameService::Get()->getStorageNameByID(
                    $storageNameID
                    );

                    // возможно ли перемещение
                    if (StorageNameService::Get()->isStorageOperationAllowed(
                    $cuser,
                    $storageName,
                    'transferfrom')
                    &&
                    (!$transferStorageNameID || $transferStorageNameID == $storageNameID)
                    ) {
                        $this->setValue('canTransfer', true);
                    }

                    // получаем баланс по складу
                    $storages = StorageBalanceService::Get()->getBalanceByStorage(
                    $storageName,
                    $cuser,
                    $product,
                    $productname,
                    $category
                    );

                    $a = array();
                    while ($x = $storages->getNext()) {
                        try {
                            $a[] = array(
                            'amount' => (float) $x->getAmount(),
                            'amountlinked' => (float) $x->getAmountlinked(),
                            'name' => $x->getProduct()->getName(),
                            'productid' => $x->getProductid(),
                            'sum' => $x->getField('cost')
                            );

                        } catch (Exception $se) {

                        }
                    }

                    $this->setValue('productsArray', $a);
                } catch (ServiceUtils_Exception $se) {
                    //print $se;

                }
            }

            // склады
            $storageNames = StorageNameService::Get()->getStorageNamesByUser(
            $cuser,
            'read'
            );

            $storageNamesArray = array();
            while ($storageName = $storageNames->getNext()) {
                $storageNamesArray[] = array(
                'id' => $storageName->getId(),
                'name' => $storageName->getName(),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('storagenameid' => $storageName->getId())),
                'selected' => ($storageName->getId() == $storageNameID)
                );
            }

            $this->setValue('storageNamesArray', $storageNamesArray);

            // категории
            $categories = Shop::Get()->getShopService()->getCategoryAll();
            $this->setValue('categoryArray', $categories->toArray());

            // текущий склад
            $this->setValue('storagenameid', $storageNameID);

            $this->setValue('urltransfer', Engine::GetLinkMaker()->makeURLByContentID('shop-admin-storage-transfer'));

            // текущая валюта
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('currency', $currencyDefault->getSymbol());

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
    }

}