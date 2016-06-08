<?php
/**
 * Class XQuizUserAnswer is ORM to table quizuseranswer
 * @author SQLObject
 * @package SQLObject
 */
class XQuizUserAnswer extends SQLObject {

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
     * Get userip
     * @return string
     */
    public function getUserip() { return $this->getField('userip');}

    /**
     * Set userip
     * @param string $userip
     */
    public function setUserip($userip, $update = false) {$this->setField('userip', $userip, $update);}

    /**
     * Filter userip
     * @param string $userip
     * @param string $operation
     */
    public function filterUserip($userip, $operation = false) {$this->filterField('userip', $userip, $operation);}

    /**
     * Get quizid
     * @return int
     */
    public function getQuizid() { return $this->getField('quizid');}

    /**
     * Set quizid
     * @param int $quizid
     */
    public function setQuizid($quizid, $update = false) {$this->setField('quizid', $quizid, $update);}

    /**
     * Filter quizid
     * @param int $quizid
     * @param string $operation
     */
    public function filterQuizid($quizid, $operation = false) {$this->filterField('quizid', $quizid, $operation);}

    /**
     * Get answerid
     * @return int
     */
    public function getAnswerid() { return $this->getField('answerid');}

    /**
     * Set answerid
     * @param int $answerid
     */
    public function setAnswerid($answerid, $update = false) {$this->setField('answerid', $answerid, $update);}

    /**
     * Filter answerid
     * @param int $answerid
     * @param string $operation
     */
    public function filterAnswerid($answerid, $operation = false) {$this->filterField('answerid', $answerid, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('quizuseranswer');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XQuizUserAnswer
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XQuizUserAnswer
     */
    public static function Get($key) {return self::GetObject("XQuizUserAnswer", $key);}

}

SQLObject::SetFieldArray('quizuseranswer', array('id', 'userid', 'userip', 'quizid', 'answerid', 'cdate'));
SQLObject::SetPrimaryKey('quizuseranswer', 'id');
