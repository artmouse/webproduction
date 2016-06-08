<?php
/**
 * Class XShopProductList is ORM to table shopproductlist
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductList extends SQLObject {

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
     * Get nameshort
     * @return string
     */
    public function getNameshort() { return $this->getField('nameshort');}

    /**
     * Set nameshort
     * @param string $nameshort
     */
    public function setNameshort($nameshort, $update = false) {$this->setField('nameshort', $nameshort, $update);}

    /**
     * Filter nameshort
     * @param string $nameshort
     * @param string $operation
     */
    public function filterNameshort($nameshort, $operation = false) {$this->filterField('nameshort', $nameshort, $operation);}

    /**
     * Get showinmain
     * @return int
     */
    public function getShowinmain() { return $this->getField('showinmain');}

    /**
     * Set showinmain
     * @param int $showinmain
     */
    public function setShowinmain($showinmain, $update = false) {$this->setField('showinmain', $showinmain, $update);}

    /**
     * Filter showinmain
     * @param int $showinmain
     * @param string $operation
     */
    public function filterShowinmain($showinmain, $operation = false) {$this->filterField('showinmain', $showinmain, $operation);}

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
     * Get showtype
     * @return string
     */
    public function getShowtype() { return $this->getField('showtype');}

    /**
     * Set showtype
     * @param string $showtype
     */
    public function setShowtype($showtype, $update = false) {$this->setField('showtype', $showtype, $update);}

    /**
     * Filter showtype
     * @param string $showtype
     * @param string $operation
     */
    public function filterShowtype($showtype, $operation = false) {$this->filterField('showtype', $showtype, $operation);}

    /**
     * Get autoplay
     * @return int
     */
    public function getAutoplay() { return $this->getField('autoplay');}

    /**
     * Set autoplay
     * @param int $autoplay
     */
    public function setAutoplay($autoplay, $update = false) {$this->setField('autoplay', $autoplay, $update);}

    /**
     * Filter autoplay
     * @param int $autoplay
     * @param string $operation
     */
    public function filterAutoplay($autoplay, $operation = false) {$this->filterField('autoplay', $autoplay, $operation);}

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
     * Get setimage
     * @return string
     */
    public function getSetimage() { return $this->getField('setimage');}

    /**
     * Set setimage
     * @param string $setimage
     */
    public function setSetimage($setimage, $update = false) {$this->setField('setimage', $setimage, $update);}

    /**
     * Filter setimage
     * @param string $setimage
     * @param string $operation
     */
    public function filterSetimage($setimage, $operation = false) {$this->filterField('setimage', $setimage, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductlist');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductList
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductList
     */
    public static function Get($key) {return self::GetObject("XShopProductList", $key);}

}

SQLObject::SetFieldArray('shopproductlist', array('id', 'name', 'nameshort', 'showinmain', 'linkkey', 'hidden', 'showtype', 'autoplay', 'logicclass', 'setimage'));
SQLObject::SetPrimaryKey('shopproductlist', 'id');
