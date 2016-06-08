<?php
/**
 * Class XShopNotification is ORM to table shopnotification
 * @author SQLObject
 * @package SQLObject
 */
class XShopNotification extends SQLObject {

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
     * Get commentid
     * @return int
     */
    public function getCommentid() { return $this->getField('commentid');}

    /**
     * Set commentid
     * @param int $commentid
     */
    public function setCommentid($commentid, $update = false) {$this->setField('commentid', $commentid, $update);}

    /**
     * Filter commentid
     * @param int $commentid
     * @param string $operation
     */
    public function filterCommentid($commentid, $operation = false) {$this->filterField('commentid', $commentid, $operation);}

    /**
     * Get orderid
     * @return int
     */
    public function getOrderid() { return $this->getField('orderid');}

    /**
     * Set orderid
     * @param int $orderid
     */
    public function setOrderid($orderid, $update = false) {$this->setField('orderid', $orderid, $update);}

    /**
     * Filter orderid
     * @param int $orderid
     * @param string $operation
     */
    public function filterOrderid($orderid, $operation = false) {$this->filterField('orderid', $orderid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopnotification');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopNotification
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopNotification
     */
    public static function Get($key) {return self::GetObject("XShopNotification", $key);}

}

SQLObject::SetFieldArray('shopnotification', array('id', 'userid', 'commentid', 'orderid'));
SQLObject::SetPrimaryKey('shopnotification', 'id');
