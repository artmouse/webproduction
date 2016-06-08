<?php
/**
 * Class XShopOrderProductStatus is ORM to table shoporderproductstatus
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderProductStatus extends SQLObject {

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
     * Get logicclassparams
     * @return string
     */
    public function getLogicclassparams() { return $this->getField('logicclassparams');}

    /**
     * Set logicclassparams
     * @param string $logicclassparams
     */
    public function setLogicclassparams($logicclassparams, $update = false) {$this->setField('logicclassparams', $logicclassparams, $update);}

    /**
     * Filter logicclassparams
     * @param string $logicclassparams
     * @param string $operation
     */
    public function filterLogicclassparams($logicclassparams, $operation = false) {$this->filterField('logicclassparams', $logicclassparams, $operation);}

    /**
     * Get logicclasscron
     * @return string
     */
    public function getLogicclasscron() { return $this->getField('logicclasscron');}

    /**
     * Set logicclasscron
     * @param string $logicclasscron
     */
    public function setLogicclasscron($logicclasscron, $update = false) {$this->setField('logicclasscron', $logicclasscron, $update);}

    /**
     * Filter logicclasscron
     * @param string $logicclasscron
     * @param string $operation
     */
    public function filterLogicclasscron($logicclasscron, $operation = false) {$this->filterField('logicclasscron', $logicclasscron, $operation);}

    /**
     * Get logicclasscronparams
     * @return string
     */
    public function getLogicclasscronparams() { return $this->getField('logicclasscronparams');}

    /**
     * Set logicclasscronparams
     * @param string $logicclasscronparams
     */
    public function setLogicclasscronparams($logicclasscronparams, $update = false) {$this->setField('logicclasscronparams', $logicclasscronparams, $update);}

    /**
     * Filter logicclasscronparams
     * @param string $logicclasscronparams
     * @param string $operation
     */
    public function filterLogicclasscronparams($logicclasscronparams, $operation = false) {$this->filterField('logicclasscronparams', $logicclasscronparams, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoporderproductstatus');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderProductStatus
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderProductStatus
     */
    public static function Get($key) {return self::GetObject("XShopOrderProductStatus", $key);}

}

SQLObject::SetFieldArray('shoporderproductstatus', array('id', 'name', 'sort', 'linkkey', 'logicclass', 'logicclassparams', 'logicclasscron', 'logicclasscronparams'));
SQLObject::SetPrimaryKey('shoporderproductstatus', 'id');
