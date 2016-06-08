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
class Datasource_Logo extends Forms_ADataSourceSQLObject {

    /**
     * @return ShopLogo
     */
    public function getSQLObject() {
        return Shop::Get()->getShopService()->getLogoAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-logo-control', 'key');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('file');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_file'));
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('sdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_start_date'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('edate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date_of_completion'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('default');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_logo_default'));
        $this->addField($field);
    }
}