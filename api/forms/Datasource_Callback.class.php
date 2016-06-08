<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_Callback extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $x = Shop::Get()->getCallbackService()->getCallbackAll();
        $x->setOrder('id','DESC');
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-callback-control', 'id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentField('phone');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_telephone'));
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('userid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_client_user'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('done');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_processed'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_created'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('answer');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_question'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('comment');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_comment'));
        $this->addField($field);
    }

}