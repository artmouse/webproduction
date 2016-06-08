<?php
/**
 * Class XShopStandard is ORM to table shopstandard
 * @author SQLObject
 * @package SQLObject
 */
class XShopStandard extends SQLObject {

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
     * Get parentid
     * @return int
     */
    public function getParentid() { return $this->getField('parentid');}

    /**
     * Set parentid
     * @param int $parentid
     */
    public function setParentid($parentid, $update = false) {$this->setField('parentid', $parentid, $update);}

    /**
     * Filter parentid
     * @param int $parentid
     * @param string $operation
     */
    public function filterParentid($parentid, $operation = false) {$this->filterField('parentid', $parentid, $operation);}

    /**
     * Get mdate
     * @return string
     */
    public function getMdate() { return $this->getField('mdate');}

    /**
     * Set mdate
     * @param string $mdate
     */
    public function setMdate($mdate, $update = false) {$this->setField('mdate', $mdate, $update);}

    /**
     * Filter mdate
     * @param string $mdate
     * @param string $operation
     */
    public function filterMdate($mdate, $operation = false) {$this->filterField('mdate', $mdate, $operation);}

    /**
     * Get cauthorid
     * @return int
     */
    public function getCauthorid() { return $this->getField('cauthorid');}

    /**
     * Set cauthorid
     * @param int $cauthorid
     */
    public function setCauthorid($cauthorid, $update = false) {$this->setField('cauthorid', $cauthorid, $update);}

    /**
     * Filter cauthorid
     * @param int $cauthorid
     * @param string $operation
     */
    public function filterCauthorid($cauthorid, $operation = false) {$this->filterField('cauthorid', $cauthorid, $operation);}

    /**
     * Get mauthorid
     * @return int
     */
    public function getMauthorid() { return $this->getField('mauthorid');}

    /**
     * Set mauthorid
     * @param int $mauthorid
     */
    public function setMauthorid($mauthorid, $update = false) {$this->setField('mauthorid', $mauthorid, $update);}

    /**
     * Filter mauthorid
     * @param int $mauthorid
     * @param string $operation
     */
    public function filterMauthorid($mauthorid, $operation = false) {$this->filterField('mauthorid', $mauthorid, $operation);}

    /**
     * Get active
     * @return string
     */
    public function getActive() { return $this->getField('active');}

    /**
     * Set active
     * @param string $active
     */
    public function setActive($active, $update = false) {$this->setField('active', $active, $update);}

    /**
     * Filter active
     * @param string $active
     * @param string $operation
     */
    public function filterActive($active, $operation = false) {$this->filterField('active', $active, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopstandard');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStandard
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStandard
     */
    public static function Get($key) {return self::GetObject("XShopStandard", $key);}

}

SQLObject::SetFieldArray('shopstandard', array('id', 'name', 'cdate', 'content', 'parentid', 'mdate', 'cauthorid', 'mauthorid', 'active'));
SQLObject::SetPrimaryKey('shopstandard', 'id');
