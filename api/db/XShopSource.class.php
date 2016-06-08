<?php
/**
 * Class XShopSource is ORM to table shopsource
 * @author SQLObject
 * @package SQLObject
 */
class XShopSource extends SQLObject {

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
     * Get address
     * @return string
     */
    public function getAddress() { return $this->getField('address');}

    /**
     * Set address
     * @param string $address
     */
    public function setAddress($address, $update = false) {$this->setField('address', $address, $update);}

    /**
     * Filter address
     * @param string $address
     * @param string $operation
     */
    public function filterAddress($address, $operation = false) {$this->filterField('address', $address, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopsource');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopSource
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopSource
     */
    public static function Get($key) {return self::GetObject("XShopSource", $key);}

}

SQLObject::SetFieldArray('shopsource', array('id', 'name', 'address'));
SQLObject::SetPrimaryKey('shopsource', 'id');
