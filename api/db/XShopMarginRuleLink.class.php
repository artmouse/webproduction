<?php
/**
 * Class XShopMarginRuleLink is ORM to table shopmarginrulelink
 * @author SQLObject
 * @package SQLObject
 */
class XShopMarginRuleLink extends SQLObject {

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
     * Get marginruleid
     * @return int
     */
    public function getMarginruleid() { return $this->getField('marginruleid');}

    /**
     * Set marginruleid
     * @param int $marginruleid
     */
    public function setMarginruleid($marginruleid, $update = false) {$this->setField('marginruleid', $marginruleid, $update);}

    /**
     * Filter marginruleid
     * @param int $marginruleid
     * @param string $operation
     */
    public function filterMarginruleid($marginruleid, $operation = false) {$this->filterField('marginruleid', $marginruleid, $operation);}

    /**
     * Get objecttype
     * @return string
     */
    public function getObjecttype() { return $this->getField('objecttype');}

    /**
     * Set objecttype
     * @param string $objecttype
     */
    public function setObjecttype($objecttype, $update = false) {$this->setField('objecttype', $objecttype, $update);}

    /**
     * Filter objecttype
     * @param string $objecttype
     * @param string $operation
     */
    public function filterObjecttype($objecttype, $operation = false) {$this->filterField('objecttype', $objecttype, $operation);}

    /**
     * Get objectid
     * @return int
     */
    public function getObjectid() { return $this->getField('objectid');}

    /**
     * Set objectid
     * @param int $objectid
     */
    public function setObjectid($objectid, $update = false) {$this->setField('objectid', $objectid, $update);}

    /**
     * Filter objectid
     * @param int $objectid
     * @param string $operation
     */
    public function filterObjectid($objectid, $operation = false) {$this->filterField('objectid', $objectid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopmarginrulelink');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopMarginRuleLink
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopMarginRuleLink
     */
    public static function Get($key) {return self::GetObject("XShopMarginRuleLink", $key);}

}

SQLObject::SetFieldArray('shopmarginrulelink', array('id', 'marginruleid', 'objecttype', 'objectid'));
SQLObject::SetPrimaryKey('shopmarginrulelink', 'id');
