<?php
/**
 * Class XShopStorageTransaction is ORM to table shopstoragetransaction
 * @author SQLObject
 * @package SQLObject
 */
class XShopStorageTransaction extends SQLObject {

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
     * Get returntransactionid
     * @return int
     */
    public function getReturntransactionid() { return $this->getField('returntransactionid');}

    /**
     * Set returntransactionid
     * @param int $returntransactionid
     */
    public function setReturntransactionid($returntransactionid, $update = false) {$this->setField('returntransactionid', $returntransactionid, $update);}

    /**
     * Filter returntransactionid
     * @param int $returntransactionid
     * @param string $operation
     */
    public function filterReturntransactionid($returntransactionid, $operation = false) {$this->filterField('returntransactionid', $returntransactionid, $operation);}

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
     * Get client
     * @return string
     */
    public function getClient() { return $this->getField('client');}

    /**
     * Set client
     * @param string $client
     */
    public function setClient($client, $update = false) {$this->setField('client', $client, $update);}

    /**
     * Filter client
     * @param string $client
     * @param string $operation
     */
    public function filterClient($client, $operation = false) {$this->filterField('client', $client, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopstoragetransaction');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStorageTransaction
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStorageTransaction
     */
    public static function Get($key) {return self::GetObject("XShopStorageTransaction", $key);}

}

SQLObject::SetFieldArray('shopstoragetransaction', array('id', 'userid', 'cdate', 'date', 'amount', 'cost', 'type', 'storagenamefromid', 'storagenametoid', 'return', 'returntransactionid', 'document', 'request', 'orderid', 'client'));
SQLObject::SetPrimaryKey('shopstoragetransaction', 'id');
