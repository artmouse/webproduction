<?php
/**
 * Class XShopCommentTemplate is ORM to table shopcommenttemplate
 * @author SQLObject
 * @package SQLObject
 */
class XShopCommentTemplate extends SQLObject {

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
     * Get text
     * @return string
     */
    public function getText() { return $this->getField('text');}

    /**
     * Set text
     * @param string $text
     */
    public function setText($text, $update = false) {$this->setField('text', $text, $update);}

    /**
     * Filter text
     * @param string $text
     * @param string $operation
     */
    public function filterText($text, $operation = false) {$this->filterField('text', $text, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopcommenttemplate');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopCommentTemplate
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopCommentTemplate
     */
    public static function Get($key) {return self::GetObject("XShopCommentTemplate", $key);}

}

SQLObject::SetFieldArray('shopcommenttemplate', array('id', 'name', 'text'));
SQLObject::SetPrimaryKey('shopcommenttemplate', 'id');
