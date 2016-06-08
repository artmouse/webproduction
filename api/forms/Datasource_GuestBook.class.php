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
 * OneBox
 * @author Egor Gerasimchuk <milhous@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_GuestBook extends Forms_ADataSourceSQLObject {

    /**
     *  OneBox
     * 
     * @return ShopGuestBook
     */
    public function getSQLObject() {
        $x = Shop::Get()->getGuestBookService()->getGuestBookAll();
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-guestbook-control', 'id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('text');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_reviewed'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('done');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_processeded'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_created'));
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_image'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('userid', true);
        $field->setDataSource(new Datasource_Users());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_small'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $field->setEditable(false);
        $this->addField($field);
        
        $field = new Forms_ContentFieldTextarea('answer');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_answer_administration'));
        $this->addField($field);
    }

}