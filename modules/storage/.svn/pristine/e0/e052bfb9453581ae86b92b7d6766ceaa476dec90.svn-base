<?php
class storage_reserve extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('JSPrototypeTableKit');

        // разрешены ли склады
        $allowStorage = Engine::Get()->getConfigFieldSecure('storage-status');
        if (!$allowStorage) return ;

        if ($this->getControlValue('ok')) {
            $a = array();
            try {
                $storageNameID = $this->getControlValue('storagenameid');
//                $storageName = false;
//                if ($storageNameID) {
                    $storageName = StorageService::Get()->getStorageNameByID($storageNameID);
//                }

                if (!StorageNameService::Get()->isStorageOperationAllowed($storageName, 'read')) {
                    throw new ServiceUtils_Exception('user');
                }

                $balance = StorageService::Get()->getStorageBalanceByRecalculation($storageName, $this->getUser());
                $a = array();

                while ($storageProduct = $balance->getNext()) {
                    try {
                        $product = $storageProduct->getProduct();
                        $amount = (float) $storageProduct->getAmount();
                        $reserve = (float) $product->getStoragereserve();
                        $lack = ($amount < $reserve);
                        $plenty = $percent = 0;
                        if ($reserve > 0) {
                            $plenty = (($amount / $reserve) > 2);
                            $percent = ((100 * $amount) / $reserve);
                        }

                        $a[] =  array(
                        'reserve' => $reserve,
                        'count' => $amount,
                        'name' => $product->getName(),
                        'productid' => $storageProduct->getProductid(),
                        'lack' => $lack,
                        'plenty' => $plenty,
                        'percent' => $percent
                        );
                    } catch (ServiceUtils_Exception $e) {

                    }
                }
                $this->setValue('productsArray', $a);

            } catch (ServiceUtils_Exception $eee) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $eee->getErrorsArray());

                if (PackageLoader::Get()->getMode('debug')) {
                    print $eee;
                }
            }
        }

        $storageNames = StorageService::Get()->getStorageNamesArrayByUser($this->getUser(), 'read');
        $this->setValue('storageNamesArray', $storageNames);
    }

}