<?php
class storage_passport_table_block extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();
            $passport = StorageProductionService::Get()->getProductPassportByID(
            $this->getValue('passportid')
            );            

            // товары 
            if ($this->getValue('istarget')) {
                $items = StorageProductionService::Get()->getProductPassportItemsTargetByPassport(
                $passport
                );
            } else {
                $items = StorageProductionService::Get()->getProductPassportItemsMaterialByPassport(
                $passport
                );
            }

            $productArray = array();
            while ($item = $items->getNext()) {
                try {
                    $product = $item->getProduct();

                    $productArray[] = array(
                    'id' => $item->getId(),
                    'count' => $item->getAmount(),
                    'name' => $product->getName(),
                    'productid' => $product->getId(),
                    'unit' => $product->getUnit()
                    );
                } catch (Exception $e) {

                }
            }

            // массив товаров
            $this->setValue('productArray', $productArray);
            $this->setValue('passportid', $passport->getId());
        } catch (Exception $ge) {

        }
    }

}