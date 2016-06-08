<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class FinanceAccount extends XFinanceAccount {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return FinanceAccount
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return FinancePayment
     */
    public static function Get($key) {
        return self::GetObject('FinanceAccount', $key);
    }

    /**
     * @return ShopContractor
     */
    public function getContractor() {
        return Shop::Get()->getShopService()->getContractorByID(
        $this->getContractorid()
        );
    }

    /**
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID(
        $this->getCurrencyid()
        );
    }

    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    public function makeURL() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-finance-index',
        $this->getId(),
        'accountid'
        );
    }

    public function makeBalance() {
        return FinanceService::Get()->calculateAccountBalance($this);
    }

}