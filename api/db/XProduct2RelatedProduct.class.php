<?php
/**
 * Class XProduct2RelatedProduct is ORM to table product2relatedproduct
 * @author SQLObject
 * @package SQLObject
 */
class XProduct2RelatedProduct extends SQLObject {

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
     * Get relatedproductid
     * @return int
     */
    public function getRelatedproductid() { return $this->getField('relatedproductid');}

    /**
     * Set relatedproductid
     * @param int $relatedproductid
     */
    public function setRelatedproductid($relatedproductid, $update = false) {$this->setField('relatedproductid', $relatedproductid, $update);}

    /**
     * Filter relatedproductid
     * @param int $relatedproductid
     * @param string $operation
     */
    public function filterRelatedproductid($relatedproductid, $operation = false) {$this->filterField('relatedproductid', $relatedproductid, $operation);}

    /**
     * Get sync
     * @return int
     */
    public function getSync() { return $this->getField('sync');}

    /**
     * Set sync
     * @param int $sync
     */
    public function setSync($sync, $update = false) {$this->setField('sync', $sync, $update);}

    /**
     * Filter sync
     * @param int $sync
     * @param string $operation
     */
    public function filterSync($sync, $operation = false) {$this->filterField('sync', $sync, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('product2relatedproduct');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XProduct2RelatedProduct
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XProduct2RelatedProduct
     */
    public static function Get($key) {return self::GetObject("XProduct2RelatedProduct", $key);}

}

SQLObject::SetFieldArray('product2relatedproduct', array('id', 'productid', 'relatedproductid', 'sync'));
SQLObject::SetPrimaryKey('product2relatedproduct', 'id');
