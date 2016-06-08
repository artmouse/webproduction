<?php
class storage_ajaxproduct_storage_list extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('query');

            $cuser = $this->getUser();

            $a = array();

            if ($query) {
                $products = StorageBalanceService::Get()->searchProducts($query, $cuser);
                $products->setLimitCount(50);
            } else {
                $storagenames = StorageNameService::Get()->getStorageNamesForSaleByUser($cuser);
                $storagenameIDArray = array();
                while ($storagename = $storagenames->getNext()) {
                    $storagenameIDArray[] = $storagename->getId();
                }

                $products = StorageBalanceService::Get()->getBalanceByForSearch(
                $cuser,
                $storagenameIDArray
                );
                
                $products->setLimitCount(50);
            }

            while ($sproduct = $products->getNext()) {
                try {
                    $product = Shop::Get()->getShopService()->getProductByID(
                    $sproduct->getProductid()
                    );

                    $a[] = array(
                    'id' => $sproduct->getProductid(),
                    'name' => $sproduct->getProductname(),
                    'amount' => $sproduct->getAmount(),
                    'serial' => $sproduct->getSerial(),
                    'balanceid' => $sproduct->getId(),
                    'price' => $product->getPrice(),
                    'currencyid' => $product->getCurrencyid(),
                    'currency' => $product->getCurrency()->getSymbol(),
                    'image' => $product->makeImageThumb(100, 100),
                    'unit' => $product->getUnit()
                    );
                } catch (ServiceUtils_Exception $se) {

                }
            }

            $this->setValue('productArray', $a);
        } catch (Exception $e) {

        }
    }

}