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
 * Настройка полей для контактов
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 *
 * @copyright WebProduction
 *
 * @package OneBox
 */
class Datasource_ContactField extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $x = new ShopContactField();
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_nazvanie_polya'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('idkey');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_identifikator'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('type');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_tip_polya'));
        $field->setDataSource(new Datasource_ContactFieldType());
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_skritoe'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('filterable');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_filtruemoe'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('showinpreview');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_pokazivat_v_prevyu'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('showinorder');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_pokazivat_v_zakaze'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectTree('groupid', true);
        $field->setDataSource(new Datasource_UserGroup());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_group'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('typecontact');
        $field->setDataSource(new Datasource_UserType());
        $field->setName('Тип контакта');
        $field->setQuickedit(true);
        $this->addField($field);
    }

}