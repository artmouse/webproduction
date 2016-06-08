<?php
/**
 * Class XPriceSupplierImportStatus is ORM to table pricesupplierimportstatus
 * @author SQLObject
 * @package SQLObject
 */
class XPriceSupplierImportStatus extends SQLObject {

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
     * Get dateupload
     * @return string
     */
    public function getDateupload() { return $this->getField('dateupload');}

    /**
     * Set dateupload
     * @param string $dateupload
     */
    public function setDateupload($dateupload, $update = false) {$this->setField('dateupload', $dateupload, $update);}

    /**
     * Filter dateupload
     * @param string $dateupload
     * @param string $operation
     */
    public function filterDateupload($dateupload, $operation = false) {$this->filterField('dateupload', $dateupload, $operation);}

    /**
     * Get supplierid
     * @return int
     */
    public function getSupplierid() { return $this->getField('supplierid');}

    /**
     * Set supplierid
     * @param int $supplierid
     */
    public function setSupplierid($supplierid, $update = false) {$this->setField('supplierid', $supplierid, $update);}

    /**
     * Filter supplierid
     * @param int $supplierid
     * @param string $operation
     */
    public function filterSupplierid($supplierid, $operation = false) {$this->filterField('supplierid', $supplierid, $operation);}

    /**
     * Get processed
     * @return int
     */
    public function getProcessed() { return $this->getField('processed');}

    /**
     * Set processed
     * @param int $processed
     */
    public function setProcessed($processed, $update = false) {$this->setField('processed', $processed, $update);}

    /**
     * Filter processed
     * @param int $processed
     * @param string $operation
     */
    public function filterProcessed($processed, $operation = false) {$this->filterField('processed', $processed, $operation);}

    /**
     * Get dateprocessed
     * @return string
     */
    public function getDateprocessed() { return $this->getField('dateprocessed');}

    /**
     * Set dateprocessed
     * @param string $dateprocessed
     */
    public function setDateprocessed($dateprocessed, $update = false) {$this->setField('dateprocessed', $dateprocessed, $update);}

    /**
     * Filter dateprocessed
     * @param string $dateprocessed
     * @param string $operation
     */
    public function filterDateprocessed($dateprocessed, $operation = false) {$this->filterField('dateprocessed', $dateprocessed, $operation);}

    /**
     * Get resultfail
     * @return int
     */
    public function getResultfail() { return $this->getField('resultfail');}

    /**
     * Set resultfail
     * @param int $resultfail
     */
    public function setResultfail($resultfail, $update = false) {$this->setField('resultfail', $resultfail, $update);}

    /**
     * Filter resultfail
     * @param int $resultfail
     * @param string $operation
     */
    public function filterResultfail($resultfail, $operation = false) {$this->filterField('resultfail', $resultfail, $operation);}

    /**
     * Get resultsuccess
     * @return int
     */
    public function getResultsuccess() { return $this->getField('resultsuccess');}

    /**
     * Set resultsuccess
     * @param int $resultsuccess
     */
    public function setResultsuccess($resultsuccess, $update = false) {$this->setField('resultsuccess', $resultsuccess, $update);}

    /**
     * Filter resultsuccess
     * @param int $resultsuccess
     * @param string $operation
     */
    public function filterResultsuccess($resultsuccess, $operation = false) {$this->filterField('resultsuccess', $resultsuccess, $operation);}

    /**
     * Get resultadded
     * @return int
     */
    public function getResultadded() { return $this->getField('resultadded');}

    /**
     * Set resultadded
     * @param int $resultadded
     */
    public function setResultadded($resultadded, $update = false) {$this->setField('resultadded', $resultadded, $update);}

    /**
     * Filter resultadded
     * @param int $resultadded
     * @param string $operation
     */
    public function filterResultadded($resultadded, $operation = false) {$this->filterField('resultadded', $resultadded, $operation);}

    /**
     * Get resulttext
     * @return string
     */
    public function getResulttext() { return $this->getField('resulttext');}

    /**
     * Set resulttext
     * @param string $resulttext
     */
    public function setResulttext($resulttext, $update = false) {$this->setField('resulttext', $resulttext, $update);}

    /**
     * Filter resulttext
     * @param string $resulttext
     * @param string $operation
     */
    public function filterResulttext($resulttext, $operation = false) {$this->filterField('resulttext', $resulttext, $operation);}

    /**
     * Get pricenamemd5
     * @return string
     */
    public function getPricenamemd5() { return $this->getField('pricenamemd5');}

    /**
     * Set pricenamemd5
     * @param string $pricenamemd5
     */
    public function setPricenamemd5($pricenamemd5, $update = false) {$this->setField('pricenamemd5', $pricenamemd5, $update);}

    /**
     * Filter pricenamemd5
     * @param string $pricenamemd5
     * @param string $operation
     */
    public function filterPricenamemd5($pricenamemd5, $operation = false) {$this->filterField('pricenamemd5', $pricenamemd5, $operation);}

    /**
     * Get priceid
     * @return int
     */
    public function getPriceid() { return $this->getField('priceid');}

    /**
     * Set priceid
     * @param int $priceid
     */
    public function setPriceid($priceid, $update = false) {$this->setField('priceid', $priceid, $update);}

    /**
     * Filter priceid
     * @param int $priceid
     * @param string $operation
     */
    public function filterPriceid($priceid, $operation = false) {$this->filterField('priceid', $priceid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('pricesupplierimportstatus');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XPriceSupplierImportStatus
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XPriceSupplierImportStatus
     */
    public static function Get($key) {return self::GetObject("XPriceSupplierImportStatus", $key);}

}

SQLObject::SetFieldArray('pricesupplierimportstatus', array('id', 'dateupload', 'supplierid', 'processed', 'dateprocessed', 'resultfail', 'resultsuccess', 'resultadded', 'resulttext', 'pricenamemd5', 'priceid'));
SQLObject::SetPrimaryKey('pricesupplierimportstatus', 'id');
