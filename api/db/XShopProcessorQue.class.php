<?php
/**
 * Class XShopProcessorQue is ORM to table shopprocessorque
 * @author SQLObject
 * @package SQLObject
 */
class XShopProcessorQue extends SQLObject {

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
        $this->setTablename('shopprocessorque');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProcessorQue
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProcessorQue
     */
    public static function Get($key) {return self::GetObject("XShopProcessorQue", $key);}

}

SQLObject::SetFieldArray('shopprocessorque', array('id', 'logicclass'));
SQLObject::SetPrimaryKey('shopprocessorque', 'id');
