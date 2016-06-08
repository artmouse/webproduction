<?php
/**
 * Class XShopUserLegalData is ORM to table shopuserlegaldata
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserLegalData extends SQLObject {

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
     * Get legalid
     * @return int
     */
    public function getLegalid() { return $this->getField('legalid');}

    /**
     * Set legalid
     * @param int $legalid
     */
    public function setLegalid($legalid, $update = false) {$this->setField('legalid', $legalid, $update);}

    /**
     * Filter legalid
     * @param int $legalid
     * @param string $operation
     */
    public function filterLegalid($legalid, $operation = false) {$this->filterField('legalid', $legalid, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopuserlegaldata');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserLegalData
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserLegalData
     */
    public static function Get($key) {return self::GetObject("XShopUserLegalData", $key);}

}

SQLObject::SetFieldArray('shopuserlegaldata', array('id', 'legalid', 'key', 'name', 'value'));
SQLObject::SetPrimaryKey('shopuserlegaldata', 'id');
