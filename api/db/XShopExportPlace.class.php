<?php
/**
 * Class XShopExportPlace is ORM to table shopplace
 * @author SQLObject
 * @package SQLObject
 */
class XShopExportPlace extends SQLObject {

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
        $this->setTablename('shopplace');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopExportPlace
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopExportPlace
     */
    public static function Get($key) {return self::GetObject("XShopExportPlace", $key);}

}

SQLObject::SetFieldArray('shopplace', array('id', 'name', 'logicclass'));
SQLObject::SetPrimaryKey('shopplace', 'id');
