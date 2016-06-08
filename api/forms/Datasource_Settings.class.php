<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_Settings extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $x = new XShopSettings();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_setting'));
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('value');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_value'));
        $field->getContentControl()->setValue('height', '300px');
        $this->addField($field);
    }

}