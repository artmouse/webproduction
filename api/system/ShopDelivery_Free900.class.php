<?php
/**
 * Класс для проверки возможности получения бесплатной доставки клиентом
 * 
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class ShopDelivery_Free900 {

    public function __construct(ShopDelivery $delivery) {
        $this->_delivery = $delivery;
    }
    
    /**
     * Метод предоставляет возможность прощитать бесплатную доставку при сумме заказа свыше 900
     * 
     * @param array $basketArray Массив данных покупок из корзины
     * @param boolean $discount  Дискаунт покупок по умолчанию выставлен false
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

        if ($sum >= 900) {
            return 0;
        } else {
            return $this->_delivery->makePrice($currencyDefault);
        }

    }

    private $_delivery = 0;

}