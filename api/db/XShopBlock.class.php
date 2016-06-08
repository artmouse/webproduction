<?php
/**
 * Class XShopBlock is ORM to table shopblock
 * @author SQLObject
 * @package SQLObject
 */
class XShopBlock extends SQLObject {

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
     * Get active
     * @return int
     */
    public function getActive() { return $this->getField('active');}

    /**
     * Set active
     * @param int $active
     */
    public function setActive($active, $update = false) {$this->setField('active', $active, $update);}

    /**
     * Filter active
     * @param int $active
     * @param string $operation
     */
    public function filterActive($active, $operation = false) {$this->filterField('active', $active, $operation);}

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
     * Get system
     * @return int
     */
    public function getSystem() { return $this->getField('system');}

    /**
     * Set system
     * @param int $system
     */
    public function setSystem($system, $update = false) {$this->setField('system', $system, $update);}

    /**
     * Filter system
     * @param int $system
     * @param string $operation
     */
    public function filterSystem($system, $operation = false) {$this->filterField('system', $system, $operation);}

    /**
     * Get position
     * @return string
     */
    public function getPosition() { return $this->getField('position');}

    /**
     * Set position
     * @param string $position
     */
    public function setPosition($position, $update = false) {$this->setField('position', $position, $update);}

    /**
     * Filter position
     * @param string $position
     * @param string $operation
     */
    public function filterPosition($position, $operation = false) {$this->filterField('position', $position, $operation);}

    /**
     * Get positionsort
     * @return int
     */
    public function getPositionsort() { return $this->getField('positionsort');}

    /**
     * Set positionsort
     * @param int $positionsort
     */
    public function setPositionsort($positionsort, $update = false) {$this->setField('positionsort', $positionsort, $update);}

    /**
     * Filter positionsort
     * @param int $positionsort
     * @param string $operation
     */
    public function filterPositionsort($positionsort, $operation = false) {$this->filterField('positionsort', $positionsort, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopblock');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopBlock
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopBlock
     */
    public static function Get($key) {return self::GetObject("XShopBlock", $key);}

}

SQLObject::SetFieldArray('shopblock', array('id', 'name', 'active', 'contentid', 'system', 'position', 'positionsort', 'linkkey'));
SQLObject::SetPrimaryKey('shopblock', 'id');
