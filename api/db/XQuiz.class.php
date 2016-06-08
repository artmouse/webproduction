<?php
/**
 * Class XQuiz is ORM to table quiz
 * @author SQLObject
 * @package SQLObject
 */
class XQuiz extends SQLObject {

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
     * Get edate
     * @return string
     */
    public function getEdate() { return $this->getField('edate');}

    /**
     * Set edate
     * @param string $edate
     */
    public function setEdate($edate, $update = false) {$this->setField('edate', $edate, $update);}

    /**
     * Filter edate
     * @param string $edate
     * @param string $operation
     */
    public function filterEdate($edate, $operation = false) {$this->filterField('edate', $edate, $operation);}

    /**
     * Get active
     * @return int
     */
    public function getActive() { return $this->getField('active');}

    /**
     * Set active
     * @param int $active
     */
    public function setActive($active, $update = false) {$this->setField('active', $active, $update);}

    /**
     * Filter active
     * @param int $active
     * @param string $operation
     */
    public function filterActive($active, $operation = false) {$this->filterField('active', $active, $operation);}

    /**
     * Get question
     * @return string
     */
    public function getQuestion() { return $this->getField('question');}

    /**
     * Set question
     * @param string $question
     */
    public function setQuestion($question, $update = false) {$this->setField('question', $question, $update);}

    /**
     * Filter question
     * @param string $question
     * @param string $operation
     */
    public function filterQuestion($question, $operation = false) {$this->filterField('question', $question, $operation);}

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
        $this->setTablename('quiz');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XQuiz
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XQuiz
     */
    public static function Get($key) {return self::GetObject("XQuiz", $key);}

}

SQLObject::SetFieldArray('quiz', array('id', 'cdate', 'sdate', 'edate', 'active', 'question', 'type'));
SQLObject::SetPrimaryKey('quiz', 'id');
