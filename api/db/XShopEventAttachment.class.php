<?php
/**
 * Class XShopEventAttachment is ORM to table shopeventattachment
 * @author SQLObject
 * @package SQLObject
 */
class XShopEventAttachment extends SQLObject {

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
     * Get eventid
     * @return int
     */
    public function getEventid() { return $this->getField('eventid');}

    /**
     * Set eventid
     * @param int $eventid
     */
    public function setEventid($eventid, $update = false) {$this->setField('eventid', $eventid, $update);}

    /**
     * Filter eventid
     * @param int $eventid
     * @param string $operation
     */
    public function filterEventid($eventid, $operation = false) {$this->filterField('eventid', $eventid, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopeventattachment');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopEventAttachment
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopEventAttachment
     */
    public static function Get($key) {return self::GetObject("XShopEventAttachment", $key);}

}

SQLObject::SetFieldArray('shopeventattachment', array('id', 'eventid', 'file', 'name', 'contenttype'));
SQLObject::SetPrimaryKey('shopeventattachment', 'id');
