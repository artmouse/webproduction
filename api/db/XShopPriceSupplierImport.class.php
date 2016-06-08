<?php
/**
 * Class XShopPriceSupplierImport is ORM to table shoppricesupplierimport
 * @author SQLObject
 * @package SQLObject
 */
class XShopPriceSupplierImport extends SQLObject {

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
     * Get step
     * @return int
     */
    public function getStep() { return $this->getField('step');}

    /**
     * Set step
     * @param int $step
     */
    public function setStep($step, $update = false) {$this->setField('step', $step, $update);}

    /**
     * Filter step
     * @param int $step
     * @param string $operation
     */
    public function filterStep($step, $operation = false) {$this->filterField('step', $step, $operation);}

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
     * Get suppliercurrencyid
     * @return int
     */
    public function getSuppliercurrencyid() { return $this->getField('suppliercurrencyid');}

    /**
     * Set suppliercurrencyid
     * @param int $suppliercurrencyid
     */
    public function setSuppliercurrencyid($suppliercurrencyid, $update = false) {$this->setField('suppliercurrencyid', $suppliercurrencyid, $update);}

    /**
     * Filter suppliercurrencyid
     * @param int $suppliercurrencyid
     * @param string $operation
     */
    public function filterSuppliercurrencyid($suppliercurrencyid, $operation = false) {$this->filterField('suppliercurrencyid', $suppliercurrencyid, $operation);}

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
     * Get filetype
     * @return string
     */
    public function getFiletype() { return $this->getField('filetype');}

    /**
     * Set filetype
     * @param string $filetype
     */
    public function setFiletype($filetype, $update = false) {$this->setField('filetype', $filetype, $update);}

    /**
     * Filter filetype
     * @param string $filetype
     * @param string $operation
     */
    public function filterFiletype($filetype, $operation = false) {$this->filterField('filetype', $filetype, $operation);}

    /**
     * Get fileencoding
     * @return string
     */
    public function getFileencoding() { return $this->getField('fileencoding');}

    /**
     * Set fileencoding
     * @param string $fileencoding
     */
    public function setFileencoding($fileencoding, $update = false) {$this->setField('fileencoding', $fileencoding, $update);}

    /**
     * Filter fileencoding
     * @param string $fileencoding
     * @param string $operation
     */
    public function filterFileencoding($fileencoding, $operation = false) {$this->filterField('fileencoding', $fileencoding, $operation);}

    /**
     * Get columncode
     * @return string
     */
    public function getColumncode() { return $this->getField('columncode');}

    /**
     * Set columncode
     * @param string $columncode
     */
    public function setColumncode($columncode, $update = false) {$this->setField('columncode', $columncode, $update);}

    /**
     * Filter columncode
     * @param string $columncode
     * @param string $operation
     */
    public function filterColumncode($columncode, $operation = false) {$this->filterField('columncode', $columncode, $operation);}

    /**
     * Get columnname
     * @return string
     */
    public function getColumnname() { return $this->getField('columnname');}

    /**
     * Set columnname
     * @param string $columnname
     */
    public function setColumnname($columnname, $update = false) {$this->setField('columnname', $columnname, $update);}

    /**
     * Filter columnname
     * @param string $columnname
     * @param string $operation
     */
    public function filterColumnname($columnname, $operation = false) {$this->filterField('columnname', $columnname, $operation);}

    /**
     * Get columnarticul
     * @return string
     */
    public function getColumnarticul() { return $this->getField('columnarticul');}

    /**
     * Set columnarticul
     * @param string $columnarticul
     */
    public function setColumnarticul($columnarticul, $update = false) {$this->setField('columnarticul', $columnarticul, $update);}

    /**
     * Filter columnarticul
     * @param string $columnarticul
     * @param string $operation
     */
    public function filterColumnarticul($columnarticul, $operation = false) {$this->filterField('columnarticul', $columnarticul, $operation);}

    /**
     * Get columnprice
     * @return int
     */
    public function getColumnprice() { return $this->getField('columnprice');}

    /**
     * Set columnprice
     * @param int $columnprice
     */
    public function setColumnprice($columnprice, $update = false) {$this->setField('columnprice', $columnprice, $update);}

    /**
     * Filter columnprice
     * @param int $columnprice
     * @param string $operation
     */
    public function filterColumnprice($columnprice, $operation = false) {$this->filterField('columnprice', $columnprice, $operation);}

    /**
     * Get columnminretail
     * @return int
     */
    public function getColumnminretail() { return $this->getField('columnminretail');}

    /**
     * Set columnminretail
     * @param int $columnminretail
     */
    public function setColumnminretail($columnminretail, $update = false) {$this->setField('columnminretail', $columnminretail, $update);}

    /**
     * Filter columnminretail
     * @param int $columnminretail
     * @param string $operation
     */
    public function filterColumnminretail($columnminretail, $operation = false) {$this->filterField('columnminretail', $columnminretail, $operation);}

    /**
     * Get columnminretail_cur_id
     * @return int
     */
    public function getColumnminretail_cur_id() { return $this->getField('columnminretail_cur_id');}

    /**
     * Set columnminretail_cur_id
     * @param int $columnminretail_cur_id
     */
    public function setColumnminretail_cur_id($columnminretail_cur_id, $update = false) {$this->setField('columnminretail_cur_id', $columnminretail_cur_id, $update);}

    /**
     * Filter columnminretail_cur_id
     * @param int $columnminretail_cur_id
     * @param string $operation
     */
    public function filterColumnminretail_cur_id($columnminretail_cur_id, $operation = false) {$this->filterField('columnminretail_cur_id', $columnminretail_cur_id, $operation);}

    /**
     * Get columnrecommretail
     * @return int
     */
    public function getColumnrecommretail() { return $this->getField('columnrecommretail');}

    /**
     * Set columnrecommretail
     * @param int $columnrecommretail
     */
    public function setColumnrecommretail($columnrecommretail, $update = false) {$this->setField('columnrecommretail', $columnrecommretail, $update);}

    /**
     * Filter columnrecommretail
     * @param int $columnrecommretail
     * @param string $operation
     */
    public function filterColumnrecommretail($columnrecommretail, $operation = false) {$this->filterField('columnrecommretail', $columnrecommretail, $operation);}

    /**
     * Get columnrecommretail_cur_id
     * @return int
     */
    public function getColumnrecommretail_cur_id() { return $this->getField('columnrecommretail_cur_id');}

    /**
     * Set columnrecommretail_cur_id
     * @param int $columnrecommretail_cur_id
     */
    public function setColumnrecommretail_cur_id($columnrecommretail_cur_id, $update = false) {$this->setField('columnrecommretail_cur_id', $columnrecommretail_cur_id, $update);}

    /**
     * Filter columnrecommretail_cur_id
     * @param int $columnrecommretail_cur_id
     * @param string $operation
     */
    public function filterColumnrecommretail_cur_id($columnrecommretail_cur_id, $operation = false) {$this->filterField('columnrecommretail_cur_id', $columnrecommretail_cur_id, $operation);}

    /**
     * Get columnavail
     * @return string
     */
    public function getColumnavail() { return $this->getField('columnavail');}

    /**
     * Set columnavail
     * @param string $columnavail
     */
    public function setColumnavail($columnavail, $update = false) {$this->setField('columnavail', $columnavail, $update);}

    /**
     * Filter columnavail
     * @param string $columnavail
     * @param string $operation
     */
    public function filterColumnavail($columnavail, $operation = false) {$this->filterField('columnavail', $columnavail, $operation);}

    /**
     * Get columncomment
     * @return string
     */
    public function getColumncomment() { return $this->getField('columncomment');}

    /**
     * Set columncomment
     * @param string $columncomment
     */
    public function setColumncomment($columncomment, $update = false) {$this->setField('columncomment', $columncomment, $update);}

    /**
     * Filter columncomment
     * @param string $columncomment
     * @param string $operation
     */
    public function filterColumncomment($columncomment, $operation = false) {$this->filterField('columncomment', $columncomment, $operation);}

    /**
     * Get datelifeto
     * @return string
     */
    public function getDatelifeto() { return $this->getField('datelifeto');}

    /**
     * Set datelifeto
     * @param string $datelifeto
     */
    public function setDatelifeto($datelifeto, $update = false) {$this->setField('datelifeto', $datelifeto, $update);}

    /**
     * Filter datelifeto
     * @param string $datelifeto
     * @param string $operation
     */
    public function filterDatelifeto($datelifeto, $operation = false) {$this->filterField('datelifeto', $datelifeto, $operation);}

    /**
     * Get columndiscount
     * @return int
     */
    public function getColumndiscount() { return $this->getField('columndiscount');}

    /**
     * Set columndiscount
     * @param int $columndiscount
     */
    public function setColumndiscount($columndiscount, $update = false) {$this->setField('columndiscount', $columndiscount, $update);}

    /**
     * Filter columndiscount
     * @param int $columndiscount
     * @param string $operation
     */
    public function filterColumndiscount($columndiscount, $operation = false) {$this->filterField('columndiscount', $columndiscount, $operation);}

    /**
     * Get optionarray
     * @return string
     */
    public function getOptionarray() { return $this->getField('optionarray');}

    /**
     * Set optionarray
     * @param string $optionarray
     */
    public function setOptionarray($optionarray, $update = false) {$this->setField('optionarray', $optionarray, $update);}

    /**
     * Filter optionarray
     * @param string $optionarray
     * @param string $operation
     */
    public function filterOptionarray($optionarray, $operation = false) {$this->filterField('optionarray', $optionarray, $operation);}

    /**
     * Get searchnameprecision
     * @return int
     */
    public function getSearchnameprecision() { return $this->getField('searchnameprecision');}

    /**
     * Set searchnameprecision
     * @param int $searchnameprecision
     */
    public function setSearchnameprecision($searchnameprecision, $update = false) {$this->setField('searchnameprecision', $searchnameprecision, $update);}

    /**
     * Filter searchnameprecision
     * @param int $searchnameprecision
     * @param string $operation
     */
    public function filterSearchnameprecision($searchnameprecision, $operation = false) {$this->filterField('searchnameprecision', $searchnameprecision, $operation);}

    /**
     * Get lastpart
     * @return int
     */
    public function getLastpart() { return $this->getField('lastpart');}

    /**
     * Set lastpart
     * @param int $lastpart
     */
    public function setLastpart($lastpart, $update = false) {$this->setField('lastpart', $lastpart, $update);}

    /**
     * Filter lastpart
     * @param int $lastpart
     * @param string $operation
     */
    public function filterLastpart($lastpart, $operation = false) {$this->filterField('lastpart', $lastpart, $operation);}

    /**
     * Get firstpart
     * @return int
     */
    public function getFirstpart() { return $this->getField('firstpart');}

    /**
     * Set firstpart
     * @param int $firstpart
     */
    public function setFirstpart($firstpart, $update = false) {$this->setField('firstpart', $firstpart, $update);}

    /**
     * Filter firstpart
     * @param int $firstpart
     * @param string $operation
     */
    public function filterFirstpart($firstpart, $operation = false) {$this->filterField('firstpart', $firstpart, $operation);}

    /**
     * Get processed_lists
     * @return string
     */
    public function getProcessed_lists() { return $this->getField('processed_lists');}

    /**
     * Set processed_lists
     * @param string $processed_lists
     */
    public function setProcessed_lists($processed_lists, $update = false) {$this->setField('processed_lists', $processed_lists, $update);}

    /**
     * Filter processed_lists
     * @param string $processed_lists
     * @param string $operation
     */
    public function filterProcessed_lists($processed_lists, $operation = false) {$this->filterField('processed_lists', $processed_lists, $operation);}

    /**
     * Get convert
     * @return int
     */
    public function getConvert() { return $this->getField('convert');}

    /**
     * Set convert
     * @param int $convert
     */
    public function setConvert($convert, $update = false) {$this->setField('convert', $convert, $update);}

    /**
     * Filter convert
     * @param int $convert
     * @param string $operation
     */
    public function filterConvert($convert, $operation = false) {$this->filterField('convert', $convert, $operation);}

    /**
     * Get xlssheet
     * @return int
     */
    public function getXlssheet() { return $this->getField('xlssheet');}

    /**
     * Set xlssheet
     * @param int $xlssheet
     */
    public function setXlssheet($xlssheet, $update = false) {$this->setField('xlssheet', $xlssheet, $update);}

    /**
     * Filter xlssheet
     * @param int $xlssheet
     * @param string $operation
     */
    public function filterXlssheet($xlssheet, $operation = false) {$this->filterField('xlssheet', $xlssheet, $operation);}

    /**
     * Get pricename
     * @return string
     */
    public function getPricename() { return $this->getField('pricename');}

    /**
     * Set pricename
     * @param string $pricename
     */
    public function setPricename($pricename, $update = false) {$this->setField('pricename', $pricename, $update);}

    /**
     * Filter pricename
     * @param string $pricename
     * @param string $operation
     */
    public function filterPricename($pricename, $operation = false) {$this->filterField('pricename', $pricename, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoppricesupplierimport');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopPriceSupplierImport
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopPriceSupplierImport
     */
    public static function Get($key) {return self::GetObject("XShopPriceSupplierImport", $key);}

}

SQLObject::SetFieldArray('shoppricesupplierimport', array('id', 'cdate', 'pdate', 'step', 'supplierid', 'suppliercurrencyid', 'file', 'filetype', 'fileencoding', 'columncode', 'columnname', 'columnarticul', 'columnprice', 'columnminretail', 'columnminretail_cur_id', 'columnrecommretail', 'columnrecommretail_cur_id', 'columnavail', 'columncomment', 'datelifeto', 'columndiscount', 'optionarray', 'searchnameprecision', 'lastpart', 'firstpart', 'processed_lists', 'convert', 'xlssheet', 'pricename'));
SQLObject::SetPrimaryKey('shoppricesupplierimport', 'id');
