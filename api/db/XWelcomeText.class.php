<?php
/**
 * Class XWelcomeText is ORM to table welcometext
 * @author SQLObject
 * @package SQLObject
 */
class XWelcomeText extends SQLObject {

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
     * Get content
     * @return string
     */
    public function getContent() { return $this->getField('content');}

    /**
     * Set content
     * @param string $content
     */
    public function setContent($content, $update = false) {$this->setField('content', $content, $update);}

    /**
     * Filter content
     * @param string $content
     * @param string $operation
     */
    public function filterContent($content, $operation = false) {$this->filterField('content', $content, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('welcometext');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XWelcomeText
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XWelcomeText
     */
    public static function Get($key) {return self::GetObject("XWelcomeText", $key);}

}

SQLObject::SetFieldArray('welcometext', array('id', 'userid', 'content'));
SQLObject::SetPrimaryKey('welcometext', 'id');
