<?php
/**
 * Class XShopStorageBasket is ORM to table shopstoragebasket
 * @author SQLObject
 * @package SQLObject
 */
class XShopStorageBasket extends SQLObject {

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
     * Get userid
     * @return int
     */
    public function getUserid() { return $this->getField('userid');}

    /**
     * Set userid
     * @param int $userid
     */
    public function setUserid($userid, $update = false) {$this->setField('userid', $userid, $update);}

    /**
     * Filter userid
     * @param int $userid
     * @param string $operation
     */
    public function filterUserid($userid, $operation = false) {$this->filterField('userid', $userid, $operation);}

    /**
     * Get type
     * @return string
     */
    public function getType() { return $this->getField('type');}

    /**
     * Set type
     * @param string $type
     */
    public function setType($type, $update = false) {$this->setField('type', $type, $update);}

    /**
     * Filter type
     * @param string $type
     * @param string $operation
     */
    public function filterType($type, $operation = false) {$this->filterField('type', $type, $operation);}

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
     * Get orderproductid
     * @return int
     */
    public function getOrderproductid() { return $this->getField('orderproductid');}

    /**
     * Set orderproductid
     * @param int $orderproductid
     */
    public function setOrderproductid($orderproductid, $update = false) {$this->setField('orderproductid', $orderproductid, $update);}

    /**
     * Filter orderproductid
     * @param int $orderproductid
     * @param string $operation
     */
    public function filterOrderproductid($orderproductid, $operation = false) {$this->filterField('orderproductid', $orderproductid, $operation);}

    /**
     * Get storageorderproductid
     * @return int
     */
    public function getStorageorderproductid() { return $this->getField('storageorderproductid');}

    /**
     * Set storageorderproductid
     * @param int $storageorderproductid
     */
    public function setStorageorderproductid($storageorderproductid, $update = false) {$this->setField('storageorderproductid', $storageorderproductid, $update);}

    /**
     * Filter storageorderproductid
     * @param int $storageorderproductid
     * @param string $operation
     */
    public function filterStorageorderproductid($storageorderproductid, $operation = false) {$this->filterField('storageorderproductid', $storageorderproductid, $operation);}

    /**
     * Get storageordersync
     * @return int
     */
    public function getStorageordersync() { return $this->getField('storageordersync');}

    /**
     * Set storageordersync
     * @param int $storageordersync
     */
    public function setStorageordersync($storageordersync, $update = false) {$this->setField('storageordersync', $storageordersync, $update);}

    /**
     * Filter storageordersync
     * @param int $storageordersync
     * @param string $operation
     */
    public function filterStorageordersync($storageordersync, $operation = false) {$this->filterField('storageordersync', $storageordersync, $operation);}

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
     * Get warranty
     * @return string
     */
    public function getWarranty() { return $this->getField('warranty');}

    /**
     * Set warranty
     * @param string $warranty
     */
    public function setWarranty($warranty, $update = false) {$this->setField('warranty', $warranty, $update);}

    /**
     * Filter warranty
     * @param string $warranty
     * @param string $operation
     */
    public function filterWarranty($warranty, $operation = false) {$this->filterField('warranty', $warranty, $operation);}

    /**
     * Get tax
     * @return int
     */
    public function getTax() { return $this->getField('tax');}

    /**
     * Set tax
     * @param int $tax
     */
    public function setTax($tax, $update = false) {$this->setField('tax', $tax, $update);}

    /**
     * Filter tax
     * @param int $tax
     * @param string $operation
     */
    public function filterTax($tax, $operation = false) {$this->filterField('tax', $tax, $operation);}

    /**
     * Get workerid
     * @return int
     */
    public function getWorkerid() { return $this->getField('workerid');}

    /**
     * Set workerid
     * @param int $workerid
     */
    public function setWorkerid($workerid, $update = false) {$this->setField('workerid', $workerid, $update);}

    /**
     * Filter workerid
     * @param int $workerid
     * @param string $operation
     */
    public function filterWorkerid($workerid, $operation = false) {$this->filterField('workerid', $workerid, $operation);}

    /**
     * Get workeroperation
     * @return string
     */
    public function getWorkeroperation() { return $this->getField('workeroperation');}

    /**
     * Set workeroperation
     * @param string $workeroperation
     */
    public function setWorkeroperation($workeroperation, $update = false) {$this->setField('workeroperation', $workeroperation, $update);}

    /**
     * Filter workeroperation
     * @param string $workeroperation
     * @param string $operation
     */
    public function filterWorkeroperation($workeroperation, $operation = false) {$this->filterField('workeroperation', $workeroperation, $operation);}

    /**
     * Get storagenamefromid
     * @return int
     */
    public function getStoragenamefromid() { return $this->getField('storagenamefromid');}

    /**
     * Set storagenamefromid
     * @param int $storagenamefromid
     */
    public function setStoragenamefromid($storagenamefromid, $update = false) {$this->setField('storagenamefromid', $storagenamefromid, $update);}

    /**
     * Filter storagenamefromid
     * @param int $storagenamefromid
     * @param string $operation
     */
    public function filterStoragenamefromid($storagenamefromid, $operation = false) {$this->filterField('storagenamefromid', $storagenamefromid, $operation);}

    /**
     * Get istarget
     * @return int
     */
    public function getIstarget() { return $this->getField('istarget');}

    /**
     * Set istarget
     * @param int $istarget
     */
    public function setIstarget($istarget, $update = false) {$this->setField('istarget', $istarget, $update);}

    /**
     * Filter istarget
     * @param int $istarget
     * @param string $operation
     */
    public function filterIstarget($istarget, $operation = false) {$this->filterField('istarget', $istarget, $operation);}

    /**
     * Get passportid
     * @return int
     */
    public function getPassportid() { return $this->getField('passportid');}

    /**
     * Set passportid
     * @param int $passportid
     */
    public function setPassportid($passportid, $update = false) {$this->setField('passportid', $passportid, $update);}

    /**
     * Filter passportid
     * @param int $passportid
     * @param string $operation
     */
    public function filterPassportid($passportid, $operation = false) {$this->filterField('passportid', $passportid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopstoragebasket');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStorageBasket
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStorageBasket
     */
    public static function Get($key) {return self::GetObject("XShopStorageBasket", $key);}

}

SQLObject::SetFieldArray('shopstoragebasket', array('id', 'cdate', 'userid', 'type', 'orderid', 'productid', 'amount', 'serial', 'orderproductid', 'storageorderproductid', 'storageordersync', 'shipment', 'price', 'currencyid', 'warranty', 'tax', 'workerid', 'workeroperation', 'storagenamefromid', 'istarget', 'passportid'));
SQLObject::SetPrimaryKey('shopstoragebasket', 'id');
