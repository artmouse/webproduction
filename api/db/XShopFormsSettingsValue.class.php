<?php
/**
 * Class XShopFormsSettingsValue is ORM to table shopformssettingsvalue
 * @author SQLObject
 * @package SQLObject
 */
class XShopFormsSettingsValue extends SQLObject {

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
     * Get projectid
     * @return int
     */
    public function getProjectid() { return $this->getField('projectid');}

    /**
     * Set projectid
     * @param int $projectid
     */
    public function setProjectid($projectid, $update = false) {$this->setField('projectid', $projectid, $update);}

    /**
     * Filter projectid
     * @param int $projectid
     * @param string $operation
     */
    public function filterProjectid($projectid, $operation = false) {$this->filterField('projectid', $projectid, $operation);}

    /**
     * Get userid
     * @return int
     */
    public function getUserid() { return $this->getField('userid');}

    /**
     * Set userid
     * @param int $userid
     */
    public function setUserid($userid, $update = false) {$this->setField('userid', $userid, $update);}

    /**
     * Filter userid
     * @param int $userid
     * @param string $operation
     */
    public function filterUserid($userid, $operation = false) {$this->filterField('userid', $userid, $operation);}

    /**
     * Get fieldid
     * @return int
     */
    public function getFieldid() { return $this->getField('fieldid');}

    /**
     * Set fieldid
     * @param int $fieldid
     */
    public function setFieldid($fieldid, $update = false) {$this->setField('fieldid', $fieldid, $update);}

    /**
     * Filter fieldid
     * @param int $fieldid
     * @param string $operation
     */
    public function filterFieldid($fieldid, $operation = false) {$this->filterField('fieldid', $fieldid, $operation);}

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
     * Get cdate
     * @return string
     */
    public function getCdate() { return $this->getField('cdate');}

    /**
     * Set cdate
     * @param string $cdate
     */
    public function setCdate($cdate, $update = false) {$this->setField('cdate', $cdate, $update);}

    /**
     * Filter cdate
     * @param string $cdate
     * @param string $operation
     */
    public function filterCdate($cdate, $operation = false) {$this->filterField('cdate', $cdate, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopformssettingsvalue');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopFormsSettingsValue
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopFormsSettingsValue
     */
    public static function Get($key) {return self::GetObject("XShopFormsSettingsValue", $key);}

}

SQLObject::SetFieldArray('shopformssettingsvalue', array('id', 'formid', 'projectid', 'userid', 'fieldid', 'value', 'cdate'));
SQLObject::SetPrimaryKey('shopformssettingsvalue', 'id');
