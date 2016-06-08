<?php
class supplier_index extends Engine_Class {

    public function process() {
        // массовое удаление
        $massDelete = $this->getArgumentSecure('delete');

        if ($massDelete) {
            $this->_supplierMassDelete();
        }

        // формирование таблицы
        $table = new Shop_ContentTable(new Datasource_Supplier());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-supplier-control', 'id');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_supplier'));

        $this->setValue('table', $table->render());
    }

    /**
     * Массовое удаление поставщиков
     */
    private function _supplierMassDelete() {
        if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveid'), $r)) {
            foreach ($r[1] as $supplierID) {
                try {
                    $supplier = Shop::Get()->getSupplierService()->getSupplierByID($supplierID);

                    if ($this->getControlValue('delete') == 'delete') {
                        try {
                            Shop::Get()->getSupplierService()->getSupplierByID($supplierID)->delete();
                        } catch (Exception $deleteEx) {

                        }
                    }
                    $supplier->update();

                } catch (Exception $pe) {

                }
            }
        }
    }

}