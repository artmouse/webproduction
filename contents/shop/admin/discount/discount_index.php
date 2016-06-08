<?php
class discount_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Discount());

        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-discount-control', 'key');
        $table->addField($field);

        $table->getField('id')->setName('#');

        $this->setValue('table', $table->render());
    }

}