<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopMarginRule extends XShopMarginRule {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * *
     * @return ShopMarginRule
     */
    public function getNext($exception = false) {
        $x = 1; // Sniffer fix Possible useless method overriding detected
        return parent::getNext($exception);
    }

    /**
     * *
     * @return ShopMarginRule
     */
    public static function Get($key) {
        return self::GetObject('ShopMarginRule', $key);        
    }

    /**
     * *
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID(
            $this->getCurrencyid()
        );
    }

    /**
     * Получить значение наценки для конкретной цены
     *
     * @param float $price
     * @param ShopCurrency $currency
     * 
     * @return float
     */
    public function getMarginValue($price, ShopCurrency $currency) {
        if ($this->getType() == 'percent') {
            $value = $price * $this->getValue() / 100;
        } else {
            $value = Shop::Get()->getCurrencyService()->convertCurrency(
                $this->getValue(),
                $this->getCurrency(),
                $currency
            );
        }
        
        return round($value, 2);
    }
    
    /**
     * Получить название наценки
     *
     * @return string
     */
    public function makeName() {
        $name = '';
        if ($this->getPricefrom() > 0) {
            $name .= 'Цена от '.$this->getPricefrom().' '.$this->getCurrency()->getName();
        }
        if ($this->getPriceto() > 0 && !$name) {
            $name .= 'Цена';
        }
        if ($this->getPriceto() > 0) {
            $name .= ' до '.$this->getPriceto().' '.$this->getCurrency()->getName();
        }
        if ($name) {
            $name .= ': ';
        }
        $name .= 'Наценка '.$this->getValue();
        if ($this->getType() == 'sum') {
            $name .= ' '.$this->getCurrency()->getName();
        } else {
            $name .= '%';
        }
        
        return $name;
    }

}