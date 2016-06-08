<?php
/**
 * Class XShopStorageOrder is ORM to table shopstorageorder
 * @author SQLObject
 * @package SQLObject
 */
class XShopStorageOrder extends SQLObject {

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
     * Get isshipped
     * @return int
     */
    public function getIsshipped() { return $this->getField('isshipped');}

    /**
     * Set isshipped
     * @param int $isshipped
     */
    public function setIsshipped($isshipped, $update = false) {$this->setField('isshipped', $isshipped, $update);}

    /**
     * Filter isshipped
     * @param int $isshipped
     * @param string $operation
     */
    public function filterIsshipped($isshipped, $operation = false) {$this->filterField('isshipped', $isshipped, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopstorageorder');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStorageOrder
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStorageOrder
     */
    public static function Get($key) {return self::GetObject("XShopStorageOrder", $key);}

}

SQLObject::SetFieldArray('shopstorageorder', array('id', 'cdate', 'userid', 'type', 'storagenamefromid', 'storagenametoid', 'isshipped', 'sum'));
SQLObject::SetPrimaryKey('shopstorageorder', 'id');
