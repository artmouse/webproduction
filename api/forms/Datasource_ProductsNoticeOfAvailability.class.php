<?php

class Datasource_ProductsNoticeOfAvailability extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getProductsNoticeOfAvailabilityService()->getProductsNoticeOfAvailabilityAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentField('email');
        $field->setName('Email');
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('status');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_processed'));
        $this->addField($field);

        //        $field = new Forms_ContentField('image');
        //        $field->setMediaDirectory('/media/shop/');
        //        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_picture'));
        //        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_created'));
        $this->addField($field);

        $field = new Forms_ContentField('senddate');
        $field->setDisabled();
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_dispatch_date'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('productid');
        $field->setDataSource(new Datasource_Products());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_product'));
        $this->addField($field);

    }

}