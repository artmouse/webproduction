<?php
class contactfield_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_ContactField());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-contactfield-control', 'key');
        $table->addField($field);

        $table->getField('name')->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_imya_polya')
        );

        $this->setValue('table', $table->render());
    }

}