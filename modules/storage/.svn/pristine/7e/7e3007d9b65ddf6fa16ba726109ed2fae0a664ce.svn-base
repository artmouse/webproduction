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
class Datasource_Storage_ProductHistory extends Forms_ADataSourceSQLObject {

    public function __construct($code) {
        $this->_code = $code;
    }

    /**
     * @return ShopStorage
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $cuser = Shop::Get()->getUserService()->getUser();

            $this->_sqlobject = StorageService::Get()->getStoragesByCode(
            $cuser,
            $this->_code
            );
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentField('id');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('date');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date'));
        $this->addField($field);

        $field = new Shop_ContentField_TransactionType('type');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_motion_type'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('storagenamefromid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_from'));
        $field->setDataSource(new Datasource_StorageName());
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('storagenametoid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_to'));
        $field->setDataSource(new Datasource_StorageName());
        $this->addField($field);

        $field = new Forms_ContentFieldInt('amount');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_product_amount'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('userid');
        $field->setLink('shopstorage.userid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_operator'));
        $field->setDataSource(new Datasource_Users());
        $this->addField($field);

        $actionArray = array();
        $cuser = Shop::Get()->getUserService()->getUser();

        if ($cuser->isAllowed('storage-motionlog-edit')) {
            $actionArray[] = array(
            'actionName' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_edit'),
            'contentID' => 'shop-admin-storage-motion-edit'
            );
        }

        if ($cuser->isAllowed('storage-motionlog-delete')) {
            $actionArray[] = array(
            'actionName' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_delete'),
            'contentID' => 'shop-admin-storage-motion-delete'
            );
        }

        $field = new Shop_ContentField_Actions('actions', $actionArray);
        $field->setSortable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_actions'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('return');
        $this->addField($field);

        $field = new Forms_ContentFieldInt('transactionid');
        $this->addField($field);
    }

    private $_code = false;
    private $_sqlobject;

}