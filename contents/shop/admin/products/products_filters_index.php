<?php
class products_filters_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_ProductFilters());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-products-filters-control', 'id');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));

        $this->setValue('table', $table->render());
    }

}