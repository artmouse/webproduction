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
class ShopBasket extends XShopBasket {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopBasket
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
     * Посчитать сумму в указанной валюте.
     *
     * Метод править разрешено только Senior'ам!
     *
     * @param ShopCurrency $currency
     * @return float
     */
    public function makeSum(ShopCurrency $currency) {
        // получаем товар
        //$product = $this->getProduct();

        //return round($product->makePriceWithTax($currency) * $this->getProductcount(), 2);
        return round($this->makePriceWithTax($currency) * $this->getProductcount(), 2);
    }

    public function makePriceWithTax (ShopCurrency $currency, $discount = true) {
        $product = $this->getProduct();
        // получаем цену в необходимой валюте
        $price = $this->_makePrice($currency, $discount);

        // если есть НДС - то добавляем его к стоимости товара
        if ($product->getTaxrate() > 0) {
            $price = $price + ($price * $product->getTaxrate() / 100);
        }

        $round = Shop::Get()->getSettingsService()->getSettingValue('price-rounding-off');
        if ($round) {
            $price = round($price);
        } else {
            $price = round($price, 2);
        }

        return $price;

    }

    private function _makePrice (ShopCurrency $currency, $discount = true) {
        $product = $this->getProduct();
        if ($this->getBuyOrExchange() == 'exchange') {
            $price = $product->getPrice($currency);
        } else {
            $price = $product->getPrice_product($currency);
        }

        // если есть скидка по предзаказу, товара нет в наличии и на него есть скидка, то делаем скидку
        if ($product->getPreorderDiscount() and !$product->getAvail() and $discount) {
            $price *= (1 - $product->getDiscount() / 100);
        }else if (!$product->getPreorderDiscount() and $discount) {
            $price *= (1 - $product->getDiscount() / 100);
        }

        $price = Shop::Get()->getCurrencyService()->convertCurrency(
            $price,
            $product->getCurrency(),
            $currency
        );

        //к цене добавляем наценки по опциям
        if ($price &&  $price != 0.00) {
            for ($j = 1; $j <= 10; $j++) {
                // если цена отображается не в гривнах, то пытаемся перевести наценки в валюту цены
                if ($currencyUAH =  Shop::Get()->getCurrencyService()->getCurrencyByName('UAH')) {
                    $price += Shop::Get()->getCurrencyService()->convertCurrency($this->getField('filter'.$j.'markup'),
                        $currencyUAH,$currency);
                }else {
                    $price += $this->getField('filter'.$j.'markup');
                }
            }
        }

        $round = Shop::Get()->getSettingsService()->getSettingValue('price-rounding-off');
        if ($round) {
            $price = round($price);
        }

        return $price;
    }

}
