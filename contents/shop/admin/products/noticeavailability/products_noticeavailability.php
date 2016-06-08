<?php
class products_noticeavailability extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_ProductsNoticeOfAvailability());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-products-noticeavailability-control', 'id');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));

        $this->setValue('table', $table->render());
    }

}