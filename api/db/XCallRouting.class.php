<?php
/**
 * Class XCallRouting is ORM to table callrouting
 * @author SQLObject
 * @package SQLObject
 */
class XCallRouting extends SQLObject {

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
     * Get from
     * @return string
     */
    public function getFrom() { return $this->getField('from');}

    /**
     * Set from
     * @param string $from
     */
    public function setFrom($from, $update = false) {$this->setField('from', $from, $update);}

    /**
     * Filter from
     * @param string $from
     * @param string $operation
     */
    public function filterFrom($from, $operation = false) {$this->filterField('from', $from, $operation);}

    /**
     * Get to
     * @return string
     */
    public function getTo() { return $this->getField('to');}

    /**
     * Set to
     * @param string $to
     */
    public function setTo($to, $update = false) {$this->setField('to', $to, $update);}

    /**
     * Filter to
     * @param string $to
     * @param string $operation
     */
    public function filterTo($to, $operation = false) {$this->filterField('to', $to, $operation);}

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
     * Get comment
     * @return string
     */
    public function getComment() { return $this->getField('comment');}

    /**
     * Set comment
     * @param string $comment
     */
    public function setComment($comment, $update = false) {$this->setField('comment', $comment, $update);}

    /**
     * Filter comment
     * @param string $comment
     * @param string $operation
     */
    public function filterComment($comment, $operation = false) {$this->filterField('comment', $comment, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('callrouting');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XCallRouting
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XCallRouting
     */
    public static function Get($key) {return self::GetObject("XCallRouting", $key);}

}

SQLObject::SetFieldArray('callrouting', array('id', 'from', 'to', 'name', 'comment'));
SQLObject::SetPrimaryKey('callrouting', 'id');
