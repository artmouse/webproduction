<?php
/**
 * Class XShopDownloadURL is ORM to table shopdownloadurl
 * @author SQLObject
 * @package SQLObject
 */
class XShopDownloadURL extends SQLObject {

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopdownloadurl');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopDownloadURL
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopDownloadURL
     */
    public static function Get($key) {return self::GetObject("XShopDownloadURL", $key);}

}

SQLObject::SetFieldArray('shopdownloadurl', array('id', 'file', 'hash', 'linkkey', 'cdate', 'edate'));
SQLObject::SetPrimaryKey('shopdownloadurl', 'id');
