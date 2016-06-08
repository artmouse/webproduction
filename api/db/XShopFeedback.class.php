<?php
/**
 * Class XShopFeedback is ORM to table shopfeedback
 * @author SQLObject
 * @package SQLObject
 */
class XShopFeedback extends SQLObject {

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
     * Get phone
     * @return string
     */
    public function getPhone() { return $this->getField('phone');}

    /**
     * Set phone
     * @param string $phone
     */
    public function setPhone($phone, $update = false) {$this->setField('phone', $phone, $update);}

    /**
     * Filter phone
     * @param string $phone
     * @param string $operation
     */
    public function filterPhone($phone, $operation = false) {$this->filterField('phone', $phone, $operation);}

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
     * Get email
     * @return string
     */
    public function getEmail() { return $this->getField('email');}

    /**
     * Set email
     * @param string $email
     */
    public function setEmail($email, $update = false) {$this->setField('email', $email, $update);}

    /**
     * Filter email
     * @param string $email
     * @param string $operation
     */
    public function filterEmail($email, $operation = false) {$this->filterField('email', $email, $operation);}

    /**
     * Get message
     * @return string
     */
    public function getMessage() { return $this->getField('message');}

    /**
     * Set message
     * @param string $message
     */
    public function setMessage($message, $update = false) {$this->setField('message', $message, $update);}

    /**
     * Filter message
     * @param string $message
     * @param string $operation
     */
    public function filterMessage($message, $operation = false) {$this->filterField('message', $message, $operation);}

    /**
     * Get done
     * @return int
     */
    public function getDone() { return $this->getField('done');}

    /**
     * Set done
     * @param int $done
     */
    public function setDone($done, $update = false) {$this->setField('done', $done, $update);}

    /**
     * Filter done
     * @param int $done
     * @param string $operation
     */
    public function filterDone($done, $operation = false) {$this->filterField('done', $done, $operation);}

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
     * Get pageurl
     * @return string
     */
    public function getPageurl() { return $this->getField('pageurl');}

    /**
     * Set pageurl
     * @param string $pageurl
     */
    public function setPageurl($pageurl, $update = false) {$this->setField('pageurl', $pageurl, $update);}

    /**
     * Filter pageurl
     * @param string $pageurl
     * @param string $operation
     */
    public function filterPageurl($pageurl, $operation = false) {$this->filterField('pageurl', $pageurl, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopfeedback');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopFeedback
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopFeedback
     */
    public static function Get($key) {return self::GetObject("XShopFeedback", $key);}

}

SQLObject::SetFieldArray('shopfeedback', array('id', 'name', 'phone', 'cdate', 'email', 'message', 'done', 'userid', 'pageurl'));
SQLObject::SetPrimaryKey('shopfeedback', 'id');
