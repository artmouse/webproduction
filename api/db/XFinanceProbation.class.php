<?php
/**
 * Class XFinanceProbation is ORM to table financeprobation
 * @author SQLObject
 * @package SQLObject
 */
class XFinanceProbation extends SQLObject {

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
     * Get pdate
     * @return string
     */
    public function getPdate() { return $this->getField('pdate');}

    /**
     * Set pdate
     * @param string $pdate
     */
    public function setPdate($pdate, $update = false) {$this->setField('pdate', $pdate, $update);}

    /**
     * Filter pdate
     * @param string $pdate
     * @param string $operation
     */
    public function filterPdate($pdate, $operation = false) {$this->filterField('pdate', $pdate, $operation);}

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
     * Get amountbase
     * @return float
     */
    public function getAmountbase() { return $this->getField('amountbase');}

    /**
     * Set amountbase
     * @param float $amountbase
     */
    public function setAmountbase($amountbase, $update = false) {$this->setField('amountbase', $amountbase, $update);}

    /**
     * Filter amountbase
     * @param float $amountbase
     * @param string $operation
     */
    public function filterAmountbase($amountbase, $operation = false) {$this->filterField('amountbase', $amountbase, $operation);}

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
     * Get managerid
     * @return int
     */
    public function getManagerid() { return $this->getField('managerid');}

    /**
     * Set managerid
     * @param int $managerid
     */
    public function setManagerid($managerid, $update = false) {$this->setField('managerid', $managerid, $update);}

    /**
     * Filter managerid
     * @param int $managerid
     * @param string $operation
     */
    public function filterManagerid($managerid, $operation = false) {$this->filterField('managerid', $managerid, $operation);}

    /**
     * Get received
     * @return int
     */
    public function getReceived() { return $this->getField('received');}

    /**
     * Set received
     * @param int $received
     */
    public function setReceived($received, $update = false) {$this->setField('received', $received, $update);}

    /**
     * Filter received
     * @param int $received
     * @param string $operation
     */
    public function filterReceived($received, $operation = false) {$this->filterField('received', $received, $operation);}

    /**
     * Get accountid
     * @return int
     */
    public function getAccountid() { return $this->getField('accountid');}

    /**
     * Set accountid
     * @param int $accountid
     */
    public function setAccountid($accountid, $update = false) {$this->setField('accountid', $accountid, $update);}

    /**
     * Filter accountid
     * @param int $accountid
     * @param string $operation
     */
    public function filterAccountid($accountid, $operation = false) {$this->filterField('accountid', $accountid, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('financeprobation');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XFinanceProbation
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XFinanceProbation
     */
    public static function Get($key) {return self::GetObject("XFinanceProbation", $key);}

}

SQLObject::SetFieldArray('financeprobation', array('id', 'orderid', 'cdate', 'pdate', 'amount', 'amountbase', 'currencyid', 'managerid', 'received', 'accountid', 'contractorid'));
SQLObject::SetPrimaryKey('financeprobation', 'id');
