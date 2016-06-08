<?php
/**
 * Class XShopProductFilterValue is ORM to table shopproductfiltervalue
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductFilterValue extends SQLObject {

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
     * Get filterid
     * @return int
     */
    public function getFilterid() { return $this->getField('filterid');}

    /**
     * Set filterid
     * @param int $filterid
     */
    public function setFilterid($filterid, $update = false) {$this->setField('filterid', $filterid, $update);}

    /**
     * Filter filterid
     * @param int $filterid
     * @param string $operation
     */
    public function filterFilterid($filterid, $operation = false) {$this->filterField('filterid', $filterid, $operation);}

    /**
     * Get filtervalue
     * @return string
     */
    public function getFiltervalue() { return $this->getField('filtervalue');}

    /**
     * Set filtervalue
     * @param string $filtervalue
     */
    public function setFiltervalue($filtervalue, $update = false) {$this->setField('filtervalue', $filtervalue, $update);}

    /**
     * Filter filtervalue
     * @param string $filtervalue
     * @param string $operation
     */
    public function filterFiltervalue($filtervalue, $operation = false) {$this->filterField('filtervalue', $filtervalue, $operation);}

    /**
     * Get filteractual
     * @return int
     */
    public function getFilteractual() { return $this->getField('filteractual');}

    /**
     * Set filteractual
     * @param int $filteractual
     */
    public function setFilteractual($filteractual, $update = false) {$this->setField('filteractual', $filteractual, $update);}

    /**
     * Filter filteractual
     * @param int $filteractual
     * @param string $operation
     */
    public function filterFilteractual($filteractual, $operation = false) {$this->filterField('filteractual', $filteractual, $operation);}

    /**
     * Get filteruse
     * @return int
     */
    public function getFilteruse() { return $this->getField('filteruse');}

    /**
     * Set filteruse
     * @param int $filteruse
     */
    public function setFilteruse($filteruse, $update = false) {$this->setField('filteruse', $filteruse, $update);}

    /**
     * Filter filteruse
     * @param int $filteruse
     * @param string $operation
     */
    public function filterFilteruse($filteruse, $operation = false) {$this->filterField('filteruse', $filteruse, $operation);}

    /**
     * Get filteroption
     * @return int
     */
    public function getFilteroption() { return $this->getField('filteroption');}

    /**
     * Set filteroption
     * @param int $filteroption
     */
    public function setFilteroption($filteroption, $update = false) {$this->setField('filteroption', $filteroption, $update);}

    /**
     * Filter filteroption
     * @param int $filteroption
     * @param string $operation
     */
    public function filterFilteroption($filteroption, $operation = false) {$this->filterField('filteroption', $filteroption, $operation);}

    /**
     * Get filtermarkup
     * @return float
     */
    public function getFiltermarkup() { return $this->getField('filtermarkup');}

    /**
     * Set filtermarkup
     * @param float $filtermarkup
     */
    public function setFiltermarkup($filtermarkup, $update = false) {$this->setField('filtermarkup', $filtermarkup, $update);}

    /**
     * Filter filtermarkup
     * @param float $filtermarkup
     * @param string $operation
     */
    public function filterFiltermarkup($filtermarkup, $operation = false) {$this->filterField('filtermarkup', $filtermarkup, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductfiltervalue');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductFilterValue
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductFilterValue
     */
    public static function Get($key) {return self::GetObject("XShopProductFilterValue", $key);}

}

SQLObject::SetFieldArray('shopproductfiltervalue', array('id', 'productid', 'filterid', 'filtervalue', 'filteractual', 'filteruse', 'filteroption', 'filtermarkup'));
SQLObject::SetPrimaryKey('shopproductfiltervalue', 'id');
