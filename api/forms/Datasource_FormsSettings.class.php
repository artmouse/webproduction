<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Datasource_FormsSettings extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $forms = new XShopFormsSettings();
        return $forms;
    }

    protected function _initialize() {

        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $this->addField($field);

        $field = new Forms_ContentField('description');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_description'));
        $this->addField($field);
    }
}