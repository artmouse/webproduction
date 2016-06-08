<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_Discount extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getDiscountAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('type');
        $field->setDataSource(new Datasource_DiscountType());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_discount_type'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('value');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_discount_value'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('minstartsum');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_for_what_amounts_received'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid', false);
        $field->setDataSource(new Datasource_Currency());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_currency'));
        $this->addField($field);
    }

}