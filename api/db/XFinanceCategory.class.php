<?php
/**
 * Class XFinanceCategory is ORM to table financecategory
 * @author SQLObject
 * @package SQLObject
 */
class XFinanceCategory extends SQLObject {

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
     * Get active
     * @return int
     */
    public function getActive() { return $this->getField('active');}

    /**
     * Set active
     * @param int $active
     */
    public function setActive($active, $update = false) {$this->setField('active', $active, $update);}

    /**
     * Filter active
     * @param int $active
     * @param string $operation
     */
    public function filterActive($active, $operation = false) {$this->filterField('active', $active, $operation);}

    /**
     * Get fundpercent
     * @return int
     */
    public function getFundpercent() { return $this->getField('fundpercent');}

    /**
     * Set fundpercent
     * @param int $fundpercent
     */
    public function setFundpercent($fundpercent, $update = false) {$this->setField('fundpercent', $fundpercent, $update);}

    /**
     * Filter fundpercent
     * @param int $fundpercent
     * @param string $operation
     */
    public function filterFundpercent($fundpercent, $operation = false) {$this->filterField('fundpercent', $fundpercent, $operation);}

    /**
     * Get fundsum
     * @return float
     */
    public function getFundsum() { return $this->getField('fundsum');}

    /**
     * Set fundsum
     * @param float $fundsum
     */
    public function setFundsum($fundsum, $update = false) {$this->setField('fundsum', $fundsum, $update);}

    /**
     * Filter fundsum
     * @param float $fundsum
     * @param string $operation
     */
    public function filterFundsum($fundsum, $operation = false) {$this->filterField('fundsum', $fundsum, $operation);}

    /**
     * Get fundtotal
     * @return float
     */
    public function getFundtotal() { return $this->getField('fundtotal');}

    /**
     * Set fundtotal
     * @param float $fundtotal
     */
    public function setFundtotal($fundtotal, $update = false) {$this->setField('fundtotal', $fundtotal, $update);}

    /**
     * Filter fundtotal
     * @param float $fundtotal
     * @param string $operation
     */
    public function filterFundtotal($fundtotal, $operation = false) {$this->filterField('fundtotal', $fundtotal, $operation);}

    /**
     * Get lastpaymentid
     * @return int
     */
    public function getLastpaymentid() { return $this->getField('lastpaymentid');}

    /**
     * Set lastpaymentid
     * @param int $lastpaymentid
     */
    public function setLastpaymentid($lastpaymentid, $update = false) {$this->setField('lastpaymentid', $lastpaymentid, $update);}

    /**
     * Filter lastpaymentid
     * @param int $lastpaymentid
     * @param string $operation
     */
    public function filterLastpaymentid($lastpaymentid, $operation = false) {$this->filterField('lastpaymentid', $lastpaymentid, $operation);}

    /**
     * Get isfund
     * @return int
     */
    public function getIsfund() { return $this->getField('isfund');}

    /**
     * Set isfund
     * @param int $isfund
     */
    public function setIsfund($isfund, $update = false) {$this->setField('isfund', $isfund, $update);}

    /**
     * Filter isfund
     * @param int $isfund
     * @param string $operation
     */
    public function filterIsfund($isfund, $operation = false) {$this->filterField('isfund', $isfund, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('financecategory');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XFinanceCategory
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XFinanceCategory
     */
    public static function Get($key) {return self::GetObject("XFinanceCategory", $key);}

}

SQLObject::SetFieldArray('financecategory', array('id', 'name', 'active', 'fundpercent', 'fundsum', 'fundtotal', 'lastpaymentid', 'isfund'));
SQLObject::SetPrimaryKey('financecategory', 'id');
