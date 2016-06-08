<?php
/**
 * Class XFinancePayment is ORM to table financepayment
 * @author SQLObject
 * @package SQLObject
 */
class XFinancePayment extends SQLObject {

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
     * Get rdate
     * @return string
     */
    public function getRdate() { return $this->getField('rdate');}

    /**
     * Set rdate
     * @param string $rdate
     */
    public function setRdate($rdate, $update = false) {$this->setField('rdate', $rdate, $update);}

    /**
     * Filter rdate
     * @param string $rdate
     * @param string $operation
     */
    public function filterRdate($rdate, $operation = false) {$this->filterField('rdate', $rdate, $operation);}

    /**
     * Get amount
     * @return float
     */
    public function getAmount() { return $this->getField('amount');}

    /**
     * Set amount
     * @param float $amount
     */
    public function setAmount($amount, $update = false) {$this->setField('amount', $amount, $update);}

    /**
     * Filter amount
     * @param float $amount
     * @param string $operation
     */
    public function filterAmount($amount, $operation = false) {$this->filterField('amount', $amount, $operation);}

    /**
     * Get amountbase
     * @return float
     */
    public function getAmountbase() { return $this->getField('amountbase');}

    /**
     * Set amountbase
     * @param float $amountbase
     */
    public function setAmountbase($amountbase, $update = false) {$this->setField('amountbase', $amountbase, $update);}

    /**
     * Filter amountbase
     * @param float $amountbase
     * @param string $operation
     */
    public function filterAmountbase($amountbase, $operation = false) {$this->filterField('amountbase', $amountbase, $operation);}

    /**
     * Get currencyid
     * @return int
     */
    public function getCurrencyid() { return $this->getField('currencyid');}

    /**
     * Set currencyid
     * @param int $currencyid
     */
    public function setCurrencyid($currencyid, $update = false) {$this->setField('currencyid', $currencyid, $update);}

    /**
     * Filter currencyid
     * @param int $currencyid
     * @param string $operation
     */
    public function filterCurrencyid($currencyid, $operation = false) {$this->filterField('currencyid', $currencyid, $operation);}

    /**
     * Get currencyrate
     * @return float
     */
    public function getCurrencyrate() { return $this->getField('currencyrate');}

    /**
     * Set currencyrate
     * @param float $currencyrate
     */
    public function setCurrencyrate($currencyrate, $update = false) {$this->setField('currencyrate', $currencyrate, $update);}

    /**
     * Filter currencyrate
     * @param float $currencyrate
     * @param string $operation
     */
    public function filterCurrencyrate($currencyrate, $operation = false) {$this->filterField('currencyrate', $currencyrate, $operation);}

    /**
     * Get accountid
     * @return int
     */
    public function getAccountid() { return $this->getField('accountid');}

    /**
     * Set accountid
     * @param int $accountid
     */
    public function setAccountid($accountid, $update = false) {$this->setField('accountid', $accountid, $update);}

    /**
     * Filter accountid
     * @param int $accountid
     * @param string $operation
     */
    public function filterAccountid($accountid, $operation = false) {$this->filterField('accountid', $accountid, $operation);}

    /**
     * Get clientid
     * @return int
     */
    public function getClientid() { return $this->getField('clientid');}

    /**
     * Set clientid
     * @param int $clientid
     */
    public function setClientid($clientid, $update = false) {$this->setField('clientid', $clientid, $update);}

    /**
     * Filter clientid
     * @param int $clientid
     * @param string $operation
     */
    public function filterClientid($clientid, $operation = false) {$this->filterField('clientid', $clientid, $operation);}

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
     * Get categoryid
     * @return int
     */
    public function getCategoryid() { return $this->getField('categoryid');}

    /**
     * Set categoryid
     * @param int $categoryid
     */
    public function setCategoryid($categoryid, $update = false) {$this->setField('categoryid', $categoryid, $update);}

    /**
     * Filter categoryid
     * @param int $categoryid
     * @param string $operation
     */
    public function filterCategoryid($categoryid, $operation = false) {$this->filterField('categoryid', $categoryid, $operation);}

    /**
     * Get code
     * @return string
     */
    public function getCode() { return $this->getField('code');}

    /**
     * Set code
     * @param string $code
     */
    public function setCode($code, $update = false) {$this->setField('code', $code, $update);}

    /**
     * Filter code
     * @param string $code
     * @param string $operation
     */
    public function filterCode($code, $operation = false) {$this->filterField('code', $code, $operation);}

    /**
     * Get orderid
     * @return int
     */
    public function getOrderid() { return $this->getField('orderid');}

    /**
     * Set orderid
     * @param int $orderid
     */
    public function setOrderid($orderid, $update = false) {$this->setField('orderid', $orderid, $update);}

    /**
     * Filter orderid
     * @param int $orderid
     * @param string $operation
     */
    public function filterOrderid($orderid, $operation = false) {$this->filterField('orderid', $orderid, $operation);}

    /**
     * Get orderamountbase
     * @return float
     */
    public function getOrderamountbase() { return $this->getField('orderamountbase');}

    /**
     * Set orderamountbase
     * @param float $orderamountbase
     */
    public function setOrderamountbase($orderamountbase, $update = false) {$this->setField('orderamountbase', $orderamountbase, $update);}

    /**
     * Filter orderamountbase
     * @param float $orderamountbase
     * @param string $operation
     */
    public function filterOrderamountbase($orderamountbase, $operation = false) {$this->filterField('orderamountbase', $orderamountbase, $operation);}

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
     * Get bankdetail
     * @return string
     */
    public function getBankdetail() { return $this->getField('bankdetail');}

    /**
     * Set bankdetail
     * @param string $bankdetail
     */
    public function setBankdetail($bankdetail, $update = false) {$this->setField('bankdetail', $bankdetail, $update);}

    /**
     * Filter bankdetail
     * @param string $bankdetail
     * @param string $operation
     */
    public function filterBankdetail($bankdetail, $operation = false) {$this->filterField('bankdetail', $bankdetail, $operation);}

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
     * Get invoiceid
     * @return int
     */
    public function getInvoiceid() { return $this->getField('invoiceid');}

    /**
     * Set invoiceid
     * @param int $invoiceid
     */
    public function setInvoiceid($invoiceid, $update = false) {$this->setField('invoiceid', $invoiceid, $update);}

    /**
     * Filter invoiceid
     * @param int $invoiceid
     * @param string $operation
     */
    public function filterInvoiceid($invoiceid, $operation = false) {$this->filterField('invoiceid', $invoiceid, $operation);}

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
     * Get filename
     * @return string
     */
    public function getFilename() { return $this->getField('filename');}

    /**
     * Set filename
     * @param string $filename
     */
    public function setFilename($filename, $update = false) {$this->setField('filename', $filename, $update);}

    /**
     * Filter filename
     * @param string $filename
     * @param string $operation
     */
    public function filterFilename($filename, $operation = false) {$this->filterField('filename', $filename, $operation);}

    /**
     * Get referalprocessed
     * @return int
     */
    public function getReferalprocessed() { return $this->getField('referalprocessed');}

    /**
     * Set referalprocessed
     * @param int $referalprocessed
     */
    public function setReferalprocessed($referalprocessed, $update = false) {$this->setField('referalprocessed', $referalprocessed, $update);}

    /**
     * Filter referalprocessed
     * @param int $referalprocessed
     * @param string $operation
     */
    public function filterReferalprocessed($referalprocessed, $operation = false) {$this->filterField('referalprocessed', $referalprocessed, $operation);}

    /**
     * Get noBalance
     * @return int
     */
    public function getNoBalance() { return $this->getField('noBalance');}

    /**
     * Set noBalance
     * @param int $noBalance
     */
    public function setNoBalance($noBalance, $update = false) {$this->setField('noBalance', $noBalance, $update);}

    /**
     * Filter noBalance
     * @param int $noBalance
     * @param string $operation
     */
    public function filterNoBalance($noBalance, $operation = false) {$this->filterField('noBalance', $noBalance, $operation);}

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
        $this->setTablename('financepayment');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XFinancePayment
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XFinancePayment
     */
    public static function Get($key) {return self::GetObject("XFinancePayment", $key);}

}

SQLObject::SetFieldArray('financepayment', array('id', 'cdate', 'pdate', 'rdate', 'amount', 'amountbase', 'currencyid', 'currencyrate', 'accountid', 'clientid', 'userid', 'categoryid', 'code', 'orderid', 'orderamountbase', 'linkkey', 'bankdetail', 'comment', 'invoiceid', 'file', 'filename', 'referalprocessed', 'noBalance', 'deleted'));
SQLObject::SetPrimaryKey('financepayment', 'id');
