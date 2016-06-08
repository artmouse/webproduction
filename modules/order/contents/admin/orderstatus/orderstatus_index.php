<?php
class orderstatus_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_OrderStatus());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-orderstatus-control', 'key');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_status'));

        $this->setValue('table', $table->render());
    }

}