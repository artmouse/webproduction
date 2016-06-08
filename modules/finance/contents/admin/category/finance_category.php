<?php
class finance_category extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_FinanceCategory());

        $field = new Forms_ContentFieldControlLink('name', 'shop-finance-category-control', 'key');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_nazvanie_kategorii'));
        $table->addField($field);

        $this->setValue('table', $table->render());
    }

}