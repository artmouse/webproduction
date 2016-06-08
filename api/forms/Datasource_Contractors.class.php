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
class Datasource_Contractors extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $x = Shop::Get()->getShopService()->getContractorsAll();
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('tax');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_VAT'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('details');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_details'));
        $this->addField($field);

        for ($j = 1; $j <= 10; $j++) {
            $field = new Forms_ContentFieldTextarea('customfield'.$j);
            $field->setName('Custom field '.$j);
            $this->addField($field);
        }

        $field = new Forms_ContentFieldCheckbox('active');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_actively'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('default');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_default'));
        $this->addField($field);
    }

}