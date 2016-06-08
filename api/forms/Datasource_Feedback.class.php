<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Golub Oleksii <avator@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_Feedback extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getFeedbackService()->getFeedbackAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-feedback-control', 'id');
        $field->setName('#');
        $field->setEditable(false);
        $field->addValidator(new Forms_ValidatorInt());
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_fio'));
        $this->addField($field);

        $field = new Forms_ContentField('email');
        $field->setName('E-mail');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('phone');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_telephone'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('message');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_message'));
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('userid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_client_user'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('done');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_processed'));
        $this->addField($field);
    }

}