<?php
/**
 * Class XShopStorageReserve is ORM to table shopstoragereserve
 * @author SQLObject
 * @package SQLObject
 */
class XShopStorageReserve extends SQLObject {

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
     * Get storagenameid
     * @return int
     */
    public function getStoragenameid() { return $this->getField('storagenameid');}

    /**
     * Set storagenameid
     * @param int $storagenameid
     */
    public function setStoragenameid($storagenameid, $update = false) {$this->setField('storagenameid', $storagenameid, $update);}

    /**
     * Filter storagenameid
     * @param int $storagenameid
     * @param string $operation
     */
    public function filterStoragenameid($storagenameid, $operation = false) {$this->filterField('storagenameid', $storagenameid, $operation);}

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
     * Get rrc
     * @return float
     */
    public function getRrc() { return $this->getField('rrc');}

    /**
     * Set rrc
     * @param float $rrc
     */
    public function setRrc($rrc, $update = false) {$this->setField('rrc', $rrc, $update);}

    /**
     * Filter rrc
     * @param float $rrc
     * @param string $operation
     */
    public function filterRrc($rrc, $operation = false) {$this->filterField('rrc', $rrc, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopstoragereserve');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStorageReserve
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStorageReserve
     */
    public static function Get($key) {return self::GetObject("XShopStorageReserve", $key);}

}

SQLObject::SetFieldArray('shopstoragereserve', array('id', 'storagenameid', 'productid', 'amount', 'rrc', 'currencyid'));
SQLObject::SetPrimaryKey('shopstoragereserve', 'id');
