<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopStorageOrder2Transaction extends XShopStorageOrder2Transaction {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopStorageOrder2Transaction
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopStorageOrder2Transaction
     */
    public static function Get($key) {
        return self::GetObject('ShopStorageOrder2Transaction', $key);
    }

    /**
     * @return ShopStorageOrder
     */
    public function getStorageOrder() {
        return StorageOrderService::Get()->getStorageOrderByID($this->getOrderid());
    }

    /**
     * @return ShopStorageTransaction
     */
    public function getStorageTransaction() {
        return StorageService::Get()->getStorageTransactionByID($this->getTransactionid());
    }

}