<?php
/**
 * Class CommentsAPI_XComment is ORM to table commentsapi_comment
 * @author SQLObject
 * @package SQLObject
 */
class CommentsAPI_XComment extends SQLObject {

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
     * Get cdate
     * @return string
     */
    public function getCdate() { return $this->getField('cdate');}

    /**
     * Set cdate
     * @param string $cdate
     */
    public function setCdate($cdate, $update = false) {$this->setField('cdate', $cdate, $update);}

    /**
     * Filter cdate
     * @param string $cdate
     * @param string $operation
     */
    public function filterCdate($cdate, $operation = false) {$this->filterField('cdate', $cdate, $operation);}

    /**
     * Get id_user
     * @return int
     */
    public function getId_user() { return $this->getField('id_user');}

    /**
     * Set id_user
     * @param int $id_user
     */
    public function setId_user($id_user, $update = false) {$this->setField('id_user', $id_user, $update);}

    /**
     * Filter id_user
     * @param int $id_user
     * @param string $operation
     */
    public function filterId_user($id_user, $operation = false) {$this->filterField('id_user', $id_user, $operation);}

    /**
     * Get key
     * @return string
     */
    public function getKey() { return $this->getField('key');}

    /**
     * Set key
     * @param string $key
     */
    public function setKey($key, $update = false) {$this->setField('key', $key, $update);}

    /**
     * Filter key
     * @param string $key
     * @param string $operation
     */
    public function filterKey($key, $operation = false) {$this->filterField('key', $key, $operation);}

    /**
     * Get sessionid
     * @return string
     */
    public function getSessionid() { return $this->getField('sessionid');}

    /**
     * Set sessionid
     * @param string $sessionid
     */
    public function setSessionid($sessionid, $update = false) {$this->setField('sessionid', $sessionid, $update);}

    /**
     * Filter sessionid
     * @param string $sessionid
     * @param string $operation
     */
    public function filterSessionid($sessionid, $operation = false) {$this->filterField('sessionid', $sessionid, $operation);}

    /**
     * Get ip
     * @return string
     */
    public function getIp() { return $this->getField('ip');}

    /**
     * Set ip
     * @param string $ip
     */
    public function setIp($ip, $update = false) {$this->setField('ip', $ip, $update);}

    /**
     * Filter ip
     * @param string $ip
     * @param string $operation
     */
    public function filterIp($ip, $operation = false) {$this->filterField('ip', $ip, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('commentsapi_comment');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return CommentsAPI_XComment
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return CommentsAPI_XComment
     */
    public static function Get($key) {return self::GetObject("CommentsAPI_XComment", $key);}

}

SQLObject::SetFieldArray('commentsapi_comment', array('id', 'cdate', 'id_user', 'key', 'sessionid', 'ip', 'content', 'type'));
SQLObject::SetPrimaryKey('commentsapi_comment', 'id');
