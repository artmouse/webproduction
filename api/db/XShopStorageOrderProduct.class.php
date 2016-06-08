<?php
/**
 * Class XShopStorageOrderProduct is ORM to table shopstorageordertproduct
 * @author SQLObject
 * @package SQLObject
 */
class XShopStorageOrderProduct extends SQLObject {

    /**
     * Get id
     * @return int
     */
    public function getId() { return $this->getField('id');}

    /**
     * Set id
     * @param int $id
     */
    public function setId($id, $update = false) {$this->setField('id', $id, $update);}

    /**
     * Filter id
     * @param int $id
     * @param string $operation
     */
    public function filterId($id, $operation = false) {$this->filterField('id', $id, $operation);}

    /**
     * Get orderid
     * @return int
     */
    public function getOrderid() { return $this->getField('orderid');}

    /**
     * Set orderid
     * @param int $orderid
     */
    public function setOrderid($orderid, $update = false) {$this->setField('orderid', $orderid, $update);}

    /**
     * Filter orderid
     * @param int $orderid
     * @param string $operation
     */
    public function filterOrderid($orderid, $operation = false) {$this->filterField('orderid', $orderid, $operation);}

    /**
     * Get productid
     * @return int
     */
    public function getProductid() { return $this->getField('productid');}

    /**
     * Set productid
     * @param int $productid
     */
    public function setProductid($productid, $update = false) {$this->setField('productid', $productid, $update);}

    /**
     * Filter productid
     * @param int $productid
     * @param string $operation
     */
    public function filterProductid($productid, $operation = false) {$this->filterField('productid', $productid, $operation);}

    /**
     * Get amount
     * @return float
     */
    public function getAmount() { return $this->getField('amount');}

    /**
     * Set amount
     * @param float $amount
     */
    public function setAmount($amount, $update = false) {$this->setField('amount', $amount, $update);}

    /**
     * Filter amount
     * @param float $amount
     * @param string $operation
     */
    public function filterAmount($amount, $operation = false) {$this->filterField('amount', $amount, $operation);}

    /**
     * Get price
     * @return float
     */
    public function getPrice() { return $this->getField('price');}

    /**
     * Set price
     * @param float $price
     */
    public function setPrice($price, $update = false) {$this->setField('price', $price, $update);}

    /**
     * Filter price
     * @param float $price
     * @param string $operation
     */
    public function filterPrice($price, $operation = false) {$this->filterField('price', $price, $operation);}

    /**
     * Get currencyrate
     * @return float
     */
    public function getCurrencyrate() { return $this->getField('currencyrate');}

    /**
     * Set currencyrate
     * @param float $currencyrate
     */
    public function setCurrencyrate($currencyrate, $update = false) {$this->setField('currencyrate', $currencyrate, $update);}

    /**
     * Filter currencyrate
     * @param float $currencyrate
     * @param string $operation
     */
    public function filterCurrencyrate($currencyrate, $operation = false) {$this->filterField('currencyrate', $currencyrate, $operation);}

    /**
     * Get currencyid
     * @return int
     */
    public function getCurrencyid() { return $this->getField('currencyid');}

    /**
     * Set currencyid
     * @param int $currencyid
     */
    public function setCurrencyid($currencyid, $update = false) {$this->setField('currencyid', $currencyid, $update);}

    /**
     * Filter currencyid
     * @param int $currencyid
     * @param string $operation
     */
    public function filterCurrencyid($currencyid, $operation = false) {$this->filterField('currencyid', $currencyid, $operation);}

    /**
     * Get taxrate
     * @return float
     */
    public function getTaxrate() { return $this->getField('taxrate');}

    /**
     * Set taxrate
     * @param float $taxrate
     */
    public function setTaxrate($taxrate, $update = false) {$this->setField('taxrate', $taxrate, $update);}

    /**
     * Filter taxrate
     * @param float $taxrate
     * @param string $operation
     */
    public function filterTaxrate($taxrate, $operation = false) {$this->filterField('taxrate', $taxrate, $operation);}

    /**
     * Get isshipped
     * @return int
     */
    public function getIsshipped() { return $this->getField('isshipped');}

    /**
     * Set isshipped
     * @param int $isshipped
     */
    public function setIsshipped($isshipped, $update = false) {$this->setField('isshipped', $isshipped, $update);}

    /**
     * Filter isshipped
     * @param int $isshipped
     * @param string $operation
     */
    public function filterIsshipped($isshipped, $operation = false) {$this->filterField('isshipped', $isshipped, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopstorageordertproduct');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStorageOrderProduct
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStorageOrderProduct
     */
    public static function Get($key) {return self::GetObject("XShopStorageOrderProduct", $key);}

}

SQLObject::SetFieldArray('shopstorageordertproduct', array('id', 'orderid', 'productid', 'amount', 'price', 'currencyrate', 'currencyid', 'taxrate', 'isshipped'));
SQLObject::SetPrimaryKey('shopstorageordertproduct', 'id');
