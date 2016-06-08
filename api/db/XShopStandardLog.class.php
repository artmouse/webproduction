<?php
/**
 * Class XShopStandardLog is ORM to table shopstandardlog
 * @author SQLObject
 * @package SQLObject
 */
class XShopStandardLog extends SQLObject {

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
     * Get standardid
     * @return int
     */
    public function getStandardid() { return $this->getField('standardid');}

    /**
     * Set standardid
     * @param int $standardid
     */
    public function setStandardid($standardid, $update = false) {$this->setField('standardid', $standardid, $update);}

    /**
     * Filter standardid
     * @param int $standardid
     * @param string $operation
     */
    public function filterStandardid($standardid, $operation = false) {$this->filterField('standardid', $standardid, $operation);}

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
     * Get content
     * @return string
     */
    public function getContent() { return $this->getField('content');}

    /**
     * Set content
     * @param string $content
     */
    public function setContent($content, $update = false) {$this->setField('content', $content, $update);}

    /**
     * Filter content
     * @param string $content
     * @param string $operation
     */
    public function filterContent($content, $operation = false) {$this->filterField('content', $content, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopstandardlog');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStandardLog
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStandardLog
     */
    public static function Get($key) {return self::GetObject("XShopStandardLog", $key);}

}

SQLObject::SetFieldArray('shopstandardlog', array('id', 'standardid', 'cdate', 'userid', 'name', 'content'));
SQLObject::SetPrimaryKey('shopstandardlog', 'id');
