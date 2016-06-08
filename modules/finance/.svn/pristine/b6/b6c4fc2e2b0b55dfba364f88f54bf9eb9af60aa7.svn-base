<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class FinanceInvoice extends XFinanceInvoice {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return FinanceInvoice
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return FinanceInvoice
     */
    public static function Get($key) {
        return self::GetObject('FinanceInvoice', $key);
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
        if (preg_match("/^order-(\d+)$/ius", $this->getLinkkey(), $r)) {
            return Shop::Get()->getShopService()->getOrderByID($r[1]);
        } else {
            throw new ServiceUtils_Exception();
        }
    }

    /**
     * @return array
     */
    public function makeAssignArrayForDocument() {
        $a = array();

        try {
            // если есть привязка к заказу,
            // формируем все данные исходя из заказа
            $order = $this->getOrder();
            $a = $order->makeAssignArrayForDocument();
            $a['number'] = $this->getId();

        } catch (ServiceUtils_Exception $oe) {
            // если привязки нет
            // формируем данные
            try {
                $contractor = $this->getContractor();
                $contractorTax = $contractor->getTax();

                $a['contractordetails'] = nl2br($contractor->getDetails());
                $a['contractorname'] = $contractor->getName();
            } catch (ServiceUtils_Exception $se) {
                $contractorTax = 0;
            }

            $priceWithoutTax = Shop::Get()->getShopService()->calculateSum(
            $this->getSum(),
            $contractorTax,
            0,
            0,
            true,
            false,
            false
            );

            $productArray = array();

            $productArray[] = array(
            'name' => $this->getName(),
            'count' => 1.000,
            'pricenotax' => $priceWithoutTax,
            'sumnotax' => $priceWithoutTax
            );

            $a['number'] = $this->getId();
            $a['productsArray'] = $productArray;
            $a['productsum'] = 1.000;

            $a['ordersum'] = $this->getSum();
            $a['ordersumtext'] = StringUtils_Converter::FloatToMoney($this->getSum(), 'ua');
            $a['ordercurrency'] = $this->getCurrency()->getSymbol();

            try {
                $a['clientname'] = $this->getClient()->getName();
                $a['clientphone'] = $this->getClient()->getPhone();
                $a['clientemail'] = $this->getClient()->getEmail();
                $a['clientaddress'] = $this->getClient()->getAddress();
            } catch (ServiceUtils_Exception $se) {

            }

            $a['orderdate'] = DateTime_Formatter::DateRussianGOST($this->getCdate()); // @todo: in multi-languages

            $taxSum = $this->getSum() - $priceWithoutTax;
            $a['taxsum'] = round($taxSum, 2);

            $a['discountsum'] = 0.00;
            $a['deliveryprice'] = 0.00;

            $a['ordersumwithtax'] = round($this->getSum(), 2);
            $a['ordersumwithouttax'] = round($priceWithoutTax, 2);
        }

        return $a;
    }

}