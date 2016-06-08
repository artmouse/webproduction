<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Datasource_WorkflowType extends Forms_ADataSourceSQLObject {


    public function getSQLObject() {
        return new XShopWorkflowType();
    }

    public function getFieldPreview() {
        return $this->getField('name');
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_box_name_small'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentField('multiplename');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_mnozhestvennoe_nazvanie'));
        $this->addField($field);

        $field = new Forms_ContentField('type');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_type_shot'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentField('icon');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_ikonka_unicode_'));
        $this->addField($field);

        $field = new Forms_ContentField('typeaddpage');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_stranitsa_dobavleniya_kak_dlya')
        );
        $this->addField($field);

        $field = new Forms_ContentField('contentId');
        $field->setName('Id контента');
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('calendarShow');
        $field->setName('Показывать в календаре');
        $this->addField($field);

    }

}