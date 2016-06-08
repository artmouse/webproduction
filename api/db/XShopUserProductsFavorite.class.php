<?php
/**
 * Class XShopUserProductsFavorite is ORM to table shop_user_products_favorite
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserProductsFavorite extends SQLObject {

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shop_user_products_favorite');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserProductsFavorite
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserProductsFavorite
     */
    public static function Get($key) {return self::GetObject("XShopUserProductsFavorite", $key);}

}

SQLObject::SetFieldArray('shop_user_products_favorite', array('id', 'productid', 'userid'));
SQLObject::SetPrimaryKey('shop_user_products_favorite', 'id');
