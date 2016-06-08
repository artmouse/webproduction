<?php
/**
 * Class XShopPayment is ORM to table shoppayment
 * @author SQLObject
 * @package SQLObject
 */
class XShopPayment extends SQLObject {

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
     * Get image
     * @return string
     */
    public function getImage() { return $this->getField('image');}

    /**
     * Set image
     * @param string $image
     */
    public function setImage($image, $update = false) {$this->setField('image', $image, $update);}

    /**
     * Filter image
     * @param string $image
     * @param string $operation
     */
    public function filterImage($image, $operation = false) {$this->filterField('image', $image, $operation);}

    /**
     * Get deliveryid
     * @return int
     */
    public function getDeliveryid() { return $this->getField('deliveryid');}

    /**
     * Set deliveryid
     * @param int $deliveryid
     */
    public function setDeliveryid($deliveryid, $update = false) {$this->setField('deliveryid', $deliveryid, $update);}

    /**
     * Filter deliveryid
     * @param int $deliveryid
     * @param string $operation
     */
    public function filterDeliveryid($deliveryid, $operation = false) {$this->filterField('deliveryid', $deliveryid, $operation);}

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
     * Get contentid
     * @return string
     */
    public function getContentid() { return $this->getField('contentid');}

    /**
     * Set contentid
     * @param string $contentid
     */
    public function setContentid($contentid, $update = false) {$this->setField('contentid', $contentid, $update);}

    /**
     * Filter contentid
     * @param string $contentid
     * @param string $operation
     */
    public function filterContentid($contentid, $operation = false) {$this->filterField('contentid', $contentid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoppayment');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopPayment
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopPayment
     */
    public static function Get($key) {return self::GetObject("XShopPayment", $key);}

}

SQLObject::SetFieldArray('shoppayment', array('id', 'name', 'description', 'image', 'deliveryid', 'hidden', 'default', 'contentid'));
SQLObject::SetPrimaryKey('shoppayment', 'id');
