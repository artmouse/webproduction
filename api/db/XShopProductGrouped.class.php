<?php
/**
 * Class XShopProductGrouped is ORM to table shopproductgrouped
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductGrouped extends SQLObject {

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
     * Get first
     * @return int
     */
    public function getFirst() { return $this->getField('first');}

    /**
     * Set first
     * @param int $first
     */
    public function setFirst($first, $update = false) {$this->setField('first', $first, $update);}

    /**
     * Filter first
     * @param int $first
     * @param string $operation
     */
    public function filterFirst($first, $operation = false) {$this->filterField('first', $first, $operation);}

    /**
     * Get image
     * @return string
     */
    public function getImage() { return $this->getField('image');}

    /**
     * Set image
     * @param string $image
     */
    public function setImage($image, $update = false) {$this->setField('image', $image, $update);}

    /**
     * Filter image
     * @param string $image
     * @param string $operation
     */
    public function filterImage($image, $operation = false) {$this->filterField('image', $image, $operation);}

    /**
     * Get groupedfield
     * @return string
     */
    public function getGroupedfield() { return $this->getField('groupedfield');}

    /**
     * Set groupedfield
     * @param string $groupedfield
     */
    public function setGroupedfield($groupedfield, $update = false) {$this->setField('groupedfield', $groupedfield, $update);}

    /**
     * Filter groupedfield
     * @param string $groupedfield
     * @param string $operation
     */
    public function filterGroupedfield($groupedfield, $operation = false) {$this->filterField('groupedfield', $groupedfield, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductgrouped');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductGrouped
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductGrouped
     */
    public static function Get($key) {return self::GetObject("XShopProductGrouped", $key);}

}

SQLObject::SetFieldArray('shopproductgrouped', array('id', 'categoryid', 'productid', 'first', 'image', 'groupedfield'));
SQLObject::SetPrimaryKey('shopproductgrouped', 'id');
