<?php
class products_supplier_ignore extends Engine_Class {

    public function process() {


        if ($this->getControlValue('delete')) {
            try {
                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $ignoreId) {
                        try {
                            SQLObject::TransactionStart();
                            $ignore = new XShopPriceSupplierIgnore();
                            $ignore->filterId($ignoreId);
                            if ($ignore->select()) {
                                $ignore->delete();
                            }


                            SQLObject::TransactionCommit();
                        } catch (Exceprion $e) {
                            SQLObject::TransactionRollback();
                        }
                    }
                }
            } catch (Exception $e) {

            }
        }

        $table = new Shop_ContentTable(
            new Datasource_IgnoreProductsPrice()
        );
        $this->setValue('table', $table->render());
    }

}