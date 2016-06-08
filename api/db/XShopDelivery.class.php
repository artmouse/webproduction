<?php
/**
 * Class XShopDelivery is ORM to table shopdelivery
 * @author SQLObject
 * @package SQLObject
 */
class XShopDelivery extends SQLObject {

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
     * Get image
     * @return string
     */
    public function getImage() { return $this->getField('image');}

    /**
     * Set image
     * @param string $image
     */
    public function setImage($image, $update = false) {$this->setField('image', $image, $update);}

    /**
     * Filter image
     * @param string $image
     * @param string $operation
     */
    public function filterImage($image, $operation = false) {$this->filterField('image', $image, $operation);}

    /**
     * Get price
     * @return float
     */
    public function getPrice() { return $this->getField('price');}

    /**
     * Set price
     * @param float $price
     */
    public function setPrice($price, $update = false) {$this->setField('price', $price, $update);}

    /**
     * Filter price
     * @param float $price
     * @param string $operation
     */
    public function filterPrice($price, $operation = false) {$this->filterField('price', $price, $operation);}

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
     * Get needcity
     * @return int
     */
    public function getNeedcity() { return $this->getField('needcity');}

    /**
     * Set needcity
     * @param int $needcity
     */
    public function setNeedcity($needcity, $update = false) {$this->setField('needcity', $needcity, $update);}

    /**
     * Filter needcity
     * @param int $needcity
     * @param string $operation
     */
    public function filterNeedcity($needcity, $operation = false) {$this->filterField('needcity', $needcity, $operation);}

    /**
     * Get needaddress
     * @return int
     */
    public function getNeedaddress() { return $this->getField('needaddress');}

    /**
     * Set needaddress
     * @param int $needaddress
     */
    public function setNeedaddress($needaddress, $update = false) {$this->setField('needaddress', $needaddress, $update);}

    /**
     * Filter needaddress
     * @param int $needaddress
     * @param string $operation
     */
    public function filterNeedaddress($needaddress, $operation = false) {$this->filterField('needaddress', $needaddress, $operation);}

    /**
     * Get needcountry
     * @return int
     */
    public function getNeedcountry() { return $this->getField('needcountry');}

    /**
     * Set needcountry
     * @param int $needcountry
     */
    public function setNeedcountry($needcountry, $update = false) {$this->setField('needcountry', $needcountry, $update);}

    /**
     * Filter needcountry
     * @param int $needcountry
     * @param string $operation
     */
    public function filterNeedcountry($needcountry, $operation = false) {$this->filterField('needcountry', $needcountry, $operation);}

    /**
     * Get paydelivery
     * @return int
     */
    public function getPaydelivery() { return $this->getField('paydelivery');}

    /**
     * Set paydelivery
     * @param int $paydelivery
     */
    public function setPaydelivery($paydelivery, $update = false) {$this->setField('paydelivery', $paydelivery, $update);}

    /**
     * Filter paydelivery
     * @param int $paydelivery
     * @param string $operation
     */
    public function filterPaydelivery($paydelivery, $operation = false) {$this->filterField('paydelivery', $paydelivery, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopdelivery');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopDelivery
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopDelivery
     */
    public static function Get($key) {return self::GetObject("XShopDelivery", $key);}

}

SQLObject::SetFieldArray('shopdelivery', array('id', 'name', 'description', 'image', 'price', 'currencyid', 'sort', 'default', 'needcity', 'needaddress', 'needcountry', 'paydelivery', 'logicclass'));
SQLObject::SetPrimaryKey('shopdelivery', 'id');
