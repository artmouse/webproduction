<?php
/**
 * Class XShopStorageLink is ORM to table shopstoragelink
 * @author SQLObject
 * @package SQLObject
 */
class XShopStorageLink extends SQLObject {

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
     * Get storagebalanceid
     * @return int
     */
    public function getStoragebalanceid() { return $this->getField('storagebalanceid');}

    /**
     * Set storagebalanceid
     * @param int $storagebalanceid
     */
    public function setStoragebalanceid($storagebalanceid, $update = false) {$this->setField('storagebalanceid', $storagebalanceid, $update);}

    /**
     * Filter storagebalanceid
     * @param int $storagebalanceid
     * @param string $operation
     */
    public function filterStoragebalanceid($storagebalanceid, $operation = false) {$this->filterField('storagebalanceid', $storagebalanceid, $operation);}

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
     * Get basketid
     * @return int
     */
    public function getBasketid() { return $this->getField('basketid');}

    /**
     * Set basketid
     * @param int $basketid
     */
    public function setBasketid($basketid, $update = false) {$this->setField('basketid', $basketid, $update);}

    /**
     * Filter basketid
     * @param int $basketid
     * @param string $operation
     */
    public function filterBasketid($basketid, $operation = false) {$this->filterField('basketid', $basketid, $operation);}

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
        $this->setTablename('shopstoragelink');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStorageLink
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStorageLink
     */
    public static function Get($key) {return self::GetObject("XShopStorageLink", $key);}

}

SQLObject::SetFieldArray('shopstoragelink', array('id', 'cdate', 'storagebalanceid', 'userid', 'basketid', 'amount', 'orderid', 'orderproductid'));
SQLObject::SetPrimaryKey('shopstoragelink', 'id');
