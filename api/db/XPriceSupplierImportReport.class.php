<?php
/**
 * Class XPriceSupplierImportReport is ORM to table pricesupplierimportreport
 * @author SQLObject
 * @package SQLObject
 */
class XPriceSupplierImportReport extends SQLObject {

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
     * Get dateupdate
     * @return string
     */
    public function getDateupdate() { return $this->getField('dateupdate');}

    /**
     * Set dateupdate
     * @param string $dateupdate
     */
    public function setDateupdate($dateupdate, $update = false) {$this->setField('dateupdate', $dateupdate, $update);}

    /**
     * Filter dateupdate
     * @param string $dateupdate
     * @param string $operation
     */
    public function filterDateupdate($dateupdate, $operation = false) {$this->filterField('dateupdate', $dateupdate, $operation);}

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
     * Get productname
     * @return string
     */
    public function getProductname() { return $this->getField('productname');}

    /**
     * Set productname
     * @param string $productname
     */
    public function setProductname($productname, $update = false) {$this->setField('productname', $productname, $update);}

    /**
     * Filter productname
     * @param string $productname
     * @param string $operation
     */
    public function filterProductname($productname, $operation = false) {$this->filterField('productname', $productname, $operation);}

    /**
     * Get error
     * @return int
     */
    public function getError() { return $this->getField('error');}

    /**
     * Set error
     * @param int $error
     */
    public function setError($error, $update = false) {$this->setField('error', $error, $update);}

    /**
     * Filter error
     * @param int $error
     * @param string $operation
     */
    public function filterError($error, $operation = false) {$this->filterField('error', $error, $operation);}

    /**
     * Get isnew
     * @return int
     */
    public function getIsnew() { return $this->getField('isnew');}

    /**
     * Set isnew
     * @param int $isnew
     */
    public function setIsnew($isnew, $update = false) {$this->setField('isnew', $isnew, $update);}

    /**
     * Filter isnew
     * @param int $isnew
     * @param string $operation
     */
    public function filterIsnew($isnew, $operation = false) {$this->filterField('isnew', $isnew, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('pricesupplierimportreport');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XPriceSupplierImportReport
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XPriceSupplierImportReport
     */
    public static function Get($key) {return self::GetObject("XPriceSupplierImportReport", $key);}

}

SQLObject::SetFieldArray('pricesupplierimportreport', array('id', 'dateupdate', 'productid', 'productname', 'error', 'isnew'));
SQLObject::SetPrimaryKey('pricesupplierimportreport', 'id');
