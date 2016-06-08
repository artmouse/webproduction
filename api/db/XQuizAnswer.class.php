<?php
/**
 * Class XQuizAnswer is ORM to table quizanswer
 * @author SQLObject
 * @package SQLObject
 */
class XQuizAnswer extends SQLObject {

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
     * Get answer
     * @return string
     */
    public function getAnswer() { return $this->getField('answer');}

    /**
     * Set answer
     * @param string $answer
     */
    public function setAnswer($answer, $update = false) {$this->setField('answer', $answer, $update);}

    /**
     * Filter answer
     * @param string $answer
     * @param string $operation
     */
    public function filterAnswer($answer, $operation = false) {$this->filterField('answer', $answer, $operation);}

    /**
     * Get resultamount
     * @return int
     */
    public function getResultamount() { return $this->getField('resultamount');}

    /**
     * Set resultamount
     * @param int $resultamount
     */
    public function setResultamount($resultamount, $update = false) {$this->setField('resultamount', $resultamount, $update);}

    /**
     * Filter resultamount
     * @param int $resultamount
     * @param string $operation
     */
    public function filterResultamount($resultamount, $operation = false) {$this->filterField('resultamount', $resultamount, $operation);}

    /**
     * Get resultpercent
     * @return float
     */
    public function getResultpercent() { return $this->getField('resultpercent');}

    /**
     * Set resultpercent
     * @param float $resultpercent
     */
    public function setResultpercent($resultpercent, $update = false) {$this->setField('resultpercent', $resultpercent, $update);}

    /**
     * Filter resultpercent
     * @param float $resultpercent
     * @param string $operation
     */
    public function filterResultpercent($resultpercent, $operation = false) {$this->filterField('resultpercent', $resultpercent, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('quizanswer');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XQuizAnswer
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XQuizAnswer
     */
    public static function Get($key) {return self::GetObject("XQuizAnswer", $key);}

}

SQLObject::SetFieldArray('quizanswer', array('id', 'quizid', 'answer', 'resultamount', 'resultpercent'));
SQLObject::SetPrimaryKey('quizanswer', 'id');
