<?php
/**
 * Class XShopUserEventPrediction is ORM to table shopusereventprediction
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserEventPrediction extends SQLObject {

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
     * Get probablity
     * @return float
     */
    public function getProbablity() { return $this->getField('probablity');}

    /**
     * Set probablity
     * @param float $probablity
     */
    public function setProbablity($probablity, $update = false) {$this->setField('probablity', $probablity, $update);}

    /**
     * Filter probablity
     * @param float $probablity
     * @param string $operation
     */
    public function filterProbablity($probablity, $operation = false) {$this->filterField('probablity', $probablity, $operation);}

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
        $this->setTablename('shopusereventprediction');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserEventPrediction
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserEventPrediction
     */
    public static function Get($key) {return self::GetObject("XShopUserEventPrediction", $key);}

}

SQLObject::SetFieldArray('shopusereventprediction', array('id', 'userid', 'cdate', 'pdate', 'probablity', 'comment'));
SQLObject::SetPrimaryKey('shopusereventprediction', 'id');
