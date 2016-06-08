<?php
/**
 * Class XUserAuth is ORM to table userauth
 * @author SQLObject
 * @package SQLObject
 */
class XUserAuth extends SQLObject {

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
     * Get adate
     * @return string
     */
    public function getAdate() { return $this->getField('adate');}

    /**
     * Set adate
     * @param string $adate
     */
    public function setAdate($adate, $update = false) {$this->setField('adate', $adate, $update);}

    /**
     * Filter adate
     * @param string $adate
     * @param string $operation
     */
    public function filterAdate($adate, $operation = false) {$this->filterField('adate', $adate, $operation);}

    /**
     * Get sdate
     * @return string
     */
    public function getSdate() { return $this->getField('sdate');}

    /**
     * Set sdate
     * @param string $sdate
     */
    public function setSdate($sdate, $update = false) {$this->setField('sdate', $sdate, $update);}

    /**
     * Filter sdate
     * @param string $sdate
     * @param string $operation
     */
    public function filterSdate($sdate, $operation = false) {$this->filterField('sdate', $sdate, $operation);}

    /**
     * Get sid
     * @return string
     */
    public function getSid() { return $this->getField('sid');}

    /**
     * Set sid
     * @param string $sid
     */
    public function setSid($sid, $update = false) {$this->setField('sid', $sid, $update);}

    /**
     * Filter sid
     * @param string $sid
     * @param string $operation
     */
    public function filterSid($sid, $operation = false) {$this->filterField('sid', $sid, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('userauth');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XUserAuth
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XUserAuth
     */
    public static function Get($key) {return self::GetObject("XUserAuth", $key);}

}

SQLObject::SetFieldArray('userauth', array('id', 'userid', 'adate', 'sdate', 'sid', 'ip'));
SQLObject::SetPrimaryKey('userauth', 'id');
