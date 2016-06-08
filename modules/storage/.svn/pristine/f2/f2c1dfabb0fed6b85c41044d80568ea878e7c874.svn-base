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
class Datasource_Balance_Product extends Forms_ADataSourceSQLObject {

    public function __construct(ShopProduct $product) {
        $this->_product = $product;
    }

    /**
     * @return ShopProduct
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $cuser = Shop::Get()->getUserService()->getUser();

            $this->_sqlobject = StorageBalanceService::Get()->getBalanceByProduct(
            $this->_product,
            $cuser
            );
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('storagenameid');
        $field->setDataSource(new Datasource_StorageName());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('amount');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_number'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('amountlinked');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_reserved'));
        $this->addField($field);

        $field = new Shop_ContentField_Sum_with_Currency('cost');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sum'));
        $this->addField($field);
    }

    private $_product = false;
    private $_sqlobject;

}