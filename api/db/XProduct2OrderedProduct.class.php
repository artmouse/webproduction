<?php
/**
 * Class XProduct2OrderedProduct is ORM to table product2orderedproduct
 * @author SQLObject
 * @package SQLObject
 */
class XProduct2OrderedProduct extends SQLObject {

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
     * Get orderedproductid
     * @return int
     */
    public function getOrderedproductid() { return $this->getField('orderedproductid');}

    /**
     * Set orderedproductid
     * @param int $orderedproductid
     */
    public function setOrderedproductid($orderedproductid, $update = false) {$this->setField('orderedproductid', $orderedproductid, $update);}

    /**
     * Filter orderedproductid
     * @param int $orderedproductid
     * @param string $operation
     */
    public function filterOrderedproductid($orderedproductid, $operation = false) {$this->filterField('orderedproductid', $orderedproductid, $operation);}

    /**
     * Get orderedproductcode1c
     * @return string
     */
    public function getOrderedproductcode1c() { return $this->getField('orderedproductcode1c');}

    /**
     * Set orderedproductcode1c
     * @param string $orderedproductcode1c
     */
    public function setOrderedproductcode1c($orderedproductcode1c, $update = false) {$this->setField('orderedproductcode1c', $orderedproductcode1c, $update);}

    /**
     * Filter orderedproductcode1c
     * @param string $orderedproductcode1c
     * @param string $operation
     */
    public function filterOrderedproductcode1c($orderedproductcode1c, $operation = false) {$this->filterField('orderedproductcode1c', $orderedproductcode1c, $operation);}

    /**
     * Get productcount
     * @return int
     */
    public function getProductcount() { return $this->getField('productcount');}

    /**
     * Set productcount
     * @param int $productcount
     */
    public function setProductcount($productcount, $update = false) {$this->setField('productcount', $productcount, $update);}

    /**
     * Filter productcount
     * @param int $productcount
     * @param string $operation
     */
    public function filterProductcount($productcount, $operation = false) {$this->filterField('productcount', $productcount, $operation);}

    /**
     * Get deleted
     * @return int
     */
    public function getDeleted() { return $this->getField('deleted');}

    /**
     * Set deleted
     * @param int $deleted
     */
    public function setDeleted($deleted, $update = false) {$this->setField('deleted', $deleted, $update);}

    /**
     * Filter deleted
     * @param int $deleted
     * @param string $operation
     */
    public function filterDeleted($deleted, $operation = false) {$this->filterField('deleted', $deleted, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('product2orderedproduct');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XProduct2OrderedProduct
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XProduct2OrderedProduct
     */
    public static function Get($key) {return self::GetObject("XProduct2OrderedProduct", $key);}

}

SQLObject::SetFieldArray('product2orderedproduct', array('id', 'productid', 'orderedproductid', 'orderedproductcode1c', 'productcount', 'deleted'));
SQLObject::SetPrimaryKey('product2orderedproduct', 'id');
