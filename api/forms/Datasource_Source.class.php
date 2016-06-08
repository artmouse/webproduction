<?php

class Datasource_Source extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getSourceAll();
    }

    public function getFieldPreview() {
        return $this->getField('name');
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $this->addField($field);

        $field = new Forms_ContentField('address');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_adres_istochnika'));
        $this->addField($field);
    }

}