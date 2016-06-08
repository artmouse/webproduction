<?php

class Datasource_EventIgnore extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $x = new XShopEventIgnore();
        $x->setOrder('address', 'ASC');
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'ignore-control', 'id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldControlLink('address', 'ignore-control', 'id');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_address'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('spam');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_eto_spam'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('notify');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_oshibochniy_kontakt'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('unknown');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_neizvestniy_kontakt'));
        $this->addField($field);
    }

}