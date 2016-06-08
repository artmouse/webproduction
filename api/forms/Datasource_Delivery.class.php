<?php

class Datasource_Delivery extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getDeliveryService()->getDeliveryAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
        $this->addField($field);

        $field = new Forms_ContentField('price');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_price'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_currency'));
        $field->setDataSource(new Datasource_Currency());
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('needcity');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_you_must_specify_city'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('needaddress');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_you_must_specify_the_address')
        );
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('needcountry');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_you_must_specify_the_country')
        );
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('paydelivery');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_dobavit_summu_dostavki_k_zakazu')
        );
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('default');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_default'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('description');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_description_delivery'));
        $this->addField($field);

        $field = new Forms_ContentField('sort');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sort'));
        $this->addField($field);

        $field = new Forms_ContentField('logicclass');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_klass_obrabotchik'));
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_image'));
        $this->addField($field);
    }
}