<?php
/**
 * Class XShopEvent is ORM to table shopevent
 * @author SQLObject
 * @package SQLObject
 */
class XShopEvent extends SQLObject {

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
     * Get session
     * @return string
     */
    public function getSession() { return $this->getField('session');}

    /**
     * Set session
     * @param string $session
     */
    public function setSession($session, $update = false) {$this->setField('session', $session, $update);}

    /**
     * Filter session
     * @param string $session
     * @param string $operation
     */
    public function filterSession($session, $operation = false) {$this->filterField('session', $session, $operation);}

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
     * Get channel
     * @return string
     */
    public function getChannel() { return $this->getField('channel');}

    /**
     * Set channel
     * @param string $channel
     */
    public function setChannel($channel, $update = false) {$this->setField('channel', $channel, $update);}

    /**
     * Filter channel
     * @param string $channel
     * @param string $operation
     */
    public function filterChannel($channel, $operation = false) {$this->filterField('channel', $channel, $operation);}

    /**
     * Get sourceid
     * @return int
     */
    public function getSourceid() { return $this->getField('sourceid');}

    /**
     * Set sourceid
     * @param int $sourceid
     */
    public function setSourceid($sourceid, $update = false) {$this->setField('sourceid', $sourceid, $update);}

    /**
     * Filter sourceid
     * @param int $sourceid
     * @param string $operation
     */
    public function filterSourceid($sourceid, $operation = false) {$this->filterField('sourceid', $sourceid, $operation);}

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
     * Get subjectgroup
     * @return string
     */
    public function getSubjectgroup() { return $this->getField('subjectgroup');}

    /**
     * Set subjectgroup
     * @param string $subjectgroup
     */
    public function setSubjectgroup($subjectgroup, $update = false) {$this->setField('subjectgroup', $subjectgroup, $update);}

    /**
     * Filter subjectgroup
     * @param string $subjectgroup
     * @param string $operation
     */
    public function filterSubjectgroup($subjectgroup, $operation = false) {$this->filterField('subjectgroup', $subjectgroup, $operation);}

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
     * Get file
     * @return string
     */
    public function getFile() { return $this->getField('file');}

    /**
     * Set file
     * @param string $file
     */
    public function setFile($file, $update = false) {$this->setField('file', $file, $update);}

    /**
     * Filter file
     * @param string $file
     * @param string $operation
     */
    public function filterFile($file, $operation = false) {$this->filterField('file', $file, $operation);}

    /**
     * Get location
     * @return string
     */
    public function getLocation() { return $this->getField('location');}

    /**
     * Set location
     * @param string $location
     */
    public function setLocation($location, $update = false) {$this->setField('location', $location, $update);}

    /**
     * Filter location
     * @param string $location
     * @param string $operation
     */
    public function filterLocation($location, $operation = false) {$this->filterField('location', $location, $operation);}

    /**
     * Get duration
     * @return int
     */
    public function getDuration() { return $this->getField('duration');}

    /**
     * Set duration
     * @param int $duration
     */
    public function setDuration($duration, $update = false) {$this->setField('duration', $duration, $update);}

    /**
     * Filter duration
     * @param int $duration
     * @param string $operation
     */
    public function filterDuration($duration, $operation = false) {$this->filterField('duration', $duration, $operation);}

    /**
     * Get status
     * @return string
     */
    public function getStatus() { return $this->getField('status');}

    /**
     * Set status
     * @param string $status
     */
    public function setStatus($status, $update = false) {$this->setField('status', $status, $update);}

    /**
     * Filter status
     * @param string $status
     * @param string $operation
     */
    public function filterStatus($status, $operation = false) {$this->filterField('status', $status, $operation);}

    /**
     * Get hidden
     * @return int
     */
    public function getHidden() { return $this->getField('hidden');}

    /**
     * Set hidden
     * @param int $hidden
     */
    public function setHidden($hidden, $update = false) {$this->setField('hidden', $hidden, $update);}

    /**
     * Filter hidden
     * @param int $hidden
     * @param string $operation
     */
    public function filterHidden($hidden, $operation = false) {$this->filterField('hidden', $hidden, $operation);}

    /**
     * Get hash
     * @return string
     */
    public function getHash() { return $this->getField('hash');}

    /**
     * Set hash
     * @param string $hash
     */
    public function setHash($hash, $update = false) {$this->setField('hash', $hash, $update);}

    /**
     * Filter hash
     * @param string $hash
     * @param string $operation
     */
    public function filterHash($hash, $operation = false) {$this->filterField('hash', $hash, $operation);}

    /**
     * Get direction
     * @return int
     */
    public function getDirection() { return $this->getField('direction');}

    /**
     * Set direction
     * @param int $direction
     */
    public function setDirection($direction, $update = false) {$this->setField('direction', $direction, $update);}

    /**
     * Filter direction
     * @param int $direction
     * @param string $operation
     */
    public function filterDirection($direction, $operation = false) {$this->filterField('direction', $direction, $operation);}

    /**
     * Get replyid
     * @return int
     */
    public function getReplyid() { return $this->getField('replyid');}

    /**
     * Set replyid
     * @param int $replyid
     */
    public function setReplyid($replyid, $update = false) {$this->setField('replyid', $replyid, $update);}

    /**
     * Filter replyid
     * @param int $replyid
     * @param string $operation
     */
    public function filterReplyid($replyid, $operation = false) {$this->filterField('replyid', $replyid, $operation);}

    /**
     * Get replydate
     * @return string
     */
    public function getReplydate() { return $this->getField('replydate');}

    /**
     * Set replydate
     * @param string $replydate
     */
    public function setReplydate($replydate, $update = false) {$this->setField('replydate', $replydate, $update);}

    /**
     * Filter replydate
     * @param string $replydate
     * @param string $operation
     */
    public function filterReplydate($replydate, $operation = false) {$this->filterField('replydate', $replydate, $operation);}

    /**
     * Get rating
     * @return int
     */
    public function getRating() { return $this->getField('rating');}

    /**
     * Set rating
     * @param int $rating
     */
    public function setRating($rating, $update = false) {$this->setField('rating', $rating, $update);}

    /**
     * Filter rating
     * @param int $rating
     * @param string $operation
     */
    public function filterRating($rating, $operation = false) {$this->filterField('rating', $rating, $operation);}

    /**
     * Get fromuserid
     * @return int
     */
    public function getFromuserid() { return $this->getField('fromuserid');}

    /**
     * Set fromuserid
     * @param int $fromuserid
     */
    public function setFromuserid($fromuserid, $update = false) {$this->setField('fromuserid', $fromuserid, $update);}

    /**
     * Filter fromuserid
     * @param int $fromuserid
     * @param string $operation
     */
    public function filterFromuserid($fromuserid, $operation = false) {$this->filterField('fromuserid', $fromuserid, $operation);}

    /**
     * Get touserid
     * @return int
     */
    public function getTouserid() { return $this->getField('touserid');}

    /**
     * Set touserid
     * @param int $touserid
     */
    public function setTouserid($touserid, $update = false) {$this->setField('touserid', $touserid, $update);}

    /**
     * Filter touserid
     * @param int $touserid
     * @param string $operation
     */
    public function filterTouserid($touserid, $operation = false) {$this->filterField('touserid', $touserid, $operation);}

    /**
     * Get mailbox
     * @return string
     */
    public function getMailbox() { return $this->getField('mailbox');}

    /**
     * Set mailbox
     * @param string $mailbox
     */
    public function setMailbox($mailbox, $update = false) {$this->setField('mailbox', $mailbox, $update);}

    /**
     * Filter mailbox
     * @param string $mailbox
     * @param string $operation
     */
    public function filterMailbox($mailbox, $operation = false) {$this->filterField('mailbox', $mailbox, $operation);}

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
        $this->setTablename('shopevent');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopEvent
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopEvent
     */
    public static function Get($key) {return self::GetObject("XShopEvent", $key);}

}

SQLObject::SetFieldArray('shopevent', array('id', 'type', 'cdate', 'session', 'from', 'to', 'channel', 'sourceid', 'subject', 'subjectgroup', 'content', 'file', 'location', 'duration', 'status', 'hidden', 'hash', 'direction', 'replyid', 'replydate', 'rating', 'fromuserid', 'touserid', 'mailbox', 'comment'));
SQLObject::SetPrimaryKey('shopevent', 'id');
