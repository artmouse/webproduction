<?php
/**
 * Class XShopOrderEmployer is ORM to table shoporderemployer
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderEmployer extends SQLObject {

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
     * Get statusid
     * @return int
     */
    public function getStatusid() { return $this->getField('statusid');}

    /**
     * Set statusid
     * @param int $statusid
     */
    public function setStatusid($statusid, $update = false) {$this->setField('statusid', $statusid, $update);}

    /**
     * Filter statusid
     * @param int $statusid
     * @param string $operation
     */
    public function filterStatusid($statusid, $operation = false) {$this->filterField('statusid', $statusid, $operation);}

    /**
     * Get role
     * @return string
     */
    public function getRole() { return $this->getField('role');}

    /**
     * Set role
     * @param string $role
     */
    public function setRole($role, $update = false) {$this->setField('role', $role, $update);}

    /**
     * Filter role
     * @param string $role
     * @param string $operation
     */
    public function filterRole($role, $operation = false) {$this->filterField('role', $role, $operation);}

    /**
     * Get sum
     * @return float
     */
    public function getSum() { return $this->getField('sum');}

    /**
     * Set sum
     * @param float $sum
     */
    public function setSum($sum, $update = false) {$this->setField('sum', $sum, $update);}

    /**
     * Filter sum
     * @param float $sum
     * @param string $operation
     */
    public function filterSum($sum, $operation = false) {$this->filterField('sum', $sum, $operation);}

    /**
     * Get percent
     * @return float
     */
    public function getPercent() { return $this->getField('percent');}

    /**
     * Set percent
     * @param float $percent
     */
    public function setPercent($percent, $update = false) {$this->setField('percent', $percent, $update);}

    /**
     * Filter percent
     * @param float $percent
     * @param string $operation
     */
    public function filterPercent($percent, $operation = false) {$this->filterField('percent', $percent, $operation);}

    /**
     * Get term
     * @return string
     */
    public function getTerm() { return $this->getField('term');}

    /**
     * Set term
     * @param string $term
     */
    public function setTerm($term, $update = false) {$this->setField('term', $term, $update);}

    /**
     * Filter term
     * @param string $term
     * @param string $operation
     */
    public function filterTerm($term, $operation = false) {$this->filterField('term', $term, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoporderemployer');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderEmployer
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderEmployer
     */
    public static function Get($key) {return self::GetObject("XShopOrderEmployer", $key);}

}

SQLObject::SetFieldArray('shoporderemployer', array('id', 'orderid', 'managerid', 'statusid', 'role', 'sum', 'percent', 'term'));
SQLObject::SetPrimaryKey('shoporderemployer', 'id');
