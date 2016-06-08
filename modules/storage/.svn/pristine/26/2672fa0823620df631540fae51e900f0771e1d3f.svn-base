<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopStoragePack extends XShopStoragePack {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopStoragePack
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopStoragePack
     */
    public static function Get($key) {
        return self::GetObject('ShopStoragePack', $key);
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
        return StorageNameService::Get()->getStorageNameByID($this->getStoragenamefromid());
    }

    /**
     * @return ShopProduct
     */
    public function getTargetProduct() {
        return Shop::Get()->getShopService()->getProductByID($this->getTargetproductid());
    }

}