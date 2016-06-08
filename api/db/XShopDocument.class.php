<?php
/**
 * Class XShopDocument is ORM to table shopdocument
 * @author SQLObject
 * @package SQLObject
 */
class XShopDocument extends SQLObject {

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
     * Get number
     * @return string
     */
    public function getNumber() { return $this->getField('number');}

    /**
     * Set number
     * @param string $number
     */
    public function setNumber($number, $update = false) {$this->setField('number', $number, $update);}

    /**
     * Filter number
     * @param string $number
     * @param string $operation
     */
    public function filterNumber($number, $operation = false) {$this->filterField('number', $number, $operation);}

    /**
     * Get name
     * @return string
     */
    public function getName() { return $this->getField('name');}

    /**
     * Set name
     * @param string $name
     */
    public function setName($name, $update = false) {$this->setField('name', $name, $update);}

    /**
     * Filter name
     * @param string $name
     * @param string $operation
     */
    public function filterName($name, $operation = false) {$this->filterField('name', $name, $operation);}

    /**
     * Get contractorid
     * @return int
     */
    public function getContractorid() { return $this->getField('contractorid');}

    /**
     * Set contractorid
     * @param int $contractorid
     */
    public function setContractorid($contractorid, $update = false) {$this->setField('contractorid', $contractorid, $update);}

    /**
     * Filter contractorid
     * @param int $contractorid
     * @param string $operation
     */
    public function filterContractorid($contractorid, $operation = false) {$this->filterField('contractorid', $contractorid, $operation);}

    /**
     * Get templateid
     * @return int
     */
    public function getTemplateid() { return $this->getField('templateid');}

    /**
     * Set templateid
     * @param int $templateid
     */
    public function setTemplateid($templateid, $update = false) {$this->setField('templateid', $templateid, $update);}

    /**
     * Filter templateid
     * @param int $templateid
     * @param string $operation
     */
    public function filterTemplateid($templateid, $operation = false) {$this->filterField('templateid', $templateid, $operation);}

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
     * Get bdate
     * @return string
     */
    public function getBdate() { return $this->getField('bdate');}

    /**
     * Set bdate
     * @param string $bdate
     */
    public function setBdate($bdate, $update = false) {$this->setField('bdate', $bdate, $update);}

    /**
     * Filter bdate
     * @param string $bdate
     * @param string $operation
     */
    public function filterBdate($bdate, $operation = false) {$this->filterField('bdate', $bdate, $operation);}

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
     * Get fileoriginal
     * @return string
     */
    public function getFileoriginal() { return $this->getField('fileoriginal');}

    /**
     * Set fileoriginal
     * @param string $fileoriginal
     */
    public function setFileoriginal($fileoriginal, $update = false) {$this->setField('fileoriginal', $fileoriginal, $update);}

    /**
     * Filter fileoriginal
     * @param string $fileoriginal
     * @param string $operation
     */
    public function filterFileoriginal($fileoriginal, $operation = false) {$this->filterField('fileoriginal', $fileoriginal, $operation);}

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
     * Get deleted
     * @return int
     */
    public function getDeleted() { return $this->getField('deleted');}

    /**
     * Set deleted
     * @param int $deleted
     */
    public function setDeleted($deleted, $update = false) {$this->setField('deleted', $deleted, $update);}

    /**
     * Filter deleted
     * @param int $deleted
     * @param string $operation
     */
    public function filterDeleted($deleted, $operation = false) {$this->filterField('deleted', $deleted, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopdocument');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopDocument
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopDocument
     */
    public static function Get($key) {return self::GetObject("XShopDocument", $key);}

}

SQLObject::SetFieldArray('shopdocument', array('id', 'number', 'name', 'contractorid', 'templateid', 'userid', 'linkkey', 'cdate', 'edate', 'sdate', 'bdate', 'adate', 'fileoriginal', 'file', 'content', 'deleted'));
SQLObject::SetPrimaryKey('shopdocument', 'id');
