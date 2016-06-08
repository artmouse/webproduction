<?php
/**
 * Class XShopStorage is ORM to table shopstorage
 * @author SQLObject
 * @package SQLObject
 */
class XShopStorage extends SQLObject {

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
     * Get transactionid
     * @return int
     */
    public function getTransactionid() { return $this->getField('transactionid');}

    /**
     * Set transactionid
     * @param int $transactionid
     */
    public function setTransactionid($transactionid, $update = false) {$this->setField('transactionid', $transactionid, $update);}

    /**
     * Filter transactionid
     * @param int $transactionid
     * @param string $operation
     */
    public function filterTransactionid($transactionid, $operation = false) {$this->filterField('transactionid', $transactionid, $operation);}

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
     * Get storagenametoid
     * @return int
     */
    public function getStoragenametoid() { return $this->getField('storagenametoid');}

    /**
     * Set storagenametoid
     * @param int $storagenametoid
     */
    public function setStoragenametoid($storagenametoid, $update = false) {$this->setField('storagenametoid', $storagenametoid, $update);}

    /**
     * Filter storagenametoid
     * @param int $storagenametoid
     * @param string $operation
     */
    public function filterStoragenametoid($storagenametoid, $operation = false) {$this->filterField('storagenametoid', $storagenametoid, $operation);}

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
     * Get parentid
     * @return int
     */
    public function getParentid() { return $this->getField('parentid');}

    /**
     * Set parentid
     * @param int $parentid
     */
    public function setParentid($parentid, $update = false) {$this->setField('parentid', $parentid, $update);}

    /**
     * Filter parentid
     * @param int $parentid
     * @param string $operation
     */
    public function filterParentid($parentid, $operation = false) {$this->filterField('parentid', $parentid, $operation);}

    /**
     * Get isbox
     * @return int
     */
    public function getIsbox() { return $this->getField('isbox');}

    /**
     * Set isbox
     * @param int $isbox
     */
    public function setIsbox($isbox, $update = false) {$this->setField('isbox', $isbox, $update);}

    /**
     * Filter isbox
     * @param int $isbox
     * @param string $operation
     */
    public function filterIsbox($isbox, $operation = false) {$this->filterField('isbox', $isbox, $operation);}

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
     * Get contractorid
     * @return int
     */
    public function getContractorid() { return $this->getField('contractorid');}

    /**
     * Set contractorid
     * @param int $contractorid
     */
    public function setContractorid($contractorid, $update = false) {$this->setField('contractorid', $contractorid, $update);}

    /**
     * Filter contractorid
     * @param int $contractorid
     * @param string $operation
     */
    public function filterContractorid($contractorid, $operation = false) {$this->filterField('contractorid', $contractorid, $operation);}

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
     * Get date
     * @return string
     */
    public function getDate() { return $this->getField('date');}

    /**
     * Set date
     * @param string $date
     */
    public function setDate($date, $update = false) {$this->setField('date', $date, $update);}

    /**
     * Filter date
     * @param string $date
     * @param string $operation
     */
    public function filterDate($date, $operation = false) {$this->filterField('date', $date, $operation);}

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
     * Get document
     * @return string
     */
    public function getDocument() { return $this->getField('document');}

    /**
     * Set document
     * @param string $document
     */
    public function setDocument($document, $update = false) {$this->setField('document', $document, $update);}

    /**
     * Filter document
     * @param string $document
     * @param string $operation
     */
    public function filterDocument($document, $operation = false) {$this->filterField('document', $document, $operation);}

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
     * Get return
     * @return int
     */
    public function getReturn() { return $this->getField('return');}

    /**
     * Set return
     * @param int $return
     */
    public function setReturn($return, $update = false) {$this->setField('return', $return, $update);}

    /**
     * Filter return
     * @param int $return
     * @param string $operation
     */
    public function filterReturn($return, $operation = false) {$this->filterField('return', $return, $operation);}

    /**
     * Get request
     * @return string
     */
    public function getRequest() { return $this->getField('request');}

    /**
     * Set request
     * @param string $request
     */
    public function setRequest($request, $update = false) {$this->setField('request', $request, $update);}

    /**
     * Filter request
     * @param string $request
     * @param string $operation
     */
    public function filterRequest($request, $operation = false) {$this->filterField('request', $request, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopstorage');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStorage
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStorage
     */
    public static function Get($key) {return self::GetObject("XShopStorage", $key);}

}

SQLObject::SetFieldArray('shopstorage', array('id', 'transactionid', 'storagenamefromid', 'storagenametoid', 'productid', 'productname', 'parentid', 'isbox', 'serial', 'code', 'shipment', 'contractorid', 'userid', 'cdate', 'date', 'amount', 'price', 'currencyrate', 'currencyid', 'taxrate', 'pricebase', 'type', 'storageorderproductid', 'warranty', 'document', 'workerid', 'workeroperation', 'return', 'request', 'orderproductid'));
SQLObject::SetPrimaryKey('shopstorage', 'id');
