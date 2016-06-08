<?php
/**
 * Class XShopFaq is ORM to table shopfaq
 * @author SQLObject
 * @package SQLObject
 */
class XShopFaq extends SQLObject {

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
     * Get userid
     * @return string
     */
    public function getUserid() { return $this->getField('userid');}

    /**
     * Set userid
     * @param string $userid
     */
    public function setUserid($userid, $update = false) {$this->setField('userid', $userid, $update);}

    /**
     * Filter userid
     * @param string $userid
     * @param string $operation
     */
    public function filterUserid($userid, $operation = false) {$this->filterField('userid', $userid, $operation);}

    /**
     * Get linkkey
     * @return string
     */
    public function getLinkkey() { return $this->getField('linkkey');}

    /**
     * Set linkkey
     * @param string $linkkey
     */
    public function setLinkkey($linkkey, $update = false) {$this->setField('linkkey', $linkkey, $update);}

    /**
     * Filter linkkey
     * @param string $linkkey
     * @param string $operation
     */
    public function filterLinkkey($linkkey, $operation = false) {$this->filterField('linkkey', $linkkey, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopfaq');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopFaq
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopFaq
     */
    public static function Get($key) {return self::GetObject("XShopFaq", $key);}

}

SQLObject::SetFieldArray('shopfaq', array('id', 'question', 'answer', 'cdate', 'userid', 'linkkey'));
SQLObject::SetPrimaryKey('shopfaq', 'id');
