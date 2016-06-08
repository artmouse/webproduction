<?php
class payment_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Payment());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-payment-control', 'id');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));

        $this->setValue('table', $table->render());
    }

}