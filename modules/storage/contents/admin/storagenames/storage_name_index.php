<?php
class storage_name_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_StorageName('warehouse'));

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-storage-name-control', 'key');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_warehouse_name'));
        $table->removeField('id');

        $this->setValue('table', $table->render());
    }

}