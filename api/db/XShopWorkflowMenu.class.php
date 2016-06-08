<?php
/**
 * Class XShopWorkflowMenu is ORM to table shopworkflowmenu
 * @author SQLObject
 * @package SQLObject
 */
class XShopWorkflowMenu extends SQLObject {

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
     * Get linkkey
     * @return string
     */
    public function getLinkkey() { return $this->getField('linkkey');}

    /**
     * Set linkkey
     * @param string $linkkey
     */
    public function setLinkkey($linkkey, $update = false) {$this->setField('linkkey', $linkkey, $update);}

    /**
     * Filter linkkey
     * @param string $linkkey
     * @param string $operation
     */
    public function filterLinkkey($linkkey, $operation = false) {$this->filterField('linkkey', $linkkey, $operation);}

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
     * Get workflowid
     * @return int
     */
    public function getWorkflowid() { return $this->getField('workflowid');}

    /**
     * Set workflowid
     * @param int $workflowid
     */
    public function setWorkflowid($workflowid, $update = false) {$this->setField('workflowid', $workflowid, $update);}

    /**
     * Filter workflowid
     * @param int $workflowid
     * @param string $operation
     */
    public function filterWorkflowid($workflowid, $operation = false) {$this->filterField('workflowid', $workflowid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopworkflowmenu');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopWorkflowMenu
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopWorkflowMenu
     */
    public static function Get($key) {return self::GetObject("XShopWorkflowMenu", $key);}

}

SQLObject::SetFieldArray('shopworkflowmenu', array('id', 'name', 'linkkey', 'sort', 'workflowid'));
SQLObject::SetPrimaryKey('shopworkflowmenu', 'id');
