<?php
class category_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Category());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-category-control', 'key');
        $table->addField($field);
        // Поле поддомен не редактируемо
        $table->getDataSource()->getField('subdomain')->setEditable(false);
        $table->getField('name')->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_category')
        );

        $this->setValue('table', $table->render());
    }

}