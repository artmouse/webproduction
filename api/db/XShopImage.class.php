<?php
/**
 * Class XShopImage is ORM to table shopimage
 * @author SQLObject
 * @package SQLObject
 */
class XShopImage extends SQLObject {

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
     * Get file
     * @return string
     */
    public function getFile() { return $this->getField('file');}

    /**
     * Set file
     * @param string $file
     */
    public function setFile($file, $update = false) {$this->setField('file', $file, $update);}

    /**
     * Filter file
     * @param string $file
     * @param string $operation
     */
    public function filterFile($file, $operation = false) {$this->filterField('file', $file, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopimage');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopImage
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopImage
     */
    public static function Get($key) {return self::GetObject("XShopImage", $key);}

}

SQLObject::SetFieldArray('shopimage', array('id', 'productid', 'file'));
SQLObject::SetPrimaryKey('shopimage', 'id');
