<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopStorageOrderProduct extends XShopStorageOrderProduct {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopStorageOrderProduct
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopStorageOrderProduct
     */
    public static function Get($key) {
        return self::GetObject('ShopStorageOrderProduct', $key);
    }

    /**
     * @return ShopStorageOrder
     */
    public function getOrder() {
        return StorageOrderService::Get()->getStorageOrderByID($this->getOrderid());
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
}