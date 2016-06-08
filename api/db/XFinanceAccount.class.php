<?php
/**
 * Class XFinanceAccount is ORM to table financeaccount
 * @author SQLObject
 * @package SQLObject
 */
class XFinanceAccount extends SQLObject {

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
     * Get description
     * @return string
     */
    public function getDescription() { return $this->getField('description');}

    /**
     * Set description
     * @param string $description
     */
    public function setDescription($description, $update = false) {$this->setField('description', $description, $update);}

    /**
     * Filter description
     * @param string $description
     * @param string $operation
     */
    public function filterDescription($description, $operation = false) {$this->filterField('description', $description, $operation);}

    /**
     * Get currencyid
     * @return int
     */
    public function getCurrencyid() { return $this->getField('currencyid');}

    /**
     * Set currencyid
     * @param int $currencyid
     */
    public function setCurrencyid($currencyid, $update = false) {$this->setField('currencyid', $currencyid, $update);}

    /**
     * Filter currencyid
     * @param int $currencyid
     * @param string $operation
     */
    public function filterCurrencyid($currencyid, $operation = false) {$this->filterField('currencyid', $currencyid, $operation);}

    /**
     * Get contractorid
     * @return int
     */
    public function getContractorid() { return $this->getField('contractorid');}

    /**
     * Set contractorid
     * @param int $contractorid
     */
    public function setContractorid($contractorid, $update = false) {$this->setField('contractorid', $contractorid, $update);}

    /**
     * Filter contractorid
     * @param int $contractorid
     * @param string $operation
     */
    public function filterContractorid($contractorid, $operation = false) {$this->filterField('contractorid', $contractorid, $operation);}

    /**
     * Get balancestart
     * @return float
     */
    public function getBalancestart() { return $this->getField('balancestart');}

    /**
     * Set balancestart
     * @param float $balancestart
     */
    public function setBalancestart($balancestart, $update = false) {$this->setField('balancestart', $balancestart, $update);}

    /**
     * Filter balancestart
     * @param float $balancestart
     * @param string $operation
     */
    public function filterBalancestart($balancestart, $operation = false) {$this->filterField('balancestart', $balancestart, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('financeaccount');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XFinanceAccount
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XFinanceAccount
     */
    public static function Get($key) {return self::GetObject("XFinanceAccount", $key);}

}

SQLObject::SetFieldArray('financeaccount', array('id', 'name', 'description', 'currencyid', 'contractorid', 'balancestart', 'active'));
SQLObject::SetPrimaryKey('financeaccount', 'id');
