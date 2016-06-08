<?php
/**
 * Class XShopProductFilter is ORM to table shopproductfilter
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductFilter extends SQLObject {

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
     * Get filter
     * @return int
     */
    public function getFilter() { return $this->getField('filter');}

    /**
     * Set filter
     * @param int $filter
     */
    public function setFilter($filter, $update = false) {$this->setField('filter', $filter, $update);}

    /**
     * Filter filter
     * @param int $filter
     * @param string $operation
     */
    public function filterFilter($filter, $operation = false) {$this->filterField('filter', $filter, $operation);}

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
     * Get type
     * @return int
     */
    public function getType() { return $this->getField('type');}

    /**
     * Set type
     * @param int $type
     */
    public function setType($type, $update = false) {$this->setField('type', $type, $update);}

    /**
     * Filter type
     * @param int $type
     * @param string $operation
     */
    public function filterType($type, $operation = false) {$this->filterField('type', $type, $operation);}

    /**
     * Get sorttype
     * @return int
     */
    public function getSorttype() { return $this->getField('sorttype');}

    /**
     * Set sorttype
     * @param int $sorttype
     */
    public function setSorttype($sorttype, $update = false) {$this->setField('sorttype', $sorttype, $update);}

    /**
     * Filter sorttype
     * @param int $sorttype
     * @param string $operation
     */
    public function filterSorttype($sorttype, $operation = false) {$this->filterField('sorttype', $sorttype, $operation);}

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
     * Get basicfilter
     * @return int
     */
    public function getBasicfilter() { return $this->getField('basicfilter');}

    /**
     * Set basicfilter
     * @param int $basicfilter
     */
    public function setBasicfilter($basicfilter, $update = false) {$this->setField('basicfilter', $basicfilter, $update);}

    /**
     * Filter basicfilter
     * @param int $basicfilter
     * @param string $operation
     */
    public function filterBasicfilter($basicfilter, $operation = false) {$this->filterField('basicfilter', $basicfilter, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductfilter');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductFilter
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductFilter
     */
    public static function Get($key) {return self::GetObject("XShopProductFilter", $key);}

}

SQLObject::SetFieldArray('shopproductfilter', array('id', 'name', 'hidden', 'filter', 'sort', 'type', 'sorttype', 'linkkey', 'basicfilter'));
SQLObject::SetPrimaryKey('shopproductfilter', 'id');
