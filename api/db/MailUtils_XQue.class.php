<?php
/**
 * Class MailUtils_XQue is ORM to table mailutils_que
 * @author SQLObject
 * @package SQLObject
 */
class MailUtils_XQue extends SQLObject {

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
     * Get status
     * @return int
     */
    public function getStatus() { return $this->getField('status');}

    /**
     * Set status
     * @param int $status
     */
    public function setStatus($status, $update = false) {$this->setField('status', $status, $update);}

    /**
     * Filter status
     * @param int $status
     * @param string $operation
     */
    public function filterStatus($status, $operation = false) {$this->filterField('status', $status, $operation);}

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
     * Get pdate
     * @return string
     */
    public function getPdate() { return $this->getField('pdate');}

    /**
     * Set pdate
     * @param string $pdate
     */
    public function setPdate($pdate, $update = false) {$this->setField('pdate', $pdate, $update);}

    /**
     * Filter pdate
     * @param string $pdate
     * @param string $operation
     */
    public function filterPdate($pdate, $operation = false) {$this->filterField('pdate', $pdate, $operation);}

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
     * Get subject
     * @return string
     */
    public function getSubject() { return $this->getField('subject');}

    /**
     * Set subject
     * @param string $subject
     */
    public function setSubject($subject, $update = false) {$this->setField('subject', $subject, $update);}

    /**
     * Filter subject
     * @param string $subject
     * @param string $operation
     */
    public function filterSubject($subject, $operation = false) {$this->filterField('subject', $subject, $operation);}

    /**
     * Get body
     * @return string
     */
    public function getBody() { return $this->getField('body');}

    /**
     * Set body
     * @param string $body
     */
    public function setBody($body, $update = false) {$this->setField('body', $body, $update);}

    /**
     * Filter body
     * @param string $body
     * @param string $operation
     */
    public function filterBody($body, $operation = false) {$this->filterField('body', $body, $operation);}

    /**
     * Get bodytype
     * @return string
     */
    public function getBodytype() { return $this->getField('bodytype');}

    /**
     * Set bodytype
     * @param string $bodytype
     */
    public function setBodytype($bodytype, $update = false) {$this->setField('bodytype', $bodytype, $update);}

    /**
     * Filter bodytype
     * @param string $bodytype
     * @param string $operation
     */
    public function filterBodytype($bodytype, $operation = false) {$this->filterField('bodytype', $bodytype, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('mailutils_que');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return MailUtils_XQue
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return MailUtils_XQue
     */
    public static function Get($key) {return self::GetObject("MailUtils_XQue", $key);}

}

SQLObject::SetFieldArray('mailutils_que', array('id', 'cdate', 'status', 'sdate', 'pdate', 'ip', 'from', 'to', 'subject', 'body', 'bodytype'));
SQLObject::SetPrimaryKey('mailutils_que', 'id');
