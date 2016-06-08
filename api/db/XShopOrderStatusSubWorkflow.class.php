<?php
/**
 * Class XShopOrderStatusSubWorkflow is ORM to table shoporderstatussubworkflow
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderStatusSubWorkflow extends SQLObject {

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
     * Get subworkflowid
     * @return int
     */
    public function getSubworkflowid() { return $this->getField('subworkflowid');}

    /**
     * Set subworkflowid
     * @param int $subworkflowid
     */
    public function setSubworkflowid($subworkflowid, $update = false) {$this->setField('subworkflowid', $subworkflowid, $update);}

    /**
     * Filter subworkflowid
     * @param int $subworkflowid
     * @param string $operation
     */
    public function filterSubworkflowid($subworkflowid, $operation = false) {$this->filterField('subworkflowid', $subworkflowid, $operation);}

    /**
     * Get subworkflowname
     * @return string
     */
    public function getSubworkflowname() { return $this->getField('subworkflowname');}

    /**
     * Set subworkflowname
     * @param string $subworkflowname
     */
    public function setSubworkflowname($subworkflowname, $update = false) {$this->setField('subworkflowname', $subworkflowname, $update);}

    /**
     * Filter subworkflowname
     * @param string $subworkflowname
     * @param string $operation
     */
    public function filterSubworkflowname($subworkflowname, $operation = false) {$this->filterField('subworkflowname', $subworkflowname, $operation);}

    /**
     * Get subworkflowdate
     * @return int
     */
    public function getSubworkflowdate() { return $this->getField('subworkflowdate');}

    /**
     * Set subworkflowdate
     * @param int $subworkflowdate
     */
    public function setSubworkflowdate($subworkflowdate, $update = false) {$this->setField('subworkflowdate', $subworkflowdate, $update);}

    /**
     * Filter subworkflowdate
     * @param int $subworkflowdate
     * @param string $operation
     */
    public function filterSubworkflowdate($subworkflowdate, $operation = false) {$this->filterField('subworkflowdate', $subworkflowdate, $operation);}

    /**
     * Get subworkflowdescription
     * @return string
     */
    public function getSubworkflowdescription() { return $this->getField('subworkflowdescription');}

    /**
     * Set subworkflowdescription
     * @param string $subworkflowdescription
     */
    public function setSubworkflowdescription($subworkflowdescription, $update = false) {$this->setField('subworkflowdescription', $subworkflowdescription, $update);}

    /**
     * Filter subworkflowdescription
     * @param string $subworkflowdescription
     * @param string $operation
     */
    public function filterSubworkflowdescription($subworkflowdescription, $operation = false) {$this->filterField('subworkflowdescription', $subworkflowdescription, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoporderstatussubworkflow');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderStatusSubWorkflow
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderStatusSubWorkflow
     */
    public static function Get($key) {return self::GetObject("XShopOrderStatusSubWorkflow", $key);}

}

SQLObject::SetFieldArray('shoporderstatussubworkflow', array('id', 'statusid', 'sort', 'subworkflowid', 'subworkflowname', 'subworkflowdate', 'subworkflowdescription'));
SQLObject::SetPrimaryKey('shoporderstatussubworkflow', 'id');
