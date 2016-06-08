<?php
/**
 * Class XShopStorageBalance is ORM to table shopstoragebalance
 * @author SQLObject
 * @package SQLObject
 */
class XShopStorageBalance extends SQLObject {

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
     * Get productname
     * @return string
     */
    public function getProductname() { return $this->getField('productname');}

    /**
     * Set productname
     * @param string $productname
     */
    public function setProductname($productname, $update = false) {$this->setField('productname', $productname, $update);}

    /**
     * Filter productname
     * @param string $productname
     * @param string $operation
     */
    public function filterProductname($productname, $operation = false) {$this->filterField('productname', $productname, $operation);}

    /**
     * Get code
     * @return string
     */
    public function getCode() { return $this->getField('code');}

    /**
     * Set code
     * @param string $code
     */
    public function setCode($code, $update = false) {$this->setField('code', $code, $update);}

    /**
     * Filter code
     * @param string $code
     * @param string $operation
     */
    public function filterCode($code, $operation = false) {$this->filterField('code', $code, $operation);}

    /**
     * Get shipment
     * @return string
     */
    public function getShipment() { return $this->getField('shipment');}

    /**
     * Set shipment
     * @param string $shipment
     */
    public function setShipment($shipment, $update = false) {$this->setField('shipment', $shipment, $update);}

    /**
     * Filter shipment
     * @param string $shipment
     * @param string $operation
     */
    public function filterShipment($shipment, $operation = false) {$this->filterField('shipment', $shipment, $operation);}

    /**
     * Get serial
     * @return string
     */
    public function getSerial() { return $this->getField('serial');}

    /**
     * Set serial
     * @param string $serial
     */
    public function setSerial($serial, $update = false) {$this->setField('serial', $serial, $update);}

    /**
     * Filter serial
     * @param string $serial
     * @param string $operation
     */
    public function filterSerial($serial, $operation = false) {$this->filterField('serial', $serial, $operation);}

    /**
     * Get cdate
     * @return string
     */
    public function getCdate() { return $this->getField('cdate');}

    /**
     * Set cdate
     * @param string $cdate
     */
    public function setCdate($cdate, $update = false) {$this->setField('cdate', $cdate, $update);}

    /**
     * Filter cdate
     * @param string $cdate
     * @param string $operation
     */
    public function filterCdate($cdate, $operation = false) {$this->filterField('cdate', $cdate, $operation);}

    /**
     * Get pricebase
     * @return float
     */
    public function getPricebase() { return $this->getField('pricebase');}

    /**
     * Set pricebase
     * @param float $pricebase
     */
    public function setPricebase($pricebase, $update = false) {$this->setField('pricebase', $pricebase, $update);}

    /**
     * Filter pricebase
     * @param float $pricebase
     * @param string $operation
     */
    public function filterPricebase($pricebase, $operation = false) {$this->filterField('pricebase', $pricebase, $operation);}

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
     * Get amountlinked
     * @return float
     */
    public function getAmountlinked() { return $this->getField('amountlinked');}

    /**
     * Set amountlinked
     * @param float $amountlinked
     */
    public function setAmountlinked($amountlinked, $update = false) {$this->setField('amountlinked', $amountlinked, $update);}

    /**
     * Filter amountlinked
     * @param float $amountlinked
     * @param string $operation
     */
    public function filterAmountlinked($amountlinked, $operation = false) {$this->filterField('amountlinked', $amountlinked, $operation);}

    /**
     * Get cost
     * @return float
     */
    public function getCost() { return $this->getField('cost');}

    /**
     * Set cost
     * @param float $cost
     */
    public function setCost($cost, $update = false) {$this->setField('cost', $cost, $update);}

    /**
     * Filter cost
     * @param float $cost
     * @param string $operation
     */
    public function filterCost($cost, $operation = false) {$this->filterField('cost', $cost, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopstoragebalance');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStorageBalance
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStorageBalance
     */
    public static function Get($key) {return self::GetObject("XShopStorageBalance", $key);}

}

SQLObject::SetFieldArray('shopstoragebalance', array('id', 'storagenameid', 'productid', 'productname', 'code', 'shipment', 'serial', 'cdate', 'pricebase', 'amount', 'amountlinked', 'cost', 'price', 'currencyrate', 'currencyid', 'taxrate'));
SQLObject::SetPrimaryKey('shopstoragebalance', 'id');
