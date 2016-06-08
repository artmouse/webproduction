<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class FinancePayment extends XFinancePayment {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return FinancePayment
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return FinancePayment
     */
    public static function Get($key) {
        return self::GetObject('FinancePayment', $key);
    }

    /**
     * @return User
     */
    public function getUser() {
        return Shop::Get()->getUserService()->getUserByID($this->getUserid());
    }

    /**
     * @return User
     */
    public function getClient() {
        return Shop::Get()->getUserService()->getUserByID($this->getClientid());
    }

    /**
     * @return ShopOrder
     */
    public function getOrder() {
        // сначала найдем платеж по ID
        if ($this->getOrderid()) {
        	return Shop::Get()->getShopService()->getOrderByID($this->getOrderid());
        }

        // затем попытаемся по linkkey
        if (preg_match("/^order-(\d+)$/ius", $this->getLinkkey(), $r)) {
            return Shop::Get()->getShopService()->getOrderByID($r[1]);
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * @return ShopCurrency
     */
    public function getAccountCurrency() {
        return $this->getAccount()->getCurrency();
    }

    /**
     * @return FinanceCategory
     */
    public function getCategory() {
        return FinanceService::Get()->getCategoryByID($this->getCategoryid());
    }

    /**
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID($this->getCurrencyid());
    }

    /**
     * @return FinanceAccount
     */
    public function getAccount() {
        return FinanceService::Get()->getAccountByID($this->getAccountid());
    }

    /**
     * Является ли платеж трансфером между аккаунтами
     *
     * @return bool
     */
    public function isTransfer() {
        return (bool) preg_match("/^transfer-(\d+)$/ius", $this->getLinkkey());
    }

    /**
     * @return FinancePayment
     */
    public function getTransferPayment() {
        if (preg_match("/^transfer-(\d+)$/ius", $this->getLinkkey(), $r)) {
            return PaymentService::Get()->getPaymentByID($r[1]);
        }
        throw new ServiceUtils_Exception();
    }

}