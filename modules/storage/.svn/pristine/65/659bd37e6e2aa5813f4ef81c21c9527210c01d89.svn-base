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
class Datasource_StorageOrder extends Forms_ADataSourceSQLObject {

    public function __construct(User $cuser, $type) {
        $this->_user = $cuser;
        $this->_type = $type;
    }

    /**
     * @return ShopStorageOrder
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $orders = StorageOrderService::Get()->getStorageOrdersByUser($this->_user, $this->_type);
            $this->_sqlobject = $orders;
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_decorated'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('userid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_author'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('storagenamefromid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_StorageName'));
        $field->setName(
        ($this->_type == 'incoming')?Shop::Get()->getTranslateService()->getTranslateSecure('translate_vendor'):
        (($this->_type == 'transfer')?Shop::Get()->getTranslateService()->getTranslateSecure('translate_where_from'):
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_production_from'))
        );
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('storagenametoid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_StorageName'));
        $field->setName(
        ($this->_type == 'incoming')?Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_incoming_to'):
        (($this->_type == 'transfer')?Shop::Get()->getTranslateService()->getTranslateSecure('translate_where_to'):
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_production_to'))
        );
        $this->addField($field);

        $field = new Shop_ContentField_Sum_with_Currency('sum');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sum'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('isshipped');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_shipped'));
        $this->addField($field);

        $field = new Shop_ContentField_StorageOrder_Actions('actions');
        $field->setSortable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_actions'));
        $this->addField($field);
    }

    private $_user = false;
    private $_type = false;

    private $_sqlobject;

}