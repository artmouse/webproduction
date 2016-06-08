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
class Datasource_Storage_Motion extends Forms_ADataSourceSQLObject {

    public function __construct($transactionID, $onlyTarget = false, $onlyMaterial = false) {
        $this->_transactionID = $transactionID;
        $this->_onlyTarget = $onlyTarget;
        $this->_onlyMaterial = $onlyMaterial;
    }

    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $cuser = Shop::Get()->getUserService()->getUser();

            $this->_sqlobject = StorageService::Get()->getStorageMotion(
            $cuser,
            $this->_transactionID,
            $this->_onlyTarget,
            $this->_onlyMaterial
            );

        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentField('id');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('productid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_item_code'));
        $this->addField($field);

        $field = new Forms_ContentField('productname');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_product'));
        $this->addField($field);

        $field = new Forms_ContentField('serial');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_serial_number'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('amount');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_number'));
        $this->addField($field);

        $field = new Shop_ContentField_Sum_with_Currency('pricebase');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_price_purchase'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('price');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_price_purchase'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid');
        $field->setDataSource(new Datasource_Currency());
        $field->setName('Валюта закупки');
        $this->addField($field);

        $field = new Forms_ContentField('warranty');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_warranty'));
        $this->addField($field);

        $field = new Forms_ContentField('shipment');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_batch_code'));
        $this->addField($field);

        $field = new Shop_ContentField_StorageMotion_Actions('actions');
        $field->setSortable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_actions'));
        $this->addField($field);
    }

    private $_transactionID = false;
    private $_onlyTarget = false;
    private $_onlyMaterial = false;

    private $_sqlobject = false;

}