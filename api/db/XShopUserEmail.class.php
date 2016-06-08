<?php
/**
 * Class XShopUserEmail is ORM to table shopuseremail
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserEmail extends SQLObject {

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
     * Get email
     * @return string
     */
    public function getEmail() { return $this->getField('email');}

    /**
     * Set email
     * @param string $email
     */
    public function setEmail($email, $update = false) {$this->setField('email', $email, $update);}

    /**
     * Filter email
     * @param string $email
     * @param string $operation
     */
    public function filterEmail($email, $operation = false) {$this->filterField('email', $email, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopuseremail');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserEmail
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserEmail
     */
    public static function Get($key) {return self::GetObject("XShopUserEmail", $key);}

}

SQLObject::SetFieldArray('shopuseremail', array('id', 'userid', 'email'));
SQLObject::SetPrimaryKey('shopuseremail', 'id');
