<?php
/**
 * Class XShopDocumentTemplate is ORM to table shopdocumenttemplate
 * @author SQLObject
 * @package SQLObject
 */
class XShopDocumentTemplate extends SQLObject {

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
     * Get groupname
     * @return string
     */
    public function getGroupname() { return $this->getField('groupname');}

    /**
     * Set groupname
     * @param string $groupname
     */
    public function setGroupname($groupname, $update = false) {$this->setField('groupname', $groupname, $update);}

    /**
     * Filter groupname
     * @param string $groupname
     * @param string $operation
     */
    public function filterGroupname($groupname, $operation = false) {$this->filterField('groupname', $groupname, $operation);}

    /**
     * Get direction
     * @return string
     */
    public function getDirection() { return $this->getField('direction');}

    /**
     * Set direction
     * @param string $direction
     */
    public function setDirection($direction, $update = false) {$this->setField('direction', $direction, $update);}

    /**
     * Filter direction
     * @param string $direction
     * @param string $operation
     */
    public function filterDirection($direction, $operation = false) {$this->filterField('direction', $direction, $operation);}

    /**
     * Get content
     * @return string
     */
    public function getContent() { return $this->getField('content');}

    /**
     * Set content
     * @param string $content
     */
    public function setContent($content, $update = false) {$this->setField('content', $content, $update);}

    /**
     * Filter content
     * @param string $content
     * @param string $operation
     */
    public function filterContent($content, $operation = false) {$this->filterField('content', $content, $operation);}

    /**
     * Get hidden
     * @return int
     */
    public function getHidden() { return $this->getField('hidden');}

    /**
     * Set hidden
     * @param int $hidden
     */
    public function setHidden($hidden, $update = false) {$this->setField('hidden', $hidden, $update);}

    /**
     * Filter hidden
     * @param int $hidden
     * @param string $operation
     */
    public function filterHidden($hidden, $operation = false) {$this->filterField('hidden', $hidden, $operation);}

    /**
     * Get required
     * @return int
     */
    public function getRequired() { return $this->getField('required');}

    /**
     * Set required
     * @param int $required
     */
    public function setRequired($required, $update = false) {$this->setField('required', $required, $update);}

    /**
     * Filter required
     * @param int $required
     * @param string $operation
     */
    public function filterRequired($required, $operation = false) {$this->filterField('required', $required, $operation);}

    /**
     * Get period
     * @return int
     */
    public function getPeriod() { return $this->getField('period');}

    /**
     * Set period
     * @param int $period
     */
    public function setPeriod($period, $update = false) {$this->setField('period', $period, $update);}

    /**
     * Filter period
     * @param int $period
     * @param string $operation
     */
    public function filterPeriod($period, $operation = false) {$this->filterField('period', $period, $operation);}

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
     * Get numberprocessor
     * @return string
     */
    public function getNumberprocessor() { return $this->getField('numberprocessor');}

    /**
     * Set numberprocessor
     * @param string $numberprocessor
     */
    public function setNumberprocessor($numberprocessor, $update = false) {$this->setField('numberprocessor', $numberprocessor, $update);}

    /**
     * Filter numberprocessor
     * @param string $numberprocessor
     * @param string $operation
     */
    public function filterNumberprocessor($numberprocessor, $operation = false) {$this->filterField('numberprocessor', $numberprocessor, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopdocumenttemplate');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopDocumentTemplate
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopDocumentTemplate
     */
    public static function Get($key) {return self::GetObject("XShopDocumentTemplate", $key);}

}

SQLObject::SetFieldArray('shopdocumenttemplate', array('id', 'key', 'name', 'type', 'groupname', 'direction', 'content', 'hidden', 'required', 'period', 'sort', 'numberprocessor'));
SQLObject::SetPrimaryKey('shopdocumenttemplate', 'id');
