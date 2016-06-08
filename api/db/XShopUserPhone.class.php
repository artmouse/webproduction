<?php
/**
 * Class XShopUserPhone is ORM to table shopuserphone
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserPhone extends SQLObject {

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
     * Get userid
     * @return int
     */
    public function getUserid() { return $this->getField('userid');}

    /**
     * Set userid
     * @param int $userid
     */
    public function setUserid($userid, $update = false) {$this->setField('userid', $userid, $update);}

    /**
     * Filter userid
     * @param int $userid
     * @param string $operation
     */
    public function filterUserid($userid, $operation = false) {$this->filterField('userid', $userid, $operation);}

    /**
     * Get phone
     * @return string
     */
    public function getPhone() { return $this->getField('phone');}

    /**
     * Set phone
     * @param string $phone
     */
    public function setPhone($phone, $update = false) {$this->setField('phone', $phone, $update);}

    /**
     * Filter phone
     * @param string $phone
     * @param string $operation
     */
    public function filterPhone($phone, $operation = false) {$this->filterField('phone', $phone, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopuserphone');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserPhone
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserPhone
     */
    public static function Get($key) {return self::GetObject("XShopUserPhone", $key);}

}

SQLObject::SetFieldArray('shopuserphone', array('id', 'userid', 'phone'));
SQLObject::SetPrimaryKey('shopuserphone', 'id');
