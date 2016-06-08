<?php
/**
 * Class XProduct2ActionSet is ORM to table product2actionset
 * @author SQLObject
 * @package SQLObject
 */
class XProduct2ActionSet extends SQLObject {

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
     * Get actionid
     * @return int
     */
    public function getActionid() { return $this->getField('actionid');}

    /**
     * Set actionid
     * @param int $actionid
     */
    public function setActionid($actionid, $update = false) {$this->setField('actionid', $actionid, $update);}

    /**
     * Filter actionid
     * @param int $actionid
     * @param string $operation
     */
    public function filterActionid($actionid, $operation = false) {$this->filterField('actionid', $actionid, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('product2actionset');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XProduct2ActionSet
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XProduct2ActionSet
     */
    public static function Get($key) {return self::GetObject("XProduct2ActionSet", $key);}

}

SQLObject::SetFieldArray('product2actionset', array('id', 'actionid', 'productid', 'discount'));
SQLObject::SetPrimaryKey('product2actionset', 'id');
