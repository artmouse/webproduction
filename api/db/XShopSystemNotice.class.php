<?php
/**
 * Class XShopSystemNotice is ORM to table shopsystemnotice
 * @author SQLObject
 * @package SQLObject
 */
class XShopSystemNotice extends SQLObject {

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
     * Get data
     * @return string
     */
    public function getData() { return $this->getField('data');}

    /**
     * Set data
     * @param string $data
     */
    public function setData($data, $update = false) {$this->setField('data', $data, $update);}

    /**
     * Filter data
     * @param string $data
     * @param string $operation
     */
    public function filterData($data, $operation = false) {$this->filterField('data', $data, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopsystemnotice');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopSystemNotice
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopSystemNotice
     */
    public static function Get($key) {return self::GetObject("XShopSystemNotice", $key);}

}

SQLObject::SetFieldArray('shopsystemnotice', array('id', 'linkkey', 'data'));
SQLObject::SetPrimaryKey('shopsystemnotice', 'id');
