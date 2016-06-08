<?php
/**
 * Class XShopEventEmailUID is ORM to table shopeventemailuid
 * @author SQLObject
 * @package SQLObject
 */
class XShopEventEmailUID extends SQLObject {

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
     * Get imap
     * @return string
     */
    public function getImap() { return $this->getField('imap');}

    /**
     * Set imap
     * @param string $imap
     */
    public function setImap($imap, $update = false) {$this->setField('imap', $imap, $update);}

    /**
     * Filter imap
     * @param string $imap
     * @param string $operation
     */
    public function filterImap($imap, $operation = false) {$this->filterField('imap', $imap, $operation);}

    /**
     * Get uid
     * @return string
     */
    public function getUid() { return $this->getField('uid');}

    /**
     * Set uid
     * @param string $uid
     */
    public function setUid($uid, $update = false) {$this->setField('uid', $uid, $update);}

    /**
     * Filter uid
     * @param string $uid
     * @param string $operation
     */
    public function filterUid($uid, $operation = false) {$this->filterField('uid', $uid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopeventemailuid');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopEventEmailUID
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopEventEmailUID
     */
    public static function Get($key) {return self::GetObject("XShopEventEmailUID", $key);}

}

SQLObject::SetFieldArray('shopeventemailuid', array('id', 'imap', 'uid'));
SQLObject::SetPrimaryKey('shopeventemailuid', 'id');
