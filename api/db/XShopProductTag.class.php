<?php
/**
 * Class XShopProductTag is ORM to table shopproducttag
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductTag extends SQLObject {

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
     * Get url
     * @return string
     */
    public function getUrl() { return $this->getField('url');}

    /**
     * Set url
     * @param string $url
     */
    public function setUrl($url, $update = false) {$this->setField('url', $url, $update);}

    /**
     * Filter url
     * @param string $url
     * @param string $operation
     */
    public function filterUrl($url, $operation = false) {$this->filterField('url', $url, $operation);}

    /**
     * Get description
     * @return string
     */
    public function getDescription() { return $this->getField('description');}

    /**
     * Set description
     * @param string $description
     */
    public function setDescription($description, $update = false) {$this->setField('description', $description, $update);}

    /**
     * Filter description
     * @param string $description
     * @param string $operation
     */
    public function filterDescription($description, $operation = false) {$this->filterField('description', $description, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproducttag');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductTag
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductTag
     */
    public static function Get($key) {return self::GetObject("XShopProductTag", $key);}

}

SQLObject::SetFieldArray('shopproducttag', array('id', 'name', 'url', 'description'));
SQLObject::SetPrimaryKey('shopproducttag', 'id');
