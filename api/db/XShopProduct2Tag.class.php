<?php
/**
 * Class XShopProduct2Tag is ORM to table shopproduct2tag
 * @author SQLObject
 * @package SQLObject
 */
class XShopProduct2Tag extends SQLObject {

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
     * Get productid
     * @return int
     */
    public function getProductid() { return $this->getField('productid');}

    /**
     * Set productid
     * @param int $productid
     */
    public function setProductid($productid, $update = false) {$this->setField('productid', $productid, $update);}

    /**
     * Filter productid
     * @param int $productid
     * @param string $operation
     */
    public function filterProductid($productid, $operation = false) {$this->filterField('productid', $productid, $operation);}

    /**
     * Get tagid
     * @return int
     */
    public function getTagid() { return $this->getField('tagid');}

    /**
     * Set tagid
     * @param int $tagid
     */
    public function setTagid($tagid, $update = false) {$this->setField('tagid', $tagid, $update);}

    /**
     * Filter tagid
     * @param int $tagid
     * @param string $operation
     */
    public function filterTagid($tagid, $operation = false) {$this->filterField('tagid', $tagid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproduct2tag');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProduct2Tag
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProduct2Tag
     */
    public static function Get($key) {return self::GetObject("XShopProduct2Tag", $key);}

}

SQLObject::SetFieldArray('shopproduct2tag', array('id', 'productid', 'tagid'));
SQLObject::SetPrimaryKey('shopproduct2tag', 'id');
