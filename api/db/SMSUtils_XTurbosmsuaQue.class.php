<?php
/**
 * Class SMSUtils_XTurbosmsuaQue is ORM to table smsutils_que
 * @author SQLObject
 * @package SQLObject
 */
class SMSUtils_XTurbosmsuaQue extends SQLObject {

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
     * Get sender
     * @return string
     */
    public function getSender() { return $this->getField('sender');}

    /**
     * Set sender
     * @param string $sender
     */
    public function setSender($sender, $update = false) {$this->setField('sender', $sender, $update);}

    /**
     * Filter sender
     * @param string $sender
     * @param string $operation
     */
    public function filterSender($sender, $operation = false) {$this->filterField('sender', $sender, $operation);}

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
     * Get result
     * @return string
     */
    public function getResult() { return $this->getField('result');}

    /**
     * Set result
     * @param string $result
     */
    public function setResult($result, $update = false) {$this->setField('result', $result, $update);}

    /**
     * Filter result
     * @param string $result
     * @param string $operation
     */
    public function filterResult($result, $operation = false) {$this->filterField('result', $result, $operation);}

    /**
     * Get trycnt
     * @return int
     */
    public function getTrycnt() { return $this->getField('trycnt');}

    /**
     * Set trycnt
     * @param int $trycnt
     */
    public function setTrycnt($trycnt, $update = false) {$this->setField('trycnt', $trycnt, $update);}

    /**
     * Filter trycnt
     * @param int $trycnt
     * @param string $operation
     */
    public function filterTrycnt($trycnt, $operation = false) {$this->filterField('trycnt', $trycnt, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('smsutils_que');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return SMSUtils_XTurbosmsuaQue
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return SMSUtils_XTurbosmsuaQue
     */
    public static function Get($key) {return self::GetObject("SMSUtils_XTurbosmsuaQue", $key);}

}

SQLObject::SetFieldArray('smsutils_que', array('id', 'cdate', 'status', 'pdate', 'sender', 'to', 'content', 'result', 'trycnt'));
SQLObject::SetPrimaryKey('smsutils_que', 'id');
