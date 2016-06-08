<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Datasource_StorageName extends Forms_ADataSourceSQLObject {

    public function __construct($type = false) {
        $this->_type = $type;
    }

    public function getSQLObject() {
        if (!$this->_sqlobject) {
            //$cuser = Shop::Get()->getUserService()->getUser();
            if ($this->_type == 'warehouse') {
                $this->_sqlobject = StorageNameService::Get()->getStorageNamesWarehouses();
            } elseif ($this->_type == 'vendor') {
                $this->_sqlobject = StorageNameService::Get()->getStorageNamesVendors();
            } elseif ($this->_type == 'employee') {
                $this->_sqlobject = StorageNameService::Get()->getStorageNamesEmployees();
            } else {
                $this->_sqlobject = StorageNameService::Get()->getStorageNamesAll();
            }
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_warehouse_name'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('forsale');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_sale_allowed'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('default');
        $field->setName('Склад по умолчанию, для оприходования');
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden1'));
        $this->addField($field);
    }

    public function insert($fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::insert($fieldsArray);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $storage = StorageNameService::Get()->getStorageNameByID($r);

                CommentsAPI::Get()->addComment(
                    'shop-history-storagename-'.$r,
                    'Добавлен новый склад #'.$r.' '.$storage->getName(),
                    $user->getId()
                );
            } catch (Exception $e) {

            }

            SQLObject::TransactionCommit();

            return $r;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function update($key, $fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::update($key, $fieldsArray);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $storage = StorageNameService::Get()->getStorageNameByID($key);

                $diffArray = array();
                foreach ($fieldsArray as $field) {
                    if ($field->getEditable()) {
                        $diffArray[] = $field->getName().' '.$field->getValue();
                    }
                }

                CommentsAPI::Get()->addComment(
                    'shop-history-storagename-'.$storage->getId(),
                    'Отредактирован склад #'.$storage->getId().' '.$storage->getName()."\n".implode("\n", $diffArray),
                    $user->getId()
                );
            } catch (Exception $e) {

            }

            SQLObject::TransactionCommit();

            return $r;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function delete($key) {
        try {
            $storage = StorageNameService::Get()->getStorageNameByID($key);

            if ($storage->getStorageRecords()->getCount()) {
                throw new ServiceUtils_Exception();
            }

            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                    'shop-history-storagename-'.$storage->getId(),
                    'Удален склад #'.$storage->getId().' '.$storage->getName(),
                    $user->getId()
                );
            } catch (Exception $e) {

            }

            return parent::delete($key);
        } catch (Exception $e) {

        }
    }

    private $_type = false;
    private $_sqlobject;

}