<?php
/**
 * Class XShopSettings is ORM to table shopsettings
 * @author SQLObject
 * @package SQLObject
 */
class XShopSettings extends SQLObject {

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
     * Get value
     * @return string
     */
    public function getValue() { return $this->getField('value');}

    /**
     * Set value
     * @param string $value
     */
    public function setValue($value, $update = false) {$this->setField('value', $value, $update);}

    /**
     * Filter value
     * @param string $value
     * @param string $operation
     */
    public function filterValue($value, $operation = false) {$this->filterField('value', $value, $operation);}

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
     * Get tabname
     * @return string
     */
    public function getTabname() { return $this->getField('tabname');}

    /**
     * Set tabname
     * @param string $tabname
     */
    public function setTabname($tabname, $update = false) {$this->setField('tabname', $tabname, $update);}

    /**
     * Filter tabname
     * @param string $tabname
     * @param string $operation
     */
    public function filterTabname($tabname, $operation = false) {$this->filterField('tabname', $tabname, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopsettings');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopSettings
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopSettings
     */
    public static function Get($key) {return self::GetObject("XShopSettings", $key);}

}

SQLObject::SetFieldArray('shopsettings', array('id', 'key', 'name', 'value', 'type', 'tabname', 'description'));
SQLObject::SetPrimaryKey('shopsettings', 'id');
