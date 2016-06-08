<?php
/**
 * Class XShopStorageName is ORM to table shopstoragename
 * @author SQLObject
 * @package SQLObject
 */
class XShopStorageName extends SQLObject {

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
     * Get forsale
     * @return int
     */
    public function getForsale() { return $this->getField('forsale');}

    /**
     * Set forsale
     * @param int $forsale
     */
    public function setForsale($forsale, $update = false) {$this->setField('forsale', $forsale, $update);}

    /**
     * Filter forsale
     * @param int $forsale
     * @param string $operation
     */
    public function filterForsale($forsale, $operation = false) {$this->filterField('forsale', $forsale, $operation);}

    /**
     * Get isvendor
     * @return int
     */
    public function getIsvendor() { return $this->getField('isvendor');}

    /**
     * Set isvendor
     * @param int $isvendor
     */
    public function setIsvendor($isvendor, $update = false) {$this->setField('isvendor', $isvendor, $update);}

    /**
     * Filter isvendor
     * @param int $isvendor
     * @param string $operation
     */
    public function filterIsvendor($isvendor, $operation = false) {$this->filterField('isvendor', $isvendor, $operation);}

    /**
     * Get issold
     * @return int
     */
    public function getIssold() { return $this->getField('issold');}

    /**
     * Set issold
     * @param int $issold
     */
    public function setIssold($issold, $update = false) {$this->setField('issold', $issold, $update);}

    /**
     * Filter issold
     * @param int $issold
     * @param string $operation
     */
    public function filterIssold($issold, $operation = false) {$this->filterField('issold', $issold, $operation);}

    /**
     * Get isemployee
     * @return int
     */
    public function getIsemployee() { return $this->getField('isemployee');}

    /**
     * Set isemployee
     * @param int $isemployee
     */
    public function setIsemployee($isemployee, $update = false) {$this->setField('isemployee', $isemployee, $update);}

    /**
     * Filter isemployee
     * @param int $isemployee
     * @param string $operation
     */
    public function filterIsemployee($isemployee, $operation = false) {$this->filterField('isemployee', $isemployee, $operation);}

    /**
     * Get isoutcoming
     * @return int
     */
    public function getIsoutcoming() { return $this->getField('isoutcoming');}

    /**
     * Set isoutcoming
     * @param int $isoutcoming
     */
    public function setIsoutcoming($isoutcoming, $update = false) {$this->setField('isoutcoming', $isoutcoming, $update);}

    /**
     * Filter isoutcoming
     * @param int $isoutcoming
     * @param string $operation
     */
    public function filterIsoutcoming($isoutcoming, $operation = false) {$this->filterField('isoutcoming', $isoutcoming, $operation);}

    /**
     * Get isproduction
     * @return int
     */
    public function getIsproduction() { return $this->getField('isproduction');}

    /**
     * Set isproduction
     * @param int $isproduction
     */
    public function setIsproduction($isproduction, $update = false) {$this->setField('isproduction', $isproduction, $update);}

    /**
     * Filter isproduction
     * @param int $isproduction
     * @param string $operation
     */
    public function filterIsproduction($isproduction, $operation = false) {$this->filterField('isproduction', $isproduction, $operation);}

    /**
     * Get hidden
     * @return int
     */
    public function getHidden() { return $this->getField('hidden');}

    /**
     * Set hidden
     * @param int $hidden
     */
    public function setHidden($hidden, $update = false) {$this->setField('hidden', $hidden, $update);}

    /**
     * Filter hidden
     * @param int $hidden
     * @param string $operation
     */
    public function filterHidden($hidden, $operation = false) {$this->filterField('hidden', $hidden, $operation);}

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
     * Get linkkey
     * @return string
     */
    public function getLinkkey() { return $this->getField('linkkey');}

    /**
     * Set linkkey
     * @param string $linkkey
     */
    public function setLinkkey($linkkey, $update = false) {$this->setField('linkkey', $linkkey, $update);}

    /**
     * Filter linkkey
     * @param string $linkkey
     * @param string $operation
     */
    public function filterLinkkey($linkkey, $operation = false) {$this->filterField('linkkey', $linkkey, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopstoragename');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStorageName
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStorageName
     */
    public static function Get($key) {return self::GetObject("XShopStorageName", $key);}

}

SQLObject::SetFieldArray('shopstoragename', array('id', 'name', 'userid', 'forsale', 'isvendor', 'issold', 'isemployee', 'isoutcoming', 'isproduction', 'hidden', 'default', 'linkkey'));
SQLObject::SetPrimaryKey('shopstoragename', 'id');
