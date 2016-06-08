<?php
/**
 * Class XShopOrderStatusChange is ORM to table shoporderstatuschange
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderStatusChange extends SQLObject {

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
     * Get categoryid
     * @return int
     */
    public function getCategoryid() { return $this->getField('categoryid');}

    /**
     * Set categoryid
     * @param int $categoryid
     */
    public function setCategoryid($categoryid, $update = false) {$this->setField('categoryid', $categoryid, $update);}

    /**
     * Filter categoryid
     * @param int $categoryid
     * @param string $operation
     */
    public function filterCategoryid($categoryid, $operation = false) {$this->filterField('categoryid', $categoryid, $operation);}

    /**
     * Get elementfromid
     * @return int
     */
    public function getElementfromid() { return $this->getField('elementfromid');}

    /**
     * Set elementfromid
     * @param int $elementfromid
     */
    public function setElementfromid($elementfromid, $update = false) {$this->setField('elementfromid', $elementfromid, $update);}

    /**
     * Filter elementfromid
     * @param int $elementfromid
     * @param string $operation
     */
    public function filterElementfromid($elementfromid, $operation = false) {$this->filterField('elementfromid', $elementfromid, $operation);}

    /**
     * Get elementtoid
     * @return int
     */
    public function getElementtoid() { return $this->getField('elementtoid');}

    /**
     * Set elementtoid
     * @param int $elementtoid
     */
    public function setElementtoid($elementtoid, $update = false) {$this->setField('elementtoid', $elementtoid, $update);}

    /**
     * Filter elementtoid
     * @param int $elementtoid
     * @param string $operation
     */
    public function filterElementtoid($elementtoid, $operation = false) {$this->filterField('elementtoid', $elementtoid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoporderstatuschange');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderStatusChange
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderStatusChange
     */
    public static function Get($key) {return self::GetObject("XShopOrderStatusChange", $key);}

}

SQLObject::SetFieldArray('shoporderstatuschange', array('id', 'categoryid', 'elementfromid', 'elementtoid'));
SQLObject::SetPrimaryKey('shoporderstatuschange', 'id');
