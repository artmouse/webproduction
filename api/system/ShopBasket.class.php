<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * *
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
     * *
     * @return ShopBasket
     */
    public function getNext($exception = false) {
        $x = 1; // sniffer fix Possible useless method overriding detected
        return parent::getNext($exception);
    }

    /**
     * Получить товар
     *
     * @return ShopProductShop_BannerService
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
     * 
     * @return float
     */
    public function makeSum(ShopCurrency $currency) {
        return round($this->makePrice($currency) * $this->getProductcount(), 2);
    }

    public function makePrice(ShopCurrency $currency, $discount = true) {
        $product = $this->getProduct();

        // сначала получаем цену корзины
        $price = $this->getProductprice();
        $price = round($price, 2);

        // затем уже как есть
        if (!$price) {
            $price = $product->getPrice();
        }
        $price = round($price, 2);

        $price = Shop::Get()->getCurrencyService()->convertCurrency(
            $price,
            $product->getCurrency(),
            $currency
        );

        // к цене добавляем наценки по опциям
        if ($price) {
            for ($j = 1; $j <= 10; $j++) {
                // если цена отображается не в базовой валюте, то пытаемся перевести наценки в валюту цены
                if ($currencyX =  Shop::Get()->getCurrencyService()->getCurrencySystem()) {
                    $price += Shop::Get()->getCurrencyService()->convertCurrency(
                        $this->getField('filter'.$j.'markup'),
                        $currencyX,
                        $currency
                    );
                } else {
                    $price += $this->getField('filter'.$j.'markup');
                }
            }
        }

        // если есть скидка по предзаказу, товара нет в наличии и на него есть скидка, то делаем скидку
        if ($product->getPreorderDiscount() && !$product->getAvail() && $discount) {
            $price *= (1 - $product->getDiscount() / 100);
        } else if (!$product->getPreorderDiscount() and $discount) {
            $price *= (1 - $product->getDiscount() / 100);
        }

        $round = Shop::Get()->getSettingsService()->getSettingValue('price-rounding-off');
        if ($round) {
            $price = round($price);
        } else {
            $price = round($price, 2);
        }

        return $price;
    }

    /**
     * MakePriceWithTax
     * 
     * @param ShopCurrency $currency
     * @param int $discount
     * 
     * @deprecated
     * @see makePrice()
     * 
     * @return flost
     */
    public function makePriceWithTax (ShopCurrency $currency, $discount = true) {
        return $this->makePrice($currency, $discount);
    }

}