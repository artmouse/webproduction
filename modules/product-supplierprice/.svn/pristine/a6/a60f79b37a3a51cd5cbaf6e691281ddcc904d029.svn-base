<?php
class supplier_import_status_print extends Engine_Class {

    public function process() {
        
        // вывести отчет о загрузке прайса
        $id = $this->getArgumentSecure('id');
        $importStatus = new XPriceSupplierImportStatus();
        $importStatus->setId($id);
        if ($importStatus->select()) {
            $text = nl2br($importStatus->getResulttext());
            print $text;
            
        }
    }

}