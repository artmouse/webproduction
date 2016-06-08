<?php
/**
 * Class XShopCurrency is ORM to table shopcurrency
 * @author SQLObject
 * @package SQLObject
 */
class XShopCurrency extends SQLObject {

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
     * Get symbol
     * @return string
     */
    public function getSymbol() { return $this->getField('symbol');}

    /**
     * Set symbol
     * @param string $symbol
     */
    public function setSymbol($symbol, $update = false) {$this->setField('symbol', $symbol, $update);}

    /**
     * Filter symbol
     * @param string $symbol
     * @param string $operation
     */
    public function filterSymbol($symbol, $operation = false) {$this->filterField('symbol', $symbol, $operation);}

    /**
     * Get rate
     * @return float
     */
    public function getRate() { return $this->getField('rate');}

    /**
     * Set rate
     * @param float $rate
     */
    public function setRate($rate, $update = false) {$this->setField('rate', $rate, $update);}

    /**
     * Filter rate
     * @param float $rate
     * @param string $operation
     */
    public function filterRate($rate, $operation = false) {$this->filterField('rate', $rate, $operation);}

    /**
     * Get default
     * @return int
     */
    public function getDefault() { return $this->getField('default');}

    /**
     * Set default
     * @param int $default
     */
    public function setDefault($default, $update = false) {$this->setField('default', $default, $update);}

    /**
     * Filter default
     * @param int $default
     * @param string $operation
     */
    public function filterDefault($default, $operation = false) {$this->filterField('default', $default, $operation);}

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
     * Get sort
     * @return int
     */
    public function getSort() { return $this->getField('sort');}

    /**
     * Set sort
     * @param int $sort
     */
    public function setSort($sort, $update = false) {$this->setField('sort', $sort, $update);}

    /**
     * Filter sort
     * @param int $sort
     * @param string $operation
     */
    public function filterSort($sort, $operation = false) {$this->filterField('sort', $sort, $operation);}

    /**
     * Get logicclass
     * @return string
     */
    public function getLogicclass() { return $this->getField('logicclass');}

    /**
     * Set logicclass
     * @param string $logicclass
     */
    public function setLogicclass($logicclass, $update = false) {$this->setField('logicclass', $logicclass, $update);}

    /**
     * Filter logicclass
     * @param string $logicclass
     * @param string $operation
     */
    public function filterLogicclass($logicclass, $operation = false) {$this->filterField('logicclass', $logicclass, $operation);}

    /**
     * Get percent
     * @return float
     */
    public function getPercent() { return $this->getField('percent');}

    /**
     * Set percent
     * @param float $percent
     */
    public function setPercent($percent, $update = false) {$this->setField('percent', $percent, $update);}

    /**
     * Filter percent
     * @param float $percent
     * @param string $operation
     */
    public function filterPercent($percent, $operation = false) {$this->filterField('percent', $percent, $operation);}

    /**
     * Get linkkey
     * @return string
     */
    public function getLinkkey() { return $this->getField('linkkey');}

    /**
     * Set linkkey
     * @param string $linkkey
     */
    public function setLinkkey($linkkey, $update = false) {$this->setField('linkkey', $linkkey, $update);}

    /**
     * Filter linkkey
     * @param string $linkkey
     * @param string $operation
     */
    public function filterLinkkey($linkkey, $operation = false) {$this->filterField('linkkey', $linkkey, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopcurrency');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopCurrency
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopCurrency
     */
    public static function Get($key) {return self::GetObject("XShopCurrency", $key);}

}

SQLObject::SetFieldArray('shopcurrency', array('id', 'name', 'symbol', 'rate', 'default', 'hidden', 'sort', 'logicclass', 'percent', 'linkkey'));
SQLObject::SetPrimaryKey('shopcurrency', 'id');
