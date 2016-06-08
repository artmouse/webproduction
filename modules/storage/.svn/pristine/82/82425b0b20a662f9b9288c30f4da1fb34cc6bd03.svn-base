<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopStorageLink extends XShopStorageLink {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopStorageLink
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopStorageLink
     */
    public static function Get($key) {
        return self::GetObject('ShopStorageLink', $key);
    }

    /**
     * @return ShopStorageBalance
     */
    public function getBalance() {
        return StorageBalanceService::Get()->getBalanceByID($this->getStoragebalanceid());
    }

    /**
     * @return ShopStorageBasket
     */
    public function getBasket() {
        return StorageService::Get()->getStorageBasketByID($this->getBasketid());
    }

    /**
     * @return ShopProduct
     */
    public function getProduct() {
        return $this->getBalance()->getProduct();
    }

    /**
     * @return ShopStorageName
     */
    public function getStorageName() {
        return $this->getBalance()->getStorageName();
    }

    /**
     * @return string
     */
    public function getSerial() {
        return $this->getBalance()->getSerial();
    }

    /**
     * @return string
     */
    public function getCode() {
        return $this->getBalance()->getCode();
    }

}