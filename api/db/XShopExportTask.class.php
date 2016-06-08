<?php
/**
 * Class XShopExportTask is ORM to table shopexporttask
 * @author SQLObject
 * @package SQLObject
 */
class XShopExportTask extends SQLObject {

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
     * Get emails
     * @return string
     */
    public function getEmails() { return $this->getField('emails');}

    /**
     * Set emails
     * @param string $emails
     */
    public function setEmails($emails, $update = false) {$this->setField('emails', $emails, $update);}

    /**
     * Filter emails
     * @param string $emails
     * @param string $operation
     */
    public function filterEmails($emails, $operation = false) {$this->filterField('emails', $emails, $operation);}

    /**
     * Get exportclassname
     * @return string
     */
    public function getExportclassname() { return $this->getField('exportclassname');}

    /**
     * Set exportclassname
     * @param string $exportclassname
     */
    public function setExportclassname($exportclassname, $update = false) {$this->setField('exportclassname', $exportclassname, $update);}

    /**
     * Filter exportclassname
     * @param string $exportclassname
     * @param string $operation
     */
    public function filterExportclassname($exportclassname, $operation = false) {$this->filterField('exportclassname', $exportclassname, $operation);}

    /**
     * Get excludefields
     * @return string
     */
    public function getExcludefields() { return $this->getField('excludefields');}

    /**
     * Set excludefields
     * @param string $excludefields
     */
    public function setExcludefields($excludefields, $update = false) {$this->setField('excludefields', $excludefields, $update);}

    /**
     * Filter excludefields
     * @param string $excludefields
     * @param string $operation
     */
    public function filterExcludefields($excludefields, $operation = false) {$this->filterField('excludefields', $excludefields, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopexporttask');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopExportTask
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopExportTask
     */
    public static function Get($key) {return self::GetObject("XShopExportTask", $key);}

}

SQLObject::SetFieldArray('shopexporttask', array('id', 'cdate', 'pdate', 'userid', 'comment', 'emails', 'exportclassname', 'excludefields'));
SQLObject::SetPrimaryKey('shopexporttask', 'id');
