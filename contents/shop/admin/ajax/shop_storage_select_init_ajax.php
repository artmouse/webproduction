<?php
class shop_storage_select_init_ajax extends Engine_Class {

    public function process() {
        $orderProduct = Shop::Get()->getShopService()->getOrderProductById(
            $this->getArgumentSecure('orderproductid')
        );

        $product = $orderProduct->getProduct();

        $storageArray = false;
        if (Shop_ModuleLoader::Get()->isImported('storage')) {
            // считаем количество на складе

            $storages = StorageNameService::Get()->getStorageNamesForSale();
            $storages->setOrder('id');
            while ($storage = $storages->getNext()) {
                $balance = StorageBalanceService::Get()->getBalanceByProductForReserve(
                    $product,
                    $this->getUser(),
                    $storage->getId()
                )->getNext();

                if ($balance) {
                    try {
                        $storageArray[$storage->getId()] = array(
                            'id' => $balance->getId(),
                            'name' => $balance->getStorageName()->getName(),
                            'count' => round($balance->getAmountAvailable(), 3),
                            'selected' => $orderProduct->getStorageid() == $balance->getId() ? true:false
                        );

                    } catch (Exception $balanceEx) {

                    }
                }
            }
        }

        echo json_encode($storageArray);
        exit;
    }

}