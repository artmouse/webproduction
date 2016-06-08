<?php
/**
 * Class XShopTimeLog is ORM to table shoptimelog
 * @author SQLObject
 * @package SQLObject
 */
class XShopTimeLog extends SQLObject {

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
     * Get time
     * @return int
     */
    public function getTime() { return $this->getField('time');}

    /**
     * Set time
     * @param int $time
     */
    public function setTime($time, $update = false) {$this->setField('time', $time, $update);}

    /**
     * Filter time
     * @param int $time
     * @param string $operation
     */
    public function filterTime($time, $operation = false) {$this->filterField('time', $time, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoptimelog');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopTimeLog
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopTimeLog
     */
    public static function Get($key) {return self::GetObject("XShopTimeLog", $key);}

}

SQLObject::SetFieldArray('shoptimelog', array('id', 'orderid', 'userid', 'cdate', 'time'));
SQLObject::SetPrimaryKey('shoptimelog', 'id');
