<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class FinanceInvoiceProduct extends XFinanceInvoiceProduct {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return FinanceInvoiceProduct
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return FinanceInvoiceProduct
     */
    public static function Get($key) {
        return self::GetObject('FinanceInvoiceProduct', $key);
    }

    /**
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID(
        $this->getCurrencyid()
        );
    }

    /**
     * @return FinanceInvoice
     */
    public function getInvoice() {
        return InvoiceService::Get()->getInvoiceByID($this->getInvoiceid());
    }

    /**
     * @return ShopProduct
     */
    public function getProduct() {
        return Shop::Get()->getShopService()->getProductByID($this->getProductid());
    }

}