<?php
class finance_account extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_FinanceAccount());

        $field = new Forms_ContentFieldControlLink('name', 'shop-finance-account-control', 'key');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_nazvanie_koshelka_scheta'));
        $table->addField($field);

        $this->setValue('table', $table->render());
    }

}