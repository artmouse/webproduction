<?php
/**
 * Class XShopWorkflowStatusBlock is ORM to table shopworkflowstatusblock
 * @author SQLObject
 * @package SQLObject
 */
class XShopWorkflowStatusBlock extends SQLObject {

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
     * Get name
     * @return string
     */
    public function getName() { return $this->getField('name');}

    /**
     * Set name
     * @param string $name
     */
    public function setName($name, $update = false) {$this->setField('name', $name, $update);}

    /**
     * Filter name
     * @param string $name
     * @param string $operation
     */
    public function filterName($name, $operation = false) {$this->filterField('name', $name, $operation);}

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
     * Get priority
     * @return int
     */
    public function getPriority() { return $this->getField('priority');}

    /**
     * Set priority
     * @param int $priority
     */
    public function setPriority($priority, $update = false) {$this->setField('priority', $priority, $update);}

    /**
     * Filter priority
     * @param int $priority
     * @param string $operation
     */
    public function filterPriority($priority, $operation = false) {$this->filterField('priority', $priority, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopworkflowstatusblock');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopWorkflowStatusBlock
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopWorkflowStatusBlock
     */
    public static function Get($key) {return self::GetObject("XShopWorkflowStatusBlock", $key);}

}

SQLObject::SetFieldArray('shopworkflowstatusblock', array('id', 'name', 'contentid', 'priority'));
SQLObject::SetPrimaryKey('shopworkflowstatusblock', 'id');
