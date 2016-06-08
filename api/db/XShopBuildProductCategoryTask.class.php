<?php
/**
 * Class XShopBuildProductCategoryTask is ORM to table shopbuildproductcategorytask
 * @author SQLObject
 * @package SQLObject
 */
class XShopBuildProductCategoryTask extends SQLObject {

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
     * Get pdate
     * @return string
     */
    public function getPdate() { return $this->getField('pdate');}

    /**
     * Set pdate
     * @param string $pdate
     */
    public function setPdate($pdate, $update = false) {$this->setField('pdate', $pdate, $update);}

    /**
     * Filter pdate
     * @param string $pdate
     * @param string $operation
     */
    public function filterPdate($pdate, $operation = false) {$this->filterField('pdate', $pdate, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopbuildproductcategorytask');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopBuildProductCategoryTask
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopBuildProductCategoryTask
     */
    public static function Get($key) {return self::GetObject("XShopBuildProductCategoryTask", $key);}

}

SQLObject::SetFieldArray('shopbuildproductcategorytask', array('id', 'cdate', 'pdate'));
SQLObject::SetPrimaryKey('shopbuildproductcategorytask', 'id');
