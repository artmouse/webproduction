<?php
/**
 * Class XShopRedirect is ORM to table shopredirect
 * @author SQLObject
 * @package SQLObject
 */
class XShopRedirect extends SQLObject {

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
     * Get urlfrom
     * @return string
     */
    public function getUrlfrom() { return $this->getField('urlfrom');}

    /**
     * Set urlfrom
     * @param string $urlfrom
     */
    public function setUrlfrom($urlfrom, $update = false) {$this->setField('urlfrom', $urlfrom, $update);}

    /**
     * Filter urlfrom
     * @param string $urlfrom
     * @param string $operation
     */
    public function filterUrlfrom($urlfrom, $operation = false) {$this->filterField('urlfrom', $urlfrom, $operation);}

    /**
     * Get urlto
     * @return string
     */
    public function getUrlto() { return $this->getField('urlto');}

    /**
     * Set urlto
     * @param string $urlto
     */
    public function setUrlto($urlto, $update = false) {$this->setField('urlto', $urlto, $update);}

    /**
     * Filter urlto
     * @param string $urlto
     * @param string $operation
     */
    public function filterUrlto($urlto, $operation = false) {$this->filterField('urlto', $urlto, $operation);}

    /**
     * Get code
     * @return int
     */
    public function getCode() { return $this->getField('code');}

    /**
     * Set code
     * @param int $code
     */
    public function setCode($code, $update = false) {$this->setField('code', $code, $update);}

    /**
     * Filter code
     * @param int $code
     * @param string $operation
     */
    public function filterCode($code, $operation = false) {$this->filterField('code', $code, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopredirect');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopRedirect
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopRedirect
     */
    public static function Get($key) {return self::GetObject("XShopRedirect", $key);}

}

SQLObject::SetFieldArray('shopredirect', array('id', 'urlfrom', 'urlto', 'code'));
SQLObject::SetPrimaryKey('shopredirect', 'id');
