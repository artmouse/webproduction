<?php
/**
 * Class XShopDocumentFieldValue is ORM to table shopdocumentfieldvalue
 * @author SQLObject
 * @package SQLObject
 */
class XShopDocumentFieldValue extends SQLObject {

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
     * Get documentid
     * @return int
     */
    public function getDocumentid() { return $this->getField('documentid');}

    /**
     * Set documentid
     * @param int $documentid
     */
    public function setDocumentid($documentid, $update = false) {$this->setField('documentid', $documentid, $update);}

    /**
     * Filter documentid
     * @param int $documentid
     * @param string $operation
     */
    public function filterDocumentid($documentid, $operation = false) {$this->filterField('documentid', $documentid, $operation);}

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
     * Get value
     * @return string
     */
    public function getValue() { return $this->getField('value');}

    /**
     * Set value
     * @param string $value
     */
    public function setValue($value, $update = false) {$this->setField('value', $value, $update);}

    /**
     * Filter value
     * @param string $value
     * @param string $operation
     */
    public function filterValue($value, $operation = false) {$this->filterField('value', $value, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopdocumentfieldvalue');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopDocumentFieldValue
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopDocumentFieldValue
     */
    public static function Get($key) {return self::GetObject("XShopDocumentFieldValue", $key);}

}

SQLObject::SetFieldArray('shopdocumentfieldvalue', array('id', 'documentid', 'name', 'value'));
SQLObject::SetPrimaryKey('shopdocumentfieldvalue', 'id');
