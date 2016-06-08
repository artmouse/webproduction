<?php
/**
 * Class XShopTransfer is ORM to table shoptransfer
 * @author SQLObject
 * @package SQLObject
 */
class XShopTransfer extends SQLObject {

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
     * Get telephone
     * @return string
     */
    public function getTelephone() { return $this->getField('telephone');}

    /**
     * Set telephone
     * @param string $telephone
     */
    public function setTelephone($telephone, $update = false) {$this->setField('telephone', $telephone, $update);}

    /**
     * Filter telephone
     * @param string $telephone
     * @param string $operation
     */
    public function filterTelephone($telephone, $operation = false) {$this->filterField('telephone', $telephone, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoptransfer');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopTransfer
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopTransfer
     */
    public static function Get($key) {return self::GetObject("XShopTransfer", $key);}

}

SQLObject::SetFieldArray('shoptransfer', array('id', 'name', 'telephone'));
SQLObject::SetPrimaryKey('shoptransfer', 'id');
