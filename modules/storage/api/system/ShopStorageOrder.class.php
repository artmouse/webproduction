<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopStorageOrder extends XShopStorageOrder {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopStorageOrder
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopStorageOrder
     */
    public static function Get($key) {
        return self::GetObject('ShopStorageOrder', $key);
    }

    /**
     * @return ShopStorageName
     */
    public function getStorageNameTo() {
        return StorageNameService::Get()->getStorageNameByID($this->getStoragenametoid());
    }

    /**
     * @return ShopStorageName
     */
    public function getStorageNameFrom() {
        return StorageNameService::Get()->getStorageNameByID($this->getStoragenamefromid());
    }

    /**
     * @return string
     */
    public function makeURLEdit() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-storage-order-control',
        $this->getId()
        );
    }

    /**
     * @return ShopStorageOrderProduct
     */
    public function getStorageOrderProducts() {
        return StorageOrderService::Get()->getStorageOrderProducts($this);
    }

    /**
     * @return array
     */
    public function makeAssignArrayForDocument() {
        $order = $this;
        $productsSum = 0;

        $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();

        // формируем документ
        $productsArray = array();
        $orderproducts = $order->getStorageOrderProducts();
        while ($op = $orderproducts->getNext()) {
            try {
                $productsArray[] = array(
                'productid' => $op->getProductid(),
                'name' => $op->getProduct()->getName(),
                'price' => $op->getPrice(),
                'currency' => $currency->getSymbol(),
                'count' => $op->getAmount(),
                'sum' => number_format(round($op->getAmount() * $op->getPrice(), 2), 2),
                'unit' => $op->getProduct()->getUnit()
                );

                // сумма всех товаров
                $productsSum += $op->getAmount();
            } catch (Exception $e) {

            }
        }

        $a = array();
        $a['number'] = $order->getId();
        $a['productsArray'] = $productsArray;
        $a['productsum'] = number_format($productsSum, 3);
        $a['ordersum'] = $order->getSum();
        $a['ordersumtext'] = StringUtils_Converter::FloatToMoney($order->getSum(), 'ua');
        $a['ordercurrency'] = $currency->getSymbol();
        $a['orderid'] = $order->getId();
        $a['orderdate'] = DateTime_Formatter::DateRussianGOST($order->getCdate()); // @todo: in multi-languages

        return $a;
    }

}