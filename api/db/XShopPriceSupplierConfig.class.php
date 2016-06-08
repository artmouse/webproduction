<?php
/**
 * Class XShopPriceSupplierConfig is ORM to table shoppricesupplierconfig
 * @author SQLObject
 * @package SQLObject
 */
class XShopPriceSupplierConfig extends SQLObject {

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
     * @return string
     */
    public function getColumnprice() { return $this->getField('columnprice');}

    /**
     * Set columnprice
     * @param string $columnprice
     */
    public function setColumnprice($columnprice, $update = false) {$this->setField('columnprice', $columnprice, $update);}

    /**
     * Filter columnprice
     * @param string $columnprice
     * @param string $operation
     */
    public function filterColumnprice($columnprice, $operation = false) {$this->filterField('columnprice', $columnprice, $operation);}

    /**
     * Get columnminretail
     * @return string
     */
    public function getColumnminretail() { return $this->getField('columnminretail');}

    /**
     * Set columnminretail
     * @param string $columnminretail
     */
    public function setColumnminretail($columnminretail, $update = false) {$this->setField('columnminretail', $columnminretail, $update);}

    /**
     * Filter columnminretail
     * @param string $columnminretail
     * @param string $operation
     */
    public function filterColumnminretail($columnminretail, $operation = false) {$this->filterField('columnminretail', $columnminretail, $operation);}

    /**
     * Get minretail_cur_id
     * @return int
     */
    public function getMinretail_cur_id() { return $this->getField('minretail_cur_id');}

    /**
     * Set minretail_cur_id
     * @param int $minretail_cur_id
     */
    public function setMinretail_cur_id($minretail_cur_id, $update = false) {$this->setField('minretail_cur_id', $minretail_cur_id, $update);}

    /**
     * Filter minretail_cur_id
     * @param int $minretail_cur_id
     * @param string $operation
     */
    public function filterMinretail_cur_id($minretail_cur_id, $operation = false) {$this->filterField('minretail_cur_id', $minretail_cur_id, $operation);}

    /**
     * Get columnrecommretail
     * @return string
     */
    public function getColumnrecommretail() { return $this->getField('columnrecommretail');}

    /**
     * Set columnrecommretail
     * @param string $columnrecommretail
     */
    public function setColumnrecommretail($columnrecommretail, $update = false) {$this->setField('columnrecommretail', $columnrecommretail, $update);}

    /**
     * Filter columnrecommretail
     * @param string $columnrecommretail
     * @param string $operation
     */
    public function filterColumnrecommretail($columnrecommretail, $operation = false) {$this->filterField('columnrecommretail', $columnrecommretail, $operation);}

    /**
     * Get recommretail_cur_id
     * @return int
     */
    public function getRecommretail_cur_id() { return $this->getField('recommretail_cur_id');}

    /**
     * Set recommretail_cur_id
     * @param int $recommretail_cur_id
     */
    public function setRecommretail_cur_id($recommretail_cur_id, $update = false) {$this->setField('recommretail_cur_id', $recommretail_cur_id, $update);}

    /**
     * Filter recommretail_cur_id
     * @param int $recommretail_cur_id
     * @param string $operation
     */
    public function filterRecommretail_cur_id($recommretail_cur_id, $operation = false) {$this->filterField('recommretail_cur_id', $recommretail_cur_id, $operation);}

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
     * Get columndiscount
     * @return string
     */
    public function getColumndiscount() { return $this->getField('columndiscount');}

    /**
     * Set columndiscount
     * @param string $columndiscount
     */
    public function setColumndiscount($columndiscount, $update = false) {$this->setField('columndiscount', $columndiscount, $update);}

    /**
     * Filter columndiscount
     * @param string $columndiscount
     * @param string $operation
     */
    public function filterColumndiscount($columndiscount, $operation = false) {$this->filterField('columndiscount', $columndiscount, $operation);}

    /**
     * Get limitfrom
     * @return string
     */
    public function getLimitfrom() { return $this->getField('limitfrom');}

    /**
     * Set limitfrom
     * @param string $limitfrom
     */
    public function setLimitfrom($limitfrom, $update = false) {$this->setField('limitfrom', $limitfrom, $update);}

    /**
     * Filter limitfrom
     * @param string $limitfrom
     * @param string $operation
     */
    public function filterLimitfrom($limitfrom, $operation = false) {$this->filterField('limitfrom', $limitfrom, $operation);}

    /**
     * Get limitto
     * @return string
     */
    public function getLimitto() { return $this->getField('limitto');}

    /**
     * Set limitto
     * @param string $limitto
     */
    public function setLimitto($limitto, $update = false) {$this->setField('limitto', $limitto, $update);}

    /**
     * Filter limitto
     * @param string $limitto
     * @param string $operation
     */
    public function filterLimitto($limitto, $operation = false) {$this->filterField('limitto', $limitto, $operation);}

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
     * Get issearchcode
     * @return int
     */
    public function getIssearchcode() { return $this->getField('issearchcode');}

    /**
     * Set issearchcode
     * @param int $issearchcode
     */
    public function setIssearchcode($issearchcode, $update = false) {$this->setField('issearchcode', $issearchcode, $update);}

    /**
     * Filter issearchcode
     * @param int $issearchcode
     * @param string $operation
     */
    public function filterIssearchcode($issearchcode, $operation = false) {$this->filterField('issearchcode', $issearchcode, $operation);}

    /**
     * Get issearchcodethis
     * @return int
     */
    public function getIssearchcodethis() { return $this->getField('issearchcodethis');}

    /**
     * Set issearchcodethis
     * @param int $issearchcodethis
     */
    public function setIssearchcodethis($issearchcodethis, $update = false) {$this->setField('issearchcodethis', $issearchcodethis, $update);}

    /**
     * Filter issearchcodethis
     * @param int $issearchcodethis
     * @param string $operation
     */
    public function filterIssearchcodethis($issearchcodethis, $operation = false) {$this->filterField('issearchcodethis', $issearchcodethis, $operation);}

    /**
     * Get issearchcodemd5
     * @return int
     */
    public function getIssearchcodemd5() { return $this->getField('issearchcodemd5');}

    /**
     * Set issearchcodemd5
     * @param int $issearchcodemd5
     */
    public function setIssearchcodemd5($issearchcodemd5, $update = false) {$this->setField('issearchcodemd5', $issearchcodemd5, $update);}

    /**
     * Filter issearchcodemd5
     * @param int $issearchcodemd5
     * @param string $operation
     */
    public function filterIssearchcodemd5($issearchcodemd5, $operation = false) {$this->filterField('issearchcodemd5', $issearchcodemd5, $operation);}

    /**
     * Get issearchname
     * @return int
     */
    public function getIssearchname() { return $this->getField('issearchname');}

    /**
     * Set issearchname
     * @param int $issearchname
     */
    public function setIssearchname($issearchname, $update = false) {$this->setField('issearchname', $issearchname, $update);}

    /**
     * Filter issearchname
     * @param int $issearchname
     * @param string $operation
     */
    public function filterIssearchname($issearchname, $operation = false) {$this->filterField('issearchname', $issearchname, $operation);}

    /**
     * Get issearchnameprecision
     * @return int
     */
    public function getIssearchnameprecision() { return $this->getField('issearchnameprecision');}

    /**
     * Set issearchnameprecision
     * @param int $issearchnameprecision
     */
    public function setIssearchnameprecision($issearchnameprecision, $update = false) {$this->setField('issearchnameprecision', $issearchnameprecision, $update);}

    /**
     * Filter issearchnameprecision
     * @param int $issearchnameprecision
     * @param string $operation
     */
    public function filterIssearchnameprecision($issearchnameprecision, $operation = false) {$this->filterField('issearchnameprecision', $issearchnameprecision, $operation);}

    /**
     * Get issearcharticul
     * @return int
     */
    public function getIssearcharticul() { return $this->getField('issearcharticul');}

    /**
     * Set issearcharticul
     * @param int $issearcharticul
     */
    public function setIssearcharticul($issearcharticul, $update = false) {$this->setField('issearcharticul', $issearcharticul, $update);}

    /**
     * Filter issearcharticul
     * @param int $issearcharticul
     * @param string $operation
     */
    public function filterIssearcharticul($issearcharticul, $operation = false) {$this->filterField('issearcharticul', $issearcharticul, $operation);}

    /**
     * Get notimportemptyprice
     * @return int
     */
    public function getNotimportemptyprice() { return $this->getField('notimportemptyprice');}

    /**
     * Set notimportemptyprice
     * @param int $notimportemptyprice
     */
    public function setNotimportemptyprice($notimportemptyprice, $update = false) {$this->setField('notimportemptyprice', $notimportemptyprice, $update);}

    /**
     * Filter notimportemptyprice
     * @param int $notimportemptyprice
     * @param string $operation
     */
    public function filterNotimportemptyprice($notimportemptyprice, $operation = false) {$this->filterField('notimportemptyprice', $notimportemptyprice, $operation);}

    /**
     * Get notimportemptyavail
     * @return int
     */
    public function getNotimportemptyavail() { return $this->getField('notimportemptyavail');}

    /**
     * Set notimportemptyavail
     * @param int $notimportemptyavail
     */
    public function setNotimportemptyavail($notimportemptyavail, $update = false) {$this->setField('notimportemptyavail', $notimportemptyavail, $update);}

    /**
     * Filter notimportemptyavail
     * @param int $notimportemptyavail
     * @param string $operation
     */
    public function filterNotimportemptyavail($notimportemptyavail, $operation = false) {$this->filterField('notimportemptyavail', $notimportemptyavail, $operation);}

    /**
     * Get importcron
     * @return int
     */
    public function getImportcron() { return $this->getField('importcron');}

    /**
     * Set importcron
     * @param int $importcron
     */
    public function setImportcron($importcron, $update = false) {$this->setField('importcron', $importcron, $update);}

    /**
     * Filter importcron
     * @param int $importcron
     * @param string $operation
     */
    public function filterImportcron($importcron, $operation = false) {$this->filterField('importcron', $importcron, $operation);}

    /**
     * Get createnewproduct
     * @return int
     */
    public function getCreatenewproduct() { return $this->getField('createnewproduct');}

    /**
     * Set createnewproduct
     * @param int $createnewproduct
     */
    public function setCreatenewproduct($createnewproduct, $update = false) {$this->setField('createnewproduct', $createnewproduct, $update);}

    /**
     * Filter createnewproduct
     * @param int $createnewproduct
     * @param string $operation
     */
    public function filterCreatenewproduct($createnewproduct, $operation = false) {$this->filterField('createnewproduct', $createnewproduct, $operation);}

    /**
     * Get onlyretail
     * @return int
     */
    public function getOnlyretail() { return $this->getField('onlyretail');}

    /**
     * Set onlyretail
     * @param int $onlyretail
     */
    public function setOnlyretail($onlyretail, $update = false) {$this->setField('onlyretail', $onlyretail, $update);}

    /**
     * Filter onlyretail
     * @param int $onlyretail
     * @param string $operation
     */
    public function filterOnlyretail($onlyretail, $operation = false) {$this->filterField('onlyretail', $onlyretail, $operation);}

    /**
     * Get removeminretail
     * @return int
     */
    public function getRemoveminretail() { return $this->getField('removeminretail');}

    /**
     * Set removeminretail
     * @param int $removeminretail
     */
    public function setRemoveminretail($removeminretail, $update = false) {$this->setField('removeminretail', $removeminretail, $update);}

    /**
     * Filter removeminretail
     * @param int $removeminretail
     * @param string $operation
     */
    public function filterRemoveminretail($removeminretail, $operation = false) {$this->filterField('removeminretail', $removeminretail, $operation);}

    /**
     * Get removerecommretail
     * @return int
     */
    public function getRemoverecommretail() { return $this->getField('removerecommretail');}

    /**
     * Set removerecommretail
     * @param int $removerecommretail
     */
    public function setRemoverecommretail($removerecommretail, $update = false) {$this->setField('removerecommretail', $removerecommretail, $update);}

    /**
     * Filter removerecommretail
     * @param int $removerecommretail
     * @param string $operation
     */
    public function filterRemoverecommretail($removerecommretail, $operation = false) {$this->filterField('removerecommretail', $removerecommretail, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoppricesupplierconfig');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopPriceSupplierConfig
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopPriceSupplierConfig
     */
    public static function Get($key) {return self::GetObject("XShopPriceSupplierConfig", $key);}

}

SQLObject::SetFieldArray('shoppricesupplierconfig', array('id', 'supplierid', 'suppliercurrencyid', 'filetype', 'fileencoding', 'columncode', 'columnname', 'columnarticul', 'columnprice', 'columnminretail', 'minretail_cur_id', 'columnrecommretail', 'recommretail_cur_id', 'columnavail', 'columncomment', 'columndiscount', 'limitfrom', 'limitto', 'processed_lists', 'issearchcode', 'issearchcodethis', 'issearchcodemd5', 'issearchname', 'issearchnameprecision', 'issearcharticul', 'notimportemptyprice', 'notimportemptyavail', 'importcron', 'createnewproduct', 'onlyretail', 'removeminretail', 'removerecommretail'));
SQLObject::SetPrimaryKey('shoppricesupplierconfig', 'id');
