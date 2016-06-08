<?php
/**
 * Class XShopOrderStatusActionBlockStructure is ORM to table shoporderstatusactionblockstructure
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderStatusActionBlockStructure extends SQLObject {

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
     * Get contentid
     * @return string
     */
    public function getContentid() { return $this->getField('contentid');}

    /**
     * Set contentid
     * @param string $contentid
     */
    public function setContentid($contentid, $update = false) {$this->setField('contentid', $contentid, $update);}

    /**
     * Filter contentid
     * @param string $contentid
     * @param string $operation
     */
    public function filterContentid($contentid, $operation = false) {$this->filterField('contentid', $contentid, $operation);}

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
     * Get sort
     * @return int
     */
    public function getSort() { return $this->getField('sort');}

    /**
     * Set sort
     * @param int $sort
     */
    public function setSort($sort, $update = false) {$this->setField('sort', $sort, $update);}

    /**
     * Filter sort
     * @param int $sort
     * @param string $operation
     */
    public function filterSort($sort, $operation = false) {$this->filterField('sort', $sort, $operation);}

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
        $this->setTablename('shoporderstatusactionblockstructure');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderStatusActionBlockStructure
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderStatusActionBlockStructure
     */
    public static function Get($key) {return self::GetObject("XShopOrderStatusActionBlockStructure", $key);}

}

SQLObject::SetFieldArray('shoporderstatusactionblockstructure', array('id', 'contentid', 'statusid', 'sort', 'data'));
SQLObject::SetPrimaryKey('shoporderstatusactionblockstructure', 'id');
