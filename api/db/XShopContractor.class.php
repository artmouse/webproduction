<?php
/**
 * Class XShopContractor is ORM to table shopcontractor
 * @author SQLObject
 * @package SQLObject
 */
class XShopContractor extends SQLObject {

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
     * Get details
     * @return string
     */
    public function getDetails() { return $this->getField('details');}

    /**
     * Set details
     * @param string $details
     */
    public function setDetails($details, $update = false) {$this->setField('details', $details, $update);}

    /**
     * Filter details
     * @param string $details
     * @param string $operation
     */
    public function filterDetails($details, $operation = false) {$this->filterField('details', $details, $operation);}

    /**
     * Get tax
     * @return float
     */
    public function getTax() { return $this->getField('tax');}

    /**
     * Set tax
     * @param float $tax
     */
    public function setTax($tax, $update = false) {$this->setField('tax', $tax, $update);}

    /**
     * Filter tax
     * @param float $tax
     * @param string $operation
     */
    public function filterTax($tax, $operation = false) {$this->filterField('tax', $tax, $operation);}

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
     * Get customfield1
     * @return string
     */
    public function getCustomfield1() { return $this->getField('customfield1');}

    /**
     * Set customfield1
     * @param string $customfield1
     */
    public function setCustomfield1($customfield1, $update = false) {$this->setField('customfield1', $customfield1, $update);}

    /**
     * Filter customfield1
     * @param string $customfield1
     * @param string $operation
     */
    public function filterCustomfield1($customfield1, $operation = false) {$this->filterField('customfield1', $customfield1, $operation);}

    /**
     * Get customfield2
     * @return string
     */
    public function getCustomfield2() { return $this->getField('customfield2');}

    /**
     * Set customfield2
     * @param string $customfield2
     */
    public function setCustomfield2($customfield2, $update = false) {$this->setField('customfield2', $customfield2, $update);}

    /**
     * Filter customfield2
     * @param string $customfield2
     * @param string $operation
     */
    public function filterCustomfield2($customfield2, $operation = false) {$this->filterField('customfield2', $customfield2, $operation);}

    /**
     * Get customfield3
     * @return string
     */
    public function getCustomfield3() { return $this->getField('customfield3');}

    /**
     * Set customfield3
     * @param string $customfield3
     */
    public function setCustomfield3($customfield3, $update = false) {$this->setField('customfield3', $customfield3, $update);}

    /**
     * Filter customfield3
     * @param string $customfield3
     * @param string $operation
     */
    public function filterCustomfield3($customfield3, $operation = false) {$this->filterField('customfield3', $customfield3, $operation);}

    /**
     * Get customfield4
     * @return string
     */
    public function getCustomfield4() { return $this->getField('customfield4');}

    /**
     * Set customfield4
     * @param string $customfield4
     */
    public function setCustomfield4($customfield4, $update = false) {$this->setField('customfield4', $customfield4, $update);}

    /**
     * Filter customfield4
     * @param string $customfield4
     * @param string $operation
     */
    public function filterCustomfield4($customfield4, $operation = false) {$this->filterField('customfield4', $customfield4, $operation);}

    /**
     * Get customfield5
     * @return string
     */
    public function getCustomfield5() { return $this->getField('customfield5');}

    /**
     * Set customfield5
     * @param string $customfield5
     */
    public function setCustomfield5($customfield5, $update = false) {$this->setField('customfield5', $customfield5, $update);}

    /**
     * Filter customfield5
     * @param string $customfield5
     * @param string $operation
     */
    public function filterCustomfield5($customfield5, $operation = false) {$this->filterField('customfield5', $customfield5, $operation);}

    /**
     * Get customfield6
     * @return string
     */
    public function getCustomfield6() { return $this->getField('customfield6');}

    /**
     * Set customfield6
     * @param string $customfield6
     */
    public function setCustomfield6($customfield6, $update = false) {$this->setField('customfield6', $customfield6, $update);}

    /**
     * Filter customfield6
     * @param string $customfield6
     * @param string $operation
     */
    public function filterCustomfield6($customfield6, $operation = false) {$this->filterField('customfield6', $customfield6, $operation);}

    /**
     * Get customfield7
     * @return string
     */
    public function getCustomfield7() { return $this->getField('customfield7');}

    /**
     * Set customfield7
     * @param string $customfield7
     */
    public function setCustomfield7($customfield7, $update = false) {$this->setField('customfield7', $customfield7, $update);}

    /**
     * Filter customfield7
     * @param string $customfield7
     * @param string $operation
     */
    public function filterCustomfield7($customfield7, $operation = false) {$this->filterField('customfield7', $customfield7, $operation);}

    /**
     * Get customfield8
     * @return string
     */
    public function getCustomfield8() { return $this->getField('customfield8');}

    /**
     * Set customfield8
     * @param string $customfield8
     */
    public function setCustomfield8($customfield8, $update = false) {$this->setField('customfield8', $customfield8, $update);}

    /**
     * Filter customfield8
     * @param string $customfield8
     * @param string $operation
     */
    public function filterCustomfield8($customfield8, $operation = false) {$this->filterField('customfield8', $customfield8, $operation);}

    /**
     * Get customfield9
     * @return string
     */
    public function getCustomfield9() { return $this->getField('customfield9');}

    /**
     * Set customfield9
     * @param string $customfield9
     */
    public function setCustomfield9($customfield9, $update = false) {$this->setField('customfield9', $customfield9, $update);}

    /**
     * Filter customfield9
     * @param string $customfield9
     * @param string $operation
     */
    public function filterCustomfield9($customfield9, $operation = false) {$this->filterField('customfield9', $customfield9, $operation);}

    /**
     * Get customfield10
     * @return string
     */
    public function getCustomfield10() { return $this->getField('customfield10');}

    /**
     * Set customfield10
     * @param string $customfield10
     */
    public function setCustomfield10($customfield10, $update = false) {$this->setField('customfield10', $customfield10, $update);}

    /**
     * Filter customfield10
     * @param string $customfield10
     * @param string $operation
     */
    public function filterCustomfield10($customfield10, $operation = false) {$this->filterField('customfield10', $customfield10, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopcontractor');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopContractor
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopContractor
     */
    public static function Get($key) {return self::GetObject("XShopContractor", $key);}

}

SQLObject::SetFieldArray('shopcontractor', array('id', 'name', 'details', 'tax', 'active', 'default', 'linkkey', 'customfield1', 'customfield2', 'customfield3', 'customfield4', 'customfield5', 'customfield6', 'customfield7', 'customfield8', 'customfield9', 'customfield10'));
SQLObject::SetPrimaryKey('shopcontractor', 'id');
