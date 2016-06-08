<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Datasource_ProductsTop
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_ProductsTop extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $x = Shop::Get()->getShopService()->getProductsTop();
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_image'));
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('price');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_price'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_currency'));
        $field->setDataSource(new Datasource_Currency());
        $this->addField($field);

        $field = new Forms_ContentFieldSelectTree('categoryid');
        $field->setDataSource(new Datasource_Category());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_category'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('brandid');
        $field->setDataSource(new Datasource_Brands());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_brand'));
        $this->addField($field);

        $field = new Forms_ContentField('model');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_model'));
        $this->addField($field);

        $field = new Forms_ContentField('barcode');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_bar_code'));
        $this->addField($field);

        $field = new Forms_ContentField('warranty');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_warranty'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('top');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_promotional'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden1'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('ordered');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_orders'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('rating');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_ratings'));
        $this->addField($field);
    }


}