<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Источник данных "Поставщики"
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 *
 * @copyright WebProduction
 *
 * @package Shop
 */
class Datasource_Supplier extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $x = new ShopSupplier();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldCheckboxKey('select');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_choice'));
        $field->setSortable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_supplier'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('description');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_supplier_description'));
        $this->addField($field);

        $field = new Forms_ContentFieldAutocomplete('contactid');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_kompaniyakontakt_postavshchika')
        );
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_zablokirovanskrit'));
        $this->addField($field);

        $field = new Forms_ContentFieldColor('color');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_tsvet'));
        $this->addField($field);

        $field = new Forms_ContentField('deliverytime');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_delivery_time'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('workflowid');
        $field->setDataSource(new Shop_ContentField_Workflows());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_workflow'));
        $this->addField($field);

        $field = new Forms_ContentField('availtext');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_delivery_text'));
        $this->addField($field);
    }

}