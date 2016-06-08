<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Datasource_ProductFilters extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getProductFiltersAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_filter_name'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('type');
        $field->setDataSource(new Datasource_ProductFilterType());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_type_of_filter'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('filter');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_filtruemoe'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden1'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('sort');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sorting'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('sorttype');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sort_the_numbers'));
        $this->addField($field);

        $field = new Forms_ContentField('linkkey');
        $field->setName('Technical link key');
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('basicfilter');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_primary_filter'));
        $this->addField($field);
    }

}