<?php
/**
 * Class XShopUserGroup is ORM to table shopusergroup
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserGroup extends SQLObject {

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
     * Get description
     * @return string
     */
    public function getDescription() { return $this->getField('description');}

    /**
     * Set description
     * @param string $description
     */
    public function setDescription($description, $update = false) {$this->setField('description', $description, $update);}

    /**
     * Filter description
     * @param string $description
     * @param string $operation
     */
    public function filterDescription($description, $operation = false) {$this->filterField('description', $description, $operation);}

    /**
     * Get group
     * @return string
     */
    public function getGroup() { return $this->getField('group');}

    /**
     * Set group
     * @param string $group
     */
    public function setGroup($group, $update = false) {$this->setField('group', $group, $update);}

    /**
     * Filter group
     * @param string $group
     * @param string $operation
     */
    public function filterGroup($group, $operation = false) {$this->filterField('group', $group, $operation);}

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
     * Get logicclass
     * @return string
     */
    public function getLogicclass() { return $this->getField('logicclass');}

    /**
     * Set logicclass
     * @param string $logicclass
     */
    public function setLogicclass($logicclass, $update = false) {$this->setField('logicclass', $logicclass, $update);}

    /**
     * Filter logicclass
     * @param string $logicclass
     * @param string $operation
     */
    public function filterLogicclass($logicclass, $operation = false) {$this->filterField('logicclass', $logicclass, $operation);}

    /**
     * Get colour
     * @return string
     */
    public function getColour() { return $this->getField('colour');}

    /**
     * Set colour
     * @param string $colour
     */
    public function setColour($colour, $update = false) {$this->setField('colour', $colour, $update);}

    /**
     * Filter colour
     * @param string $colour
     * @param string $operation
     */
    public function filterColour($colour, $operation = false) {$this->filterField('colour', $colour, $operation);}

    /**
     * Get pricelevel
     * @return int
     */
    public function getPricelevel() { return $this->getField('pricelevel');}

    /**
     * Set pricelevel
     * @param int $pricelevel
     */
    public function setPricelevel($pricelevel, $update = false) {$this->setField('pricelevel', $pricelevel, $update);}

    /**
     * Filter pricelevel
     * @param int $pricelevel
     * @param string $operation
     */
    public function filterPricelevel($pricelevel, $operation = false) {$this->filterField('pricelevel', $pricelevel, $operation);}

    /**
     * Get cnt
     * @return int
     */
    public function getCnt() { return $this->getField('cnt');}

    /**
     * Set cnt
     * @param int $cnt
     */
    public function setCnt($cnt, $update = false) {$this->setField('cnt', $cnt, $update);}

    /**
     * Filter cnt
     * @param int $cnt
     * @param string $operation
     */
    public function filterCnt($cnt, $operation = false) {$this->filterField('cnt', $cnt, $operation);}

    /**
     * Get cntlast
     * @return int
     */
    public function getCntlast() { return $this->getField('cntlast');}

    /**
     * Set cntlast
     * @param int $cntlast
     */
    public function setCntlast($cntlast, $update = false) {$this->setField('cntlast', $cntlast, $update);}

    /**
     * Filter cntlast
     * @param int $cntlast
     * @param string $operation
     */
    public function filterCntlast($cntlast, $operation = false) {$this->filterField('cntlast', $cntlast, $operation);}

    /**
     * Get parentid
     * @return int
     */
    public function getParentid() { return $this->getField('parentid');}

    /**
     * Set parentid
     * @param int $parentid
     */
    public function setParentid($parentid, $update = false) {$this->setField('parentid', $parentid, $update);}

    /**
     * Filter parentid
     * @param int $parentid
     * @param string $operation
     */
    public function filterParentid($parentid, $operation = false) {$this->filterField('parentid', $parentid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopusergroup');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserGroup
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserGroup
     */
    public static function Get($key) {return self::GetObject("XShopUserGroup", $key);}

}

SQLObject::SetFieldArray('shopusergroup', array('id', 'name', 'description', 'group', 'sort', 'logicclass', 'colour', 'pricelevel', 'cnt', 'cntlast', 'parentid'));
SQLObject::SetPrimaryKey('shopusergroup', 'id');
