<?php
/**
 * Class XShopActionSet is ORM to table shopactionset
 * @author SQLObject
 * @package SQLObject
 */
class XShopActionSet extends SQLObject {

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
     * Get discount
     * @return int
     */
    public function getDiscount() { return $this->getField('discount');}

    /**
     * Set discount
     * @param int $discount
     */
    public function setDiscount($discount, $update = false) {$this->setField('discount', $discount, $update);}

    /**
     * Filter discount
     * @param int $discount
     * @param string $operation
     */
    public function filterDiscount($discount, $operation = false) {$this->filterField('discount', $discount, $operation);}

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
     * Get hidden
     * @return int
     */
    public function getHidden() { return $this->getField('hidden');}

    /**
     * Set hidden
     * @param int $hidden
     */
    public function setHidden($hidden, $update = false) {$this->setField('hidden', $hidden, $update);}

    /**
     * Filter hidden
     * @param int $hidden
     * @param string $operation
     */
    public function filterHidden($hidden, $operation = false) {$this->filterField('hidden', $hidden, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopactionset');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopActionSet
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopActionSet
     */
    public static function Get($key) {return self::GetObject("XShopActionSet", $key);}

}

SQLObject::SetFieldArray('shopactionset', array('id', 'productid', 'discount', 'name', 'hidden'));
SQLObject::SetPrimaryKey('shopactionset', 'id');
