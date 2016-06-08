<?php
/**
 * Class XShopFile is ORM to table shopfile
 * @author SQLObject
 * @package SQLObject
 */
class XShopFile extends SQLObject {

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
     * Get file
     * @return string
     */
    public function getFile() { return $this->getField('file');}

    /**
     * Set file
     * @param string $file
     */
    public function setFile($file, $update = false) {$this->setField('file', $file, $update);}

    /**
     * Filter file
     * @param string $file
     * @param string $operation
     */
    public function filterFile($file, $operation = false) {$this->filterField('file', $file, $operation);}

    /**
     * Get contenttype
     * @return string
     */
    public function getContenttype() { return $this->getField('contenttype');}

    /**
     * Set contenttype
     * @param string $contenttype
     */
    public function setContenttype($contenttype, $update = false) {$this->setField('contenttype', $contenttype, $update);}

    /**
     * Filter contenttype
     * @param string $contenttype
     * @param string $operation
     */
    public function filterContenttype($contenttype, $operation = false) {$this->filterField('contenttype', $contenttype, $operation);}

    /**
     * Get cdate
     * @return string
     */
    public function getCdate() { return $this->getField('cdate');}

    /**
     * Set cdate
     * @param string $cdate
     */
    public function setCdate($cdate, $update = false) {$this->setField('cdate', $cdate, $update);}

    /**
     * Filter cdate
     * @param string $cdate
     * @param string $operation
     */
    public function filterCdate($cdate, $operation = false) {$this->filterField('cdate', $cdate, $operation);}

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
     * Get deleted
     * @return int
     */
    public function getDeleted() { return $this->getField('deleted');}

    /**
     * Set deleted
     * @param int $deleted
     */
    public function setDeleted($deleted, $update = false) {$this->setField('deleted', $deleted, $update);}

    /**
     * Filter deleted
     * @param int $deleted
     * @param string $operation
     */
    public function filterDeleted($deleted, $operation = false) {$this->filterField('deleted', $deleted, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopfile');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopFile
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopFile
     */
    public static function Get($key) {return self::GetObject("XShopFile", $key);}

}

SQLObject::SetFieldArray('shopfile', array('id', 'key', 'name', 'file', 'contenttype', 'cdate', 'userid', 'deleted'));
SQLObject::SetPrimaryKey('shopfile', 'id');
