<?php
class storage_ajaxproduct_passport_list extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('query');

            $a = array();

            if ($query) {
                $passports = StorageProductionService::Get()->searchPassports($query);
                $passports->setLimitCount(50);
            } else {
                $passports = StorageProductionService::Get()->getProductPassportsValid();
            }

            while ($passport = $passports->getNext()) {
                try {
                    $targetArray = array();
                    $items = StorageProductionService::Get()->getProductPassportItemsTargetByPassport($passport);
                    while ($item = $items->getNext()) {
                    	$product = $item->getProduct();
                        
                        $targetArray[] = array(
                    	'id' => $item->getProductid(),
                    	'name' => $product->getName(),
                    	'amount' => $item->getAmount(),
                    	'unit' => $product->getUnit()
                    	);
                    }
                    
                    $a[] = array(
                    'id' => $passport->getId(),
                    'name' => $passport->getName(),
                    'targetArray' => $targetArray
                    );
                } catch (ServiceUtils_Exception $se) {

                }
            }

            $this->setValue('productArray', $a);
        } catch (Exception $e) {

        }
    }

}