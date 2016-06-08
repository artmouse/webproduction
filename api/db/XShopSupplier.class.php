<?php
/**
 * Class XShopSupplier is ORM to table shopsupplier
 * @author SQLObject
 * @package SQLObject
 */
class XShopSupplier extends SQLObject {

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
     * Get contactid
     * @return int
     */
    public function getContactid() { return $this->getField('contactid');}

    /**
     * Set contactid
     * @param int $contactid
     */
    public function setContactid($contactid, $update = false) {$this->setField('contactid', $contactid, $update);}

    /**
     * Filter contactid
     * @param int $contactid
     * @param string $operation
     */
    public function filterContactid($contactid, $operation = false) {$this->filterField('contactid', $contactid, $operation);}

    /**
     * Get workflowid
     * @return int
     */
    public function getWorkflowid() { return $this->getField('workflowid');}

    /**
     * Set workflowid
     * @param int $workflowid
     */
    public function setWorkflowid($workflowid, $update = false) {$this->setField('workflowid', $workflowid, $update);}

    /**
     * Filter workflowid
     * @param int $workflowid
     * @param string $operation
     */
    public function filterWorkflowid($workflowid, $operation = false) {$this->filterField('workflowid', $workflowid, $operation);}

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
     * Get color
     * @return string
     */
    public function getColor() { return $this->getField('color');}

    /**
     * Set color
     * @param string $color
     */
    public function setColor($color, $update = false) {$this->setField('color', $color, $update);}

    /**
     * Filter color
     * @param string $color
     * @param string $operation
     */
    public function filterColor($color, $operation = false) {$this->filterField('color', $color, $operation);}

    /**
     * Get availtext
     * @return string
     */
    public function getAvailtext() { return $this->getField('availtext');}

    /**
     * Set availtext
     * @param string $availtext
     */
    public function setAvailtext($availtext, $update = false) {$this->setField('availtext', $availtext, $update);}

    /**
     * Filter availtext
     * @param string $availtext
     * @param string $operation
     */
    public function filterAvailtext($availtext, $operation = false) {$this->filterField('availtext', $availtext, $operation);}

    /**
     * Get deliverytime
     * @return string
     */
    public function getDeliverytime() { return $this->getField('deliverytime');}

    /**
     * Set deliverytime
     * @param string $deliverytime
     */
    public function setDeliverytime($deliverytime, $update = false) {$this->setField('deliverytime', $deliverytime, $update);}

    /**
     * Filter deliverytime
     * @param string $deliverytime
     * @param string $operation
     */
    public function filterDeliverytime($deliverytime, $operation = false) {$this->filterField('deliverytime', $deliverytime, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopsupplier');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopSupplier
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopSupplier
     */
    public static function Get($key) {return self::GetObject("XShopSupplier", $key);}

}

SQLObject::SetFieldArray('shopsupplier', array('id', 'name', 'description', 'contactid', 'workflowid', 'hidden', 'color', 'availtext', 'deliverytime'));
SQLObject::SetPrimaryKey('shopsupplier', 'id');
