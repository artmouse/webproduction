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
class Datasource_ProductPassport extends Forms_ADataSourceSQLObject {

    /**
     * @return ShopProductPassport
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $orders = StorageProductionService::Get()->getProductPassportsAll();
            $this->_sqlobject = $orders;
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('valid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_valid'));
        $this->addField($field);

        $field = new Shop_ContentField_Actions('actions', array(array(
        'actionName' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_edit'),
        'contentID' => 'shop-admin-storage-product-passport-edit'
        )));
        $field->setSortable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_actions'));
        $this->addField($field);
    }

    private $_user = false;

    private $_type = false;

    private $_sqlobject;

}