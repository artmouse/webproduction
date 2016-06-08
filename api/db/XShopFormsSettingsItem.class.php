<?php
/**
 * Class XShopFormsSettingsItem is ORM to table shopformssettingsitem
 * @author SQLObject
 * @package SQLObject
 */
class XShopFormsSettingsItem extends SQLObject {

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
     * Get formid
     * @return int
     */
    public function getFormid() { return $this->getField('formid');}

    /**
     * Set formid
     * @param int $formid
     */
    public function setFormid($formid, $update = false) {$this->setField('formid', $formid, $update);}

    /**
     * Filter formid
     * @param int $formid
     * @param string $operation
     */
    public function filterFormid($formid, $operation = false) {$this->filterField('formid', $formid, $operation);}

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
     * Get type
     * @return string
     */
    public function getType() { return $this->getField('type');}

    /**
     * Set type
     * @param string $type
     */
    public function setType($type, $update = false) {$this->setField('type', $type, $update);}

    /**
     * Filter type
     * @param string $type
     * @param string $operation
     */
    public function filterType($type, $operation = false) {$this->filterField('type', $type, $operation);}

    /**
     * Get required
     * @return int
     */
    public function getRequired() { return $this->getField('required');}

    /**
     * Set required
     * @param int $required
     */
    public function setRequired($required, $update = false) {$this->setField('required', $required, $update);}

    /**
     * Filter required
     * @param int $required
     * @param string $operation
     */
    public function filterRequired($required, $operation = false) {$this->filterField('required', $required, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopformssettingsitem');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopFormsSettingsItem
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopFormsSettingsItem
     */
    public static function Get($key) {return self::GetObject("XShopFormsSettingsItem", $key);}

}

SQLObject::SetFieldArray('shopformssettingsitem', array('id', 'formid', 'name', 'description', 'type', 'required', 'sort'));
SQLObject::SetPrimaryKey('shopformssettingsitem', 'id');
