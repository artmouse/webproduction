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
 * *
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_UserGroup extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getUserService()->getUserGroupsAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_band_name'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldSelectTree('parentid', true);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_roditelskaya_gruppa'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_UserGroup'));
        $this->addField($field);

        $field = new Forms_ContentField('description');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_opisanie_gruppi'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('group', true);
        $field->setDataSource(new Datasource_UserGroupPlace());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_group'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('pricelevel');
        $field->setDataSource(new Datasource_UserPriceLevel());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_price_level'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('sort');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sorting'));
        $this->addField($field);

        $field = new Forms_ContentField('colour');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_tsvet'));
        $this->addField($field);

        $field = new Forms_ContentField('logicclass');
        $field->setName('Smart-обработчик');
        $this->addField($field);
    }

}