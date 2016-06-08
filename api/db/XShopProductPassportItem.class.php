<?php
/**
 * Class XShopProductPassportItem is ORM to table shopproductpassportitem
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductPassportItem extends SQLObject {

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
     * Get passportid
     * @return int
     */
    public function getPassportid() { return $this->getField('passportid');}

    /**
     * Set passportid
     * @param int $passportid
     */
    public function setPassportid($passportid, $update = false) {$this->setField('passportid', $passportid, $update);}

    /**
     * Filter passportid
     * @param int $passportid
     * @param string $operation
     */
    public function filterPassportid($passportid, $operation = false) {$this->filterField('passportid', $passportid, $operation);}

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
     * Get istarget
     * @return int
     */
    public function getIstarget() { return $this->getField('istarget');}

    /**
     * Set istarget
     * @param int $istarget
     */
    public function setIstarget($istarget, $update = false) {$this->setField('istarget', $istarget, $update);}

    /**
     * Filter istarget
     * @param int $istarget
     * @param string $operation
     */
    public function filterIstarget($istarget, $operation = false) {$this->filterField('istarget', $istarget, $operation);}

    /**
     * Get amount
     * @return float
     */
    public function getAmount() { return $this->getField('amount');}

    /**
     * Set amount
     * @param float $amount
     */
    public function setAmount($amount, $update = false) {$this->setField('amount', $amount, $update);}

    /**
     * Filter amount
     * @param float $amount
     * @param string $operation
     */
    public function filterAmount($amount, $operation = false) {$this->filterField('amount', $amount, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductpassportitem');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductPassportItem
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductPassportItem
     */
    public static function Get($key) {return self::GetObject("XShopProductPassportItem", $key);}

}

SQLObject::SetFieldArray('shopproductpassportitem', array('id', 'passportid', 'productid', 'istarget', 'amount'));
SQLObject::SetPrimaryKey('shopproductpassportitem', 'id');
