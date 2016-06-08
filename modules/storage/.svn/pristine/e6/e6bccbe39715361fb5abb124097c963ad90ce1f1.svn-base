<?php

class Datasource_Storage_Motionlog extends Forms_ADataSourceSQLObject {

    public function __construct($type = false, $datefrom = false, $dateto = false,
    $storageName = false, $storageNameFromIDArray = false, $storageNameToIDArray = false,
    $returnTransactionID = false, $orderID = false, $productID = false) {
        $this->_type = $type;
        $this->_datefrom = $datefrom;
        $this->_dateto = $dateto;
        $this->_storagename = $storageName;
        $this->_storagenamefromidarray = $storageNameFromIDArray;
        $this->_storagenametoidarray = $storageNameToIDArray;
        $this->_returntransactionid = $returnTransactionID;
        $this->_orderid = $orderID;
        $this->_productid = $productID;
    }

    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $cuser = Shop::Get()->getUserService()->getUser();

            $this->_sqlobject = StorageService::Get()->getStorageMotionLog(
                $cuser,
                $this->_type,
                $this->_datefrom,
                $this->_dateto,
                $this->_storagename,
                $this->_storagenamefromidarray,
                $this->_storagenametoidarray,
                $this->_returntransactionid,
                $this->_orderid,
                $this->_productid
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

        $field = new Shop_ContentFieldUserInfo('userid');
        $field->setLink('shopstorage.userid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_operator'));
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

        $field = new Shop_ContentField_Price_with_Currency();
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_product_price'));
        $this->addField($field);

        $field = new Shop_ContentField_Sum_with_Currency('cost');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_product_sum'));
        $this->addField($field);

        if ($this->_type == 'sale') {
            $field = new Forms_ContentField('orderid');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_order_number'));
            $this->addField($field);

            $field = new Forms_ContentField('client');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_client_small'));
            $this->addField($field);
        }

        $field = new Shop_ContentField_Actions(
            'actions',
            array(
                array(
                    'actionName' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_read_more'),
                    'contentID' => 'shop-admin-storage-motion-view'
                )
            )
        );
        $field->setSortable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_read_more'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('return');
        $this->addField($field);
    }


    private $_type = false;
    private $_datefrom = false;
    private $_dateto = false;
    private $_storagename = false;
    private $_storagenamefromidarray = false;
    private $_storagenametoidarray = false;
    private $_returntransactionid = false;
    private $_orderid = false;
    private $_productid = false;
    private $_sqlobject = false;

}