<?php
/**
 * Class XShopPriceSupplierUserSelection is ORM to table shoppricesupplieruserselection
 * @author SQLObject
 * @package SQLObject
 */
class XShopPriceSupplierUserSelection extends SQLObject {

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoppricesupplieruserselection');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopPriceSupplierUserSelection
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopPriceSupplierUserSelection
     */
    public static function Get($key) {return self::GetObject("XShopPriceSupplierUserSelection", $key);}

}

SQLObject::SetFieldArray('shoppricesupplieruserselection', array('id', 'name', 'productid'));
SQLObject::SetPrimaryKey('shoppricesupplieruserselection', 'id');
