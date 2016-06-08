<?php
class storage_name_employee_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_StorageName('employee'));

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-storage-name-employee-control', 'key');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_employee_name'));
        $table->getField('userid')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_responsible'));
        $table->getField('forsale')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_employee_can_sale'));

        $table->removeField('id');

        $this->setValue('table', $table->render());
    }

}