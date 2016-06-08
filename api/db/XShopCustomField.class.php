<?php
/**
 * Class XShopCustomField is ORM to table shopcustomfield
 * @author SQLObject
 * @package SQLObject
 */
class XShopCustomField extends SQLObject {

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
     * Get objecttype
     * @return string
     */
    public function getObjecttype() { return $this->getField('objecttype');}

    /**
     * Set objecttype
     * @param string $objecttype
     */
    public function setObjecttype($objecttype, $update = false) {$this->setField('objecttype', $objecttype, $update);}

    /**
     * Filter objecttype
     * @param string $objecttype
     * @param string $operation
     */
    public function filterObjecttype($objecttype, $operation = false) {$this->filterField('objecttype', $objecttype, $operation);}

    /**
     * Get objectid
     * @return int
     */
    public function getObjectid() { return $this->getField('objectid');}

    /**
     * Set objectid
     * @param int $objectid
     */
    public function setObjectid($objectid, $update = false) {$this->setField('objectid', $objectid, $update);}

    /**
     * Filter objectid
     * @param int $objectid
     * @param string $operation
     */
    public function filterObjectid($objectid, $operation = false) {$this->filterField('objectid', $objectid, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopcustomfield');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopCustomField
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopCustomField
     */
    public static function Get($key) {return self::GetObject("XShopCustomField", $key);}

}

SQLObject::SetFieldArray('shopcustomfield', array('id', 'objecttype', 'objectid', 'key', 'value'));
SQLObject::SetPrimaryKey('shopcustomfield', 'id');
