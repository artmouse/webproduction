<?php
/**
 * Class XShopDiscount is ORM to table shopdiscount
 * @author SQLObject
 * @package SQLObject
 */
class XShopDiscount extends SQLObject {

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
     * Get value
     * @return float
     */
    public function getValue() { return $this->getField('value');}

    /**
     * Set value
     * @param float $value
     */
    public function setValue($value, $update = false) {$this->setField('value', $value, $update);}

    /**
     * Filter value
     * @param float $value
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
     * Get minstartsum
     * @return int
     */
    public function getMinstartsum() { return $this->getField('minstartsum');}

    /**
     * Set minstartsum
     * @param int $minstartsum
     */
    public function setMinstartsum($minstartsum, $update = false) {$this->setField('minstartsum', $minstartsum, $update);}

    /**
     * Filter minstartsum
     * @param int $minstartsum
     * @param string $operation
     */
    public function filterMinstartsum($minstartsum, $operation = false) {$this->filterField('minstartsum', $minstartsum, $operation);}

    /**
     * Get currencyid
     * @return int
     */
    public function getCurrencyid() { return $this->getField('currencyid');}

    /**
     * Set currencyid
     * @param int $currencyid
     */
    public function setCurrencyid($currencyid, $update = false) {$this->setField('currencyid', $currencyid, $update);}

    /**
     * Filter currencyid
     * @param int $currencyid
     * @param string $operation
     */
    public function filterCurrencyid($currencyid, $operation = false) {$this->filterField('currencyid', $currencyid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopdiscount');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopDiscount
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopDiscount
     */
    public static function Get($key) {return self::GetObject("XShopDiscount", $key);}

}

SQLObject::SetFieldArray('shopdiscount', array('id', 'name', 'value', 'type', 'minstartsum', 'currencyid'));
SQLObject::SetPrimaryKey('shopdiscount', 'id');
