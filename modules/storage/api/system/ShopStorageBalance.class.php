<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopStorageBalance extends XShopStorageBalance {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopStorageBalance
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopStorageBalance
     */
    public static function Get($key) {
        return self::GetObject('ShopStorageBalance', $key);
    }

    /**
     * @return ShopProduct
     */
    public function getProduct() {
        return Shop::Get()->getShopService()->getProductByID($this->getProductid());
    }

    /**
     * @return ShopStorageName
     */
    public function getStorageName() {
        return StorageNameService::Get()->getStorageNameByID($this->getStoragenameid());
    }

    public function getAmountAvailable() {
        return $this->getAmount() - $this->getAmountlinked();
    }

}