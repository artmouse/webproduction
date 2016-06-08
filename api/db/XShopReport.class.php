<?php
/**
 * Class XShopReport is ORM to table shopreport
 * @author SQLObject
 * @package SQLObject
 */
class XShopReport extends SQLObject {

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
     * Get row
     * @return string
     */
    public function getRow() { return $this->getField('row');}

    /**
     * Set row
     * @param string $row
     */
    public function setRow($row, $update = false) {$this->setField('row', $row, $update);}

    /**
     * Filter row
     * @param string $row
     * @param string $operation
     */
    public function filterRow($row, $operation = false) {$this->filterField('row', $row, $operation);}

    /**
     * Get columns
     * @return string
     */
    public function getColumns() { return $this->getField('columns');}

    /**
     * Set columns
     * @param string $columns
     */
    public function setColumns($columns, $update = false) {$this->setField('columns', $columns, $update);}

    /**
     * Filter columns
     * @param string $columns
     * @param string $operation
     */
    public function filterColumns($columns, $operation = false) {$this->filterField('columns', $columns, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopreport');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopReport
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopReport
     */
    public static function Get($key) {return self::GetObject("XShopReport", $key);}

}

SQLObject::SetFieldArray('shopreport', array('id', 'name', 'row', 'columns'));
SQLObject::SetPrimaryKey('shopreport', 'id');
