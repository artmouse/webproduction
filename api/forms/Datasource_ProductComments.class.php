<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_ProductComments extends Forms_ADataSourceSQLObject {

    public function __construct($key = 0) {
        $this->_key = $key;
    }

    public function getSQLObject() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID($this->_key);
            $x = Shop::Get()->getShopService()->getProductComments($product);
        } catch (ServiceUtils_Exception $e) {
            $x = Shop::Get()->getShopService()->getProductCommentsAll();
        }
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('productid');
        $field->setDataSource(new Datasource_Products());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_product'));
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date_time'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('userid');
        $field->setDataSource(new Datasource_Users());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_author'));
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('username');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('text');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_comment'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('plus');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_advantage'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('minus');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_minus'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('rating');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_evaluation'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('answer');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_answer_administration'));
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_picture'));
        $this->addField($field);
    }

    private $_key = 0;

}