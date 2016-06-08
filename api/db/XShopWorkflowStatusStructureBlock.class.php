<?php
/**
 * Class XShopWorkflowStatusStructureBlock is ORM to table shopworkflowstatusstructureblock
 * @author SQLObject
 * @package SQLObject
 */
class XShopWorkflowStatusStructureBlock extends SQLObject {

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
     * Get structureid
     * @return int
     */
    public function getStructureid() { return $this->getField('structureid');}

    /**
     * Set structureid
     * @param int $structureid
     */
    public function setStructureid($structureid, $update = false) {$this->setField('structureid', $structureid, $update);}

    /**
     * Filter structureid
     * @param int $structureid
     * @param string $operation
     */
    public function filterStructureid($structureid, $operation = false) {$this->filterField('structureid', $structureid, $operation);}

    /**
     * Get blockid
     * @return int
     */
    public function getBlockid() { return $this->getField('blockid');}

    /**
     * Set blockid
     * @param int $blockid
     */
    public function setBlockid($blockid, $update = false) {$this->setField('blockid', $blockid, $update);}

    /**
     * Filter blockid
     * @param int $blockid
     * @param string $operation
     */
    public function filterBlockid($blockid, $operation = false) {$this->filterField('blockid', $blockid, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopworkflowstatusstructureblock');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopWorkflowStatusStructureBlock
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopWorkflowStatusStructureBlock
     */
    public static function Get($key) {return self::GetObject("XShopWorkflowStatusStructureBlock", $key);}

}

SQLObject::SetFieldArray('shopworkflowstatusstructureblock', array('id', 'statusid', 'structureid', 'blockid', 'sort'));
SQLObject::SetPrimaryKey('shopworkflowstatusstructureblock', 'id');
