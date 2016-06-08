<?php
/**
 * Class XShopExportPlaceCategory is ORM to table shopplacecategory
 * @author SQLObject
 * @package SQLObject
 */
class XShopExportPlaceCategory extends SQLObject {

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
     * Get placeid
     * @return int
     */
    public function getPlaceid() { return $this->getField('placeid');}

    /**
     * Set placeid
     * @param int $placeid
     */
    public function setPlaceid($placeid, $update = false) {$this->setField('placeid', $placeid, $update);}

    /**
     * Filter placeid
     * @param int $placeid
     * @param string $operation
     */
    public function filterPlaceid($placeid, $operation = false) {$this->filterField('placeid', $placeid, $operation);}

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
     * Get productid
     * @return int
     */
    public function getProductid() { return $this->getField('productid');}

    /**
     * Set productid
     * @param int $productid
     */
    public function setProductid($productid, $update = false) {$this->setField('productid', $productid, $update);}

    /**
     * Filter productid
     * @param int $productid
     * @param string $operation
     */
    public function filterProductid($productid, $operation = false) {$this->filterField('productid', $productid, $operation);}

    /**
     * Get disable
     * @return int
     */
    public function getDisable() { return $this->getField('disable');}

    /**
     * Set disable
     * @param int $disable
     */
    public function setDisable($disable, $update = false) {$this->setField('disable', $disable, $update);}

    /**
     * Filter disable
     * @param int $disable
     * @param string $operation
     */
    public function filterDisable($disable, $operation = false) {$this->filterField('disable', $disable, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopplacecategory');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopExportPlaceCategory
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopExportPlaceCategory
     */
    public static function Get($key) {return self::GetObject("XShopExportPlaceCategory", $key);}

}

SQLObject::SetFieldArray('shopplacecategory', array('id', 'placeid', 'categoryid', 'productid', 'disable'));
SQLObject::SetPrimaryKey('shopplacecategory', 'id');
