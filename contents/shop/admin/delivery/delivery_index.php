<?php
class delivery_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Delivery());

        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-delivery-edit', 'id');
        $table->addField($field);

        $table->getField('id')->setName('#');

        $this->setValue('table', $table->render());
    }

}