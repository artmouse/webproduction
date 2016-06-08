<?php
/**
 * Class XShopKPIUser is ORM to table shopkpiuser
 * @author SQLObject
 * @package SQLObject
 */
class XShopKPIUser extends SQLObject {

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
     * Get kpiid
     * @return int
     */
    public function getKpiid() { return $this->getField('kpiid');}

    /**
     * Set kpiid
     * @param int $kpiid
     */
    public function setKpiid($kpiid, $update = false) {$this->setField('kpiid', $kpiid, $update);}

    /**
     * Filter kpiid
     * @param int $kpiid
     * @param string $operation
     */
    public function filterKpiid($kpiid, $operation = false) {$this->filterField('kpiid', $kpiid, $operation);}

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
     * Get value
     * @return float
     */
    public function getValue() { return $this->getField('value');}

    /**
     * Set value
     * @param float $value
     */
    public function setValue($value, $update = false) {$this->setField('value', $value, $update);}

    /**
     * Filter value
     * @param float $value
     * @param string $operation
     */
    public function filterValue($value, $operation = false) {$this->filterField('value', $value, $operation);}

    /**
     * Get valueplan
     * @return float
     */
    public function getValueplan() { return $this->getField('valueplan');}

    /**
     * Set valueplan
     * @param float $valueplan
     */
    public function setValueplan($valueplan, $update = false) {$this->setField('valueplan', $valueplan, $update);}

    /**
     * Filter valueplan
     * @param float $valueplan
     * @param string $operation
     */
    public function filterValueplan($valueplan, $operation = false) {$this->filterField('valueplan', $valueplan, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopkpiuser');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopKPIUser
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopKPIUser
     */
    public static function Get($key) {return self::GetObject("XShopKPIUser", $key);}

}

SQLObject::SetFieldArray('shopkpiuser', array('id', 'kpiid', 'userid', 'cdate', 'value', 'valueplan'));
SQLObject::SetPrimaryKey('shopkpiuser', 'id');
