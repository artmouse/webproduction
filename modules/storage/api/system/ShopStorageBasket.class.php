<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopStorageBasket extends XShopStorageBasket {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopStorageBasket
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopStorageBasket
     */
    public static function Get($key) {
        return self::GetObject('ShopStorageBasket', $key);
    }

    /**
     * @return ShopProduct
     */
    public function getProduct() {
        return Shop::Get()->getShopService()->getProductByID($this->getProductid());
    }

    /**
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID($this->getCurrencyid());
    }

    /**
     * @return User
     */
    public function getWorker() {
        return Shop::Get()->getUserService()->getUserByID($this->getWorkerid());
    }

    /**
     * @return ShopStorageName
     */
    public function getStorageName() {
        return StorageNameService::Get()->getStorageNameByID($this->getStoragenamefromid());
    }

    /**
     * @return ShopStorageOrderProduct
     */
    public function getStorageOrderProduct() {
        return StorageOrderService::Get()->getStorageOrderProductByID($this->getStorageorderproductid());
    }

}