<?php
class products_supplier_import_config extends Engine_Class {

    public function process() {
        $user = $this->getUser();
        $supplierId = $this->getArgumentSecure('supplierid');
        $importConfig = new XShopPriceSupplierConfig();
        $importConfig->filterSupplierid($supplierId);
        if($importConfig->select()) {
            print json_encode($importConfig->toArray());
        }
        exit();
    }

}