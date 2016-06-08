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
 * Иконки к товарам
 *
 * @copyright WebProduction
 *
 * @package Shop
 */
class Datasource_ProductIcon extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getProductIconAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        //$field->addValidator(new Forms_ValidatorImageWidthHeight(50, 50));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_picture_50x50'));
        $this->addField($field);

        $field = new Forms_ContentField('url');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_ssilka_pri_klike_po_ikonke'));
        $this->addField($field);
    }

}