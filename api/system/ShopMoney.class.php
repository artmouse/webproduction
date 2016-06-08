<?php
class ShopMoney {

    public function __construct($amount, ShopCurrency $currency, $taxRate) {
        $this->_amount = round($amount, 2);
        $this->_currency = $currency;
        $this->_setTaxRate($taxRate);
    }

    /**
     * Пересчитать значение в другой валюте
     *
     * @param ShopCurrency $currency
     * @return ShopMoney
     */
    public function changeCurrency(ShopCurrency $currency) {
        $currencyCurrent = $this->_currency;

        // если новая валюта не равна текущей
        if ($currency->getId() != $currencyCurrent->getId()) {
            // конвертируем
            $this->_amount = Shop::Get()->getCurrencyService()->convertCurrency(
            $this->_amount,
            $currencyCurrent,
            $currency
            );

            $this->_currency = $currency;
        }

        return $this;
    }

    /**
     * Включать НДС в значение
     *
     * @param int $taxRate
     * @return ShopMoney
     */
    public function includeTax($taxRate) {
        if ($taxRate >= 0) {
            $this->_tax_rate = $taxRate;
        }

        $this->_include_tax = true;

        return $this;
    }

    /**
     * Не включать НДС в значение
     *
     * @return ShopMoney
     */
    public function excludeTax() {
        $this->_include_tax = false;
        return $this;
    }

    /**
     * Применить скидку (в %)
     *
     * @param int $discountPercent
     * @return ShopMoney
     */
    public function applyDiscountPercent($discountPercent) {
        if ($discountPercent >= 0) {
            $this->_discount_percent = $discountPercent;
        }
        return $this;
    }

    /**
     * Получить текущее значение
     *
     * @return decimal
     */
    public function getAmount() {
        return $this->_calculateAmount();
    }

    /**
     * Получить текущую валюту
     *
     * @return ShopCurrency
     */
    public function getCurrency() {
        return $this->_currency;
    }

    /**
     * Получить процент скидки
     *
     * @return int
     */
    public function getDiscountPercent() {
        return $this->_discount_percent;
    }

    /**
     * Получить процент НДС
     *
     * @return int
     */
    public function getTaxRate() {
        return $this->_tax_rate;
    }

    /**
     * Получить значение скидки
     *
     * @return decimal
     */
    public function getDiscountValue() {
        $this->_calculateAmount();
        return $this->_discount_value;
    }

    /**
     * Получить значение НДС
     *
     * @return decimal
     */
    public function getTaxValue() {
        $this->_calculateAmount();
        return $this->_tax_value;
    }

    /**
     * Установить процент НДС
     *
     * @param int $taxRate
     */
    private function _setTaxRate($taxRate) {
        // сохраняем amount без НДС
        if ($taxRate < 0) {
            $taxRate = -$taxRate;
            $this->_amount = round((100 * $this->_amount) / (100 + $taxRate), 2);
        }
        $this->_tax_rate = $taxRate;
    }

    /**
     * Подсчитать все значения (сам amount, значение скидки и НДС)
     *
     * @return decimal
     */
    private function _calculateAmount() {
        $amount = $this->_amount;
        // вычисляем amount со скидкой и значение скидки
        if ($this->_discount_percent) {
            $x = $amount;
            $amount = round($amount * (1 - $this->_discount_percent / 100), 2);
            $this->_discount_value =  $x - $amount;
        }
        if ($this->_include_tax) {
            // вычисляем amount с учетом НДС и значение НДС
            if ($this->_tax_rate) {
                $x = $amount;
                $amount = round($amount + ($amount * $this->_tax_rate / 100), 2);
                $this->_tax_value = $amount - $x;
            }
        }

        return $amount;
    }

    private $_amount = 0;
    private $_currency = false;
    private $_tax_rate = 0;
    private $_tax_value = 0;
    private $_discount_percent = 0;
    private $_discount_value = 0;
    private $_include_tax = false;
}