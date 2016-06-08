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
class Datasource_UsersBan extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $x = Shop::Get()->getUserService()->getUsersAll();
        $x->setLevel(0);
        $x->addWhere('login', '', '!=');
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('login');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_login'));
        $field->addValidator(new Forms_ValidatorLogin());
        $this->addField($field);

        $field = new Forms_ContentFieldPasswordMD5('password');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_password'));
        $this->addField($field);

        $field = new Forms_ContentField('email');
        $field->setName('E-mail');
        $field->addValidator(new Forms_ValidatorEmail());
        $this->addField($field);

        $field = new Forms_ContentFieldInt('level');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_access_level'));
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_fio'));
        $this->addField($field);

        $field = new Forms_ContentField('phone');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_telephone'));
        $this->addField($field);

        $field = new Forms_ContentField('address');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_address'));
        $this->addField($field);

        $field = new Forms_ContentField('cdate');
        $field->setEditable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_registration'));
        $this->addField($field);

        $field = new Forms_ContentField('adate');
        $field->setEditable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_activity'));
        $this->addField($field);
    }


}