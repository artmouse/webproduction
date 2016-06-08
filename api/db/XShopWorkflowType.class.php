<?php
/**
 * Class XShopWorkflowType is ORM to table shopworkflowtype
 * @author SQLObject
 * @package SQLObject
 */
class XShopWorkflowType extends SQLObject {

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
     * Get multiplename
     * @return string
     */
    public function getMultiplename() { return $this->getField('multiplename');}

    /**
     * Set multiplename
     * @param string $multiplename
     */
    public function setMultiplename($multiplename, $update = false) {$this->setField('multiplename', $multiplename, $update);}

    /**
     * Filter multiplename
     * @param string $multiplename
     * @param string $operation
     */
    public function filterMultiplename($multiplename, $operation = false) {$this->filterField('multiplename', $multiplename, $operation);}

    /**
     * Get icon
     * @return string
     */
    public function getIcon() { return $this->getField('icon');}

    /**
     * Set icon
     * @param string $icon
     */
    public function setIcon($icon, $update = false) {$this->setField('icon', $icon, $update);}

    /**
     * Filter icon
     * @param string $icon
     * @param string $operation
     */
    public function filterIcon($icon, $operation = false) {$this->filterField('icon', $icon, $operation);}

    /**
     * Get type
     * @return string
     */
    public function getType() { return $this->getField('type');}

    /**
     * Set type
     * @param string $type
     */
    public function setType($type, $update = false) {$this->setField('type', $type, $update);}

    /**
     * Filter type
     * @param string $type
     * @param string $operation
     */
    public function filterType($type, $operation = false) {$this->filterField('type', $type, $operation);}

    /**
     * Get typeaddpage
     * @return string
     */
    public function getTypeaddpage() { return $this->getField('typeaddpage');}

    /**
     * Set typeaddpage
     * @param string $typeaddpage
     */
    public function setTypeaddpage($typeaddpage, $update = false) {$this->setField('typeaddpage', $typeaddpage, $update);}

    /**
     * Filter typeaddpage
     * @param string $typeaddpage
     * @param string $operation
     */
    public function filterTypeaddpage($typeaddpage, $operation = false) {$this->filterField('typeaddpage', $typeaddpage, $operation);}

    /**
     * Get contentId
     * @return string
     */
    public function getContentId() { return $this->getField('contentId');}

    /**
     * Set contentId
     * @param string $contentId
     */
    public function setContentId($contentId, $update = false) {$this->setField('contentId', $contentId, $update);}

    /**
     * Filter contentId
     * @param string $contentId
     * @param string $operation
     */
    public function filterContentId($contentId, $operation = false) {$this->filterField('contentId', $contentId, $operation);}

    /**
     * Get calendarShow
     * @return int
     */
    public function getCalendarShow() { return $this->getField('calendarShow');}

    /**
     * Set calendarShow
     * @param int $calendarShow
     */
    public function setCalendarShow($calendarShow, $update = false) {$this->setField('calendarShow', $calendarShow, $update);}

    /**
     * Filter calendarShow
     * @param int $calendarShow
     * @param string $operation
     */
    public function filterCalendarShow($calendarShow, $operation = false) {$this->filterField('calendarShow', $calendarShow, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopworkflowtype');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopWorkflowType
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopWorkflowType
     */
    public static function Get($key) {return self::GetObject("XShopWorkflowType", $key);}

}

SQLObject::SetFieldArray('shopworkflowtype', array('id', 'name', 'multiplename', 'icon', 'type', 'typeaddpage', 'contentId', 'calendarShow'));
SQLObject::SetPrimaryKey('shopworkflowtype', 'id');
