<?php
class products_list extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_ProductsList());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-products-list-control', 'key');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name_list_of_the_products'));

        $this->setValue('table', $table->render());
    }

}