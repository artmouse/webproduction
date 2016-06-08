<?php
/**
 * Class XShopUserVoIPActive is ORM to table shopuservoipactive2
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserVoIPActive extends SQLObject {

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
     * Get number
     * @return string
     */
    public function getNumber() { return $this->getField('number');}

    /**
     * Set number
     * @param string $number
     */
    public function setNumber($number, $update = false) {$this->setField('number', $number, $update);}

    /**
     * Filter number
     * @param string $number
     * @param string $operation
     */
    public function filterNumber($number, $operation = false) {$this->filterField('number', $number, $operation);}

    /**
     * Get contactid
     * @return int
     */
    public function getContactid() { return $this->getField('contactid');}

    /**
     * Set contactid
     * @param int $contactid
     */
    public function setContactid($contactid, $update = false) {$this->setField('contactid', $contactid, $update);}

    /**
     * Filter contactid
     * @param int $contactid
     * @param string $operation
     */
    public function filterContactid($contactid, $operation = false) {$this->filterField('contactid', $contactid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopuservoipactive2');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserVoIPActive
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserVoIPActive
     */
    public static function Get($key) {return self::GetObject("XShopUserVoIPActive", $key);}

}

SQLObject::SetFieldArray('shopuservoipactive2', array('id', 'number', 'contactid'));
SQLObject::SetPrimaryKey('shopuservoipactive2', 'id');
