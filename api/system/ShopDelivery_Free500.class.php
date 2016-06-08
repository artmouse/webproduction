<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class ShopDelivery_Free500 {

    public function __construct(ShopDelivery $delivery) {
        $this->_delivery = $delivery;
    }
    
    /**
     * Method process
     *
     * @param array $basketArray
     * @param ShopDiscount $discount
     * 
     * @return int
     */
    public function process($basketArray, $discount = false) {
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

        $sum = 0;
        foreach ($basketArray as $x) {
            try {
                $sum += $x->makeSum($currencyDefault);

            } catch (Exception $e) {

            }
        }

        if ($discount) {
            try{
                // сумма нашей скидки
                $discountSum = round($discount->makeDiscountValue($sum, $currencyDefault), 2);
                // пересчитываем общую стоимость заказа
                $sum -= $discountSum;
            } catch (Exception $e) {

            }

        }

        if ($sum >= 500) {
            return 0;
        } else {
            return $this->_delivery->makePrice($currencyDefault);
        }

    }

    private $_delivery = 0;

}