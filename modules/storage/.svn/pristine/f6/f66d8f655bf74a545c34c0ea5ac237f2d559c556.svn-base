<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopStorage extends XShopStorage {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopStorage
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopStorage
     */
    public static function Get($key) {
        return self::GetObject('ShopStorage', $key);
    }

    /**
     * @return ShopProduct
     */
    public function getProduct() {
        return Shop::Get()->getShopService()->getProductByID($this->getProductid());
    }

    /**
     * @return User
     */
    public function getUser() {
        return Shop::Get()->getUserService()->getUserByID($this->getUserid());
    }

    /**
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID($this->getCurrencyid());
    }

    /**
     * @return ShopStorageName
     */
    public function getStorageNameTo() {
        return StorageNameService::Get()->getStorageNameByID($this->getStoragenametoid());
    }

    /**
     * @return ShopStorageName
     */
    public function getStorageNameFrom() {
        return StorageNameService::Get()->getStorageNameByID($this->getStoragenamefromid());
    }

    /**
     * @return ShopStorageTransaction
     */
    public function getStorageTransaction() {
        return StorageService::Get()->getStorageTransactionByID($this->getTransactionid());
    }

    /**
     * Посчитать цену товара в указанной валюте
     *
     * @param ShopCurrency $currency
     * @return float
     */
    public function makePrice(ShopCurrency $currency) {
        return Shop::Get()->getCurrencyService()->convertCurrency(
        $this->getPrice(),
        $this->getCurrency(),
        $currency
        );
    }

    /**
      * Посчитать цену товара в указанной валюте с НДС
      *
      * @param ShopCurrency $currency
      * @return float
      */
    public function makePriceWithTax(ShopCurrency $currency) {
        $price = $this->makePrice($currency);
        if ($this->getTaxrate() > 0) {
            $price = $price + ($price*$this->getTaxrate()/100);
        }
        return round($price, 2);
    }

    /**
     * Посчитать сумму товара в указанной валюте
     *
     * @param ShopCurrency $currency
     * @return float
     */
    public function makeSum(ShopCurrency $currency) {
        return round($this->makePrice($currency) * $this->getAmount(), 2);
    }

    /**
     * Посчитать сумму товара в указанной валюте с НДС
     *
     * @param ShopCurrency $currency
     * @return float
     */
    public function makeSumWithTax(ShopCurrency $currency) {
        return round($this->makePriceWithTax($currency) * $this->getAmount(), 2);
    }

    /**
     * Посчитать цену товара в указанной валюте без НДС
     *
     * @param ShopCurrency $currency
     * @return float
     */
    public function makePriceWithoutTax(ShopCurrency $currency) {
        $price = $this->makePrice($currency);
        if ($this->getTaxrate() < 0) {
            $price = ($price*100)/(100+(-$this->getTaxrate()));
        }
        return round($price, 2);
    }

    /**
     * Посчитать сумму товара в указанной валюте без НДС
     *
     * @param ShopCurrency $currency
     * @return float
     */
    public function makeSumWithoutTax(ShopCurrency $currency) {
        return round($this->makePriceWithoutTax($currency) * $this->getAmount(), 2);
    }

    /**
     * @return array
     */
    public function makeInfoArray() {
        $a = array();
        $a['id'] = $this->getId();
        // $a['name'] = htmlspecialchars($this->getProduct()->getName());
        $a['price'] = $this->getPrice();
        $a['currency'] = $this->getCurrency()->getSymbol();
        $a['count'] = $this->getAmount();
        $a['serial'] = $this->getSerial();
        return $a;
    }

    /**
     * Получить ссылку на историю перемещений данного товара
     *
     * @return string
     */
    public function makeHistoryURL() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-motion-product', $this->getCode(), 'code');
    }

    /**
     * @return string
     */
    public function makeType() {
        return StorageService::Get()->getTransactionTypeNameByKey(
        $this->getType()
        );
    }

}