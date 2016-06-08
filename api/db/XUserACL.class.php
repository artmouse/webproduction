<?php
/**
 * Class XUserACL is ORM to table useracl
 * @author SQLObject
 * @package SQLObject
 */
class XUserACL extends SQLObject {

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
     * Get acl
     * @return string
     */
    public function getAcl() { return $this->getField('acl');}

    /**
     * Set acl
     * @param string $acl
     */
    public function setAcl($acl, $update = false) {$this->setField('acl', $acl, $update);}

    /**
     * Filter acl
     * @param string $acl
     * @param string $operation
     */
    public function filterAcl($acl, $operation = false) {$this->filterField('acl', $acl, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('useracl');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XUserACL
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XUserACL
     */
    public static function Get($key) {return self::GetObject("XUserACL", $key);}

}

SQLObject::SetFieldArray('useracl', array('id', 'userid', 'acl'));
SQLObject::SetPrimaryKey('useracl', 'id');
