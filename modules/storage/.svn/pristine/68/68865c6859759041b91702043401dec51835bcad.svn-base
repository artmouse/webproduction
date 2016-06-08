<?php
class storage_name_vendor_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_StorageName('vendor'));

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-storage-name-vendor-control', 'key');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_vendor_name'));
        $table->getField('userid')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_responsible'));

        $table->removeField('forsale');
        $table->removeField('id');

        $this->setValue('table', $table->render());
    }

}