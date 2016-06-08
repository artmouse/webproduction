<?php
/**
 * Class XShopProductPassport is ORM to table shopproductpassport
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductPassport extends SQLObject {

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
     * Get valid
     * @return int
     */
    public function getValid() { return $this->getField('valid');}

    /**
     * Set valid
     * @param int $valid
     */
    public function setValid($valid, $update = false) {$this->setField('valid', $valid, $update);}

    /**
     * Filter valid
     * @param int $valid
     * @param string $operation
     */
    public function filterValid($valid, $operation = false) {$this->filterField('valid', $valid, $operation);}

    /**
     * Get default
     * @return int
     */
    public function getDefault() { return $this->getField('default');}

    /**
     * Set default
     * @param int $default
     */
    public function setDefault($default, $update = false) {$this->setField('default', $default, $update);}

    /**
     * Filter default
     * @param int $default
     * @param string $operation
     */
    public function filterDefault($default, $operation = false) {$this->filterField('default', $default, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductpassport');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductPassport
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductPassport
     */
    public static function Get($key) {return self::GetObject("XShopProductPassport", $key);}

}

SQLObject::SetFieldArray('shopproductpassport', array('id', 'name', 'valid', 'default'));
SQLObject::SetPrimaryKey('shopproductpassport', 'id');
