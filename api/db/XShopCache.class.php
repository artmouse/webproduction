<?php
/**
 * Class XShopCache is ORM to table shopcache
 * @author SQLObject
 * @package SQLObject
 */
class XShopCache extends SQLObject {

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
     * Get edate
     * @return string
     */
    public function getEdate() { return $this->getField('edate');}

    /**
     * Set edate
     * @param string $edate
     */
    public function setEdate($edate, $update = false) {$this->setField('edate', $edate, $update);}

    /**
     * Filter edate
     * @param string $edate
     * @param string $operation
     */
    public function filterEdate($edate, $operation = false) {$this->filterField('edate', $edate, $operation);}

    /**
     * Get key
     * @return string
     */
    public function getKey() { return $this->getField('key');}

    /**
     * Set key
     * @param string $key
     */
    public function setKey($key, $update = false) {$this->setField('key', $key, $update);}

    /**
     * Filter key
     * @param string $key
     * @param string $operation
     */
    public function filterKey($key, $operation = false) {$this->filterField('key', $key, $operation);}

    /**
     * Get data
     * @return string
     */
    public function getData() { return $this->getField('data');}

    /**
     * Set data
     * @param string $data
     */
    public function setData($data, $update = false) {$this->setField('data', $data, $update);}

    /**
     * Filter data
     * @param string $data
     * @param string $operation
     */
    public function filterData($data, $operation = false) {$this->filterField('data', $data, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopcache');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopCache
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopCache
     */
    public static function Get($key) {return self::GetObject("XShopCache", $key);}

}

SQLObject::SetFieldArray('shopcache', array('id', 'cdate', 'edate', 'key', 'data'));
SQLObject::SetPrimaryKey('shopcache', 'id');
