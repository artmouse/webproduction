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
class Datasource_Gallery extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return new ShopGallery();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-gallery-control', 'key');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_image'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('sort');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sorting'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden_record'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('content');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_content'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_created'));
        $this->addField($field);

        $field = new Forms_ContentField('album');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_album'));
        $this->addField($field);

        $field = new Forms_ContentField('url');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_URL_prefix'));
        $field->addValidator(new Forms_ValidatorSubUrl());
        $field->addValidator(new Shop_ValidatorURLUnique());
        $this->addField($field);

        $field = new Forms_ContentField('seotitle');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_title'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seokeywords');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_keywords'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seodescription');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_description'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('seocontent');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_text'));
        $this->addField($field);
    }

}