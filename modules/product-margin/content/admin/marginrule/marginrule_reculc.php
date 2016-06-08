<?php

class marginrule_reculc extends Engine_Class {

    public function process() {
        // Пересчитать цены в фоне
        if ($this->getArgument('id')) {
            $categoryID = $this->getArgumentSecure('id');
            Shop::Get()->getSupplierService()->createProductPriceTask($categoryID);
            $this->setValue('message', 'ok');
        } else {
            $this->setValue('message', 'error');
        }
    }

}