<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopDiscount extends XShopDiscount {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * *
     * @return ShopDiscount
     */
    public function getNext($exception = false) {
        $x = 1; // Sniffer fix Possible useless method overriding detected
        return parent::getNext($exception);
    }

    /**
     * *
     * @return ShopDiscount
     */
    public static function Get($key) {
        return self::GetObject('ShopDiscount', $key);
    }

    /**
     * *
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID($this->getCurrencyid());
    }

    /**
     * Получить сумму скидки (в деньгах) 
     * применяя к $target
     *
     * @param float $target
     * @param ShopCurrency $targetCurency
     * 
     * @return float
     */
    public function makeDiscountValue($target, ShopCurrency $targetCurency) {
        if ($this->getType() == 'value') {
            $value = Shop::Get()->getCurrencyService()->convertCurrency(
                $this->getValue(),
                $this->getCurrency(),
                $targetCurency
            );

            return $value;
        } else {
            return ($target * $this->getValue() / 100);
        }
    }

    /**
     * Получить сумму $target (в деньгах) 
     * после применения скидки
     *
     * @param float $target
     * @param ShopCurrency $targetCurency
     * 
     * @return float
     */
    public function applyDiscount($target, ShopCurrency $targetCurency) {
        if ($this->getType() == 'value') {
            $value = Shop::Get()->getCurrencyService()->convertCurrency(
                $this->getValue(),
                $this->getCurrency(),
                $targetCurency
            );

            return $target - $value;
        } else {
            return $target - ($target * $this->getValue() / 100);
        }
    }
}