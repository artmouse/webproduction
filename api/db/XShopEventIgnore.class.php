<?php
/**
 * Class XShopEventIgnore is ORM to table shopeventignore
 * @author SQLObject
 * @package SQLObject
 */
class XShopEventIgnore extends SQLObject {

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
     * Get address
     * @return string
     */
    public function getAddress() { return $this->getField('address');}

    /**
     * Set address
     * @param string $address
     */
    public function setAddress($address, $update = false) {$this->setField('address', $address, $update);}

    /**
     * Filter address
     * @param string $address
     * @param string $operation
     */
    public function filterAddress($address, $operation = false) {$this->filterField('address', $address, $operation);}

    /**
     * Get spam
     * @return int
     */
    public function getSpam() { return $this->getField('spam');}

    /**
     * Set spam
     * @param int $spam
     */
    public function setSpam($spam, $update = false) {$this->setField('spam', $spam, $update);}

    /**
     * Filter spam
     * @param int $spam
     * @param string $operation
     */
    public function filterSpam($spam, $operation = false) {$this->filterField('spam', $spam, $operation);}

    /**
     * Get notify
     * @return int
     */
    public function getNotify() { return $this->getField('notify');}

    /**
     * Set notify
     * @param int $notify
     */
    public function setNotify($notify, $update = false) {$this->setField('notify', $notify, $update);}

    /**
     * Filter notify
     * @param int $notify
     * @param string $operation
     */
    public function filterNotify($notify, $operation = false) {$this->filterField('notify', $notify, $operation);}

    /**
     * Get unknown
     * @return int
     */
    public function getUnknown() { return $this->getField('unknown');}

    /**
     * Set unknown
     * @param int $unknown
     */
    public function setUnknown($unknown, $update = false) {$this->setField('unknown', $unknown, $update);}

    /**
     * Filter unknown
     * @param int $unknown
     * @param string $operation
     */
    public function filterUnknown($unknown, $operation = false) {$this->filterField('unknown', $unknown, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopeventignore');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopEventIgnore
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopEventIgnore
     */
    public static function Get($key) {return self::GetObject("XShopEventIgnore", $key);}

}

SQLObject::SetFieldArray('shopeventignore', array('id', 'address', 'spam', 'notify', 'unknown'));
SQLObject::SetPrimaryKey('shopeventignore', 'id');
