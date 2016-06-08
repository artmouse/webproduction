<?php
/**
 * Class XShopContactField is ORM to table shopuserfield
 * @author SQLObject
 * @package SQLObject
 */
class XShopContactField extends SQLObject {

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
     * Get groupid
     * @return int
     */
    public function getGroupid() { return $this->getField('groupid');}

    /**
     * Set groupid
     * @param int $groupid
     */
    public function setGroupid($groupid, $update = false) {$this->setField('groupid', $groupid, $update);}

    /**
     * Filter groupid
     * @param int $groupid
     * @param string $operation
     */
    public function filterGroupid($groupid, $operation = false) {$this->filterField('groupid', $groupid, $operation);}

    /**
     * Get idkey
     * @return string
     */
    public function getIdkey() { return $this->getField('idkey');}

    /**
     * Set idkey
     * @param string $idkey
     */
    public function setIdkey($idkey, $update = false) {$this->setField('idkey', $idkey, $update);}

    /**
     * Filter idkey
     * @param string $idkey
     * @param string $operation
     */
    public function filterIdkey($idkey, $operation = false) {$this->filterField('idkey', $idkey, $operation);}

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
     * Get filterable
     * @return int
     */
    public function getFilterable() { return $this->getField('filterable');}

    /**
     * Set filterable
     * @param int $filterable
     */
    public function setFilterable($filterable, $update = false) {$this->setField('filterable', $filterable, $update);}

    /**
     * Filter filterable
     * @param int $filterable
     * @param string $operation
     */
    public function filterFilterable($filterable, $operation = false) {$this->filterField('filterable', $filterable, $operation);}

    /**
     * Get showinpreview
     * @return int
     */
    public function getShowinpreview() { return $this->getField('showinpreview');}

    /**
     * Set showinpreview
     * @param int $showinpreview
     */
    public function setShowinpreview($showinpreview, $update = false) {$this->setField('showinpreview', $showinpreview, $update);}

    /**
     * Filter showinpreview
     * @param int $showinpreview
     * @param string $operation
     */
    public function filterShowinpreview($showinpreview, $operation = false) {$this->filterField('showinpreview', $showinpreview, $operation);}

    /**
     * Get showinorder
     * @return int
     */
    public function getShowinorder() { return $this->getField('showinorder');}

    /**
     * Set showinorder
     * @param int $showinorder
     */
    public function setShowinorder($showinorder, $update = false) {$this->setField('showinorder', $showinorder, $update);}

    /**
     * Filter showinorder
     * @param int $showinorder
     * @param string $operation
     */
    public function filterShowinorder($showinorder, $operation = false) {$this->filterField('showinorder', $showinorder, $operation);}

    /**
     * Get typecontact
     * @return string
     */
    public function getTypecontact() { return $this->getField('typecontact');}

    /**
     * Set typecontact
     * @param string $typecontact
     */
    public function setTypecontact($typecontact, $update = false) {$this->setField('typecontact', $typecontact, $update);}

    /**
     * Filter typecontact
     * @param string $typecontact
     * @param string $operation
     */
    public function filterTypecontact($typecontact, $operation = false) {$this->filterField('typecontact', $typecontact, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopuserfield');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopContactField
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopContactField
     */
    public static function Get($key) {return self::GetObject("XShopContactField", $key);}

}

SQLObject::SetFieldArray('shopuserfield', array('id', 'groupid', 'idkey', 'name', 'type', 'hidden', 'filterable', 'showinpreview', 'showinorder', 'typecontact'));
SQLObject::SetPrimaryKey('shopuserfield', 'id');
