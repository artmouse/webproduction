<?php
/**
 * WebProduction Shop (wpshop)
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
class Datasource_Jeweler extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getObjectsAll('XJeweler');
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName('Имя');
        $field->addValidator(new Forms_ValidatorEmpty());
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('description');
        $field->setName('Описание');
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_picture'));
        $field->setQuickedit(true);
        $this->addField($field);
    }
}

