<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class ShopOrderProduct extends XShopOrderProduct {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopOrderProduct
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * Получить товар
     *
     * @return ShopProduct
     */
    public function getProduct() {
        return Shop::Get()->getShopService()->getProductByID(
        $this->getProductid()
        );
    }

    /**
     * Получить валюту, в которой оформлен заказ-строка
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID(
        $this->getCurrencyid()
        );
    }

    /**
     * Получить имя склада логистики
     *
     * @return ShopStorageName
     */
    public function getLogisticStorageName() {
        return Shop::Get()->getStorageService()->getStorageNameByID(
        $this->getLogisticstorageid()
        );
    }

    /**
     * Посчитать цену заказанного товара в указанной валюте
     *
     * @uses
     *
     * @param ShopCurrency $currency
     * @return float
     */
    public function makePrice(ShopCurrency $currency) {
        return Shop::Get()->getCurrencyService()->convertCurrency(
        $this->getProductprice(),
        $this->getCurrency(),
        $currency
        );
    }

    /**
     * Посчитать сумму заказанного товара в указанной валюте
     *
     * @uses
     *
     * @param ShopCurrency $currency
     * @return float
     */
    public function makeSum(ShopCurrency $currency) {
        return round($this->makePrice($currency) * $this->getProductcount(), 2);
    }

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    public function getOrder() {
        return Shop::Get()->getShopService()->getOrderByID(
        $this->getOrderid()
        );
    }

    /**
     * Получить выбранного поставщика
     *
     * @return ShopSupplier
     */
    public function getSupplier() {
        return Shop::Get()->getShopService()->getSupplierByID(
        $this->getSupplierid()
        );
    }

    /**
     * @return int
     */
    public function insert() {
        // задача 66226
        /*try {
            $product = $this->getProduct();
            RtmService::Get()->clearSimilarProduct($product);
        } catch(Exception $e) {

        }*/
        return parent::insert();
    }

    public function delete() {
        try {
            $product = $this->getProduct();
            RtmService::Get()->addSimilarProduct($product);
        } catch(Exception $e) {

        }
        return parent::delete();
    }

}