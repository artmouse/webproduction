<?php
/**
 * OneBox
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopStorageReserve extends XShopStorageReserve {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopStorageReserve
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopStorageReserve
     */
    public static function Get($key) {
        return self::GetObject('ShopStorageReserve', $key);
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

    /**
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID($this->getCurrencyid());
    }

}