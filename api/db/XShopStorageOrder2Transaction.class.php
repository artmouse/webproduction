<?php
/**
 * Class XShopStorageOrder2Transaction is ORM to table shopstorageorder2transaction
 * @author SQLObject
 * @package SQLObject
 */
class XShopStorageOrder2Transaction extends SQLObject {

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopstorageorder2transaction');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStorageOrder2Transaction
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStorageOrder2Transaction
     */
    public static function Get($key) {return self::GetObject("XShopStorageOrder2Transaction", $key);}

}

SQLObject::SetFieldArray('shopstorageorder2transaction', array('id', 'orderid', 'transactionid'));
SQLObject::SetPrimaryKey('shopstorageorder2transaction', 'id');
