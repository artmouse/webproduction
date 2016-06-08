<?php
/**
 * Class XShopProductsNoticeOfAvailability is ORM to table shopproductsnoticeofavailability
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductsNoticeOfAvailability extends SQLObject {

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
     * Get productid
     * @return int
     */
    public function getProductid() { return $this->getField('productid');}

    /**
     * Set productid
     * @param int $productid
     */
    public function setProductid($productid, $update = false) {$this->setField('productid', $productid, $update);}

    /**
     * Filter productid
     * @param int $productid
     * @param string $operation
     */
    public function filterProductid($productid, $operation = false) {$this->filterField('productid', $productid, $operation);}

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
     * Get email
     * @return string
     */
    public function getEmail() { return $this->getField('email');}

    /**
     * Set email
     * @param string $email
     */
    public function setEmail($email, $update = false) {$this->setField('email', $email, $update);}

    /**
     * Filter email
     * @param string $email
     * @param string $operation
     */
    public function filterEmail($email, $operation = false) {$this->filterField('email', $email, $operation);}

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
     * Get senddate
     * @return string
     */
    public function getSenddate() { return $this->getField('senddate');}

    /**
     * Set senddate
     * @param string $senddate
     */
    public function setSenddate($senddate, $update = false) {$this->setField('senddate', $senddate, $update);}

    /**
     * Filter senddate
     * @param string $senddate
     * @param string $operation
     */
    public function filterSenddate($senddate, $operation = false) {$this->filterField('senddate', $senddate, $operation);}

    /**
     * Get status
     * @return int
     */
    public function getStatus() { return $this->getField('status');}

    /**
     * Set status
     * @param int $status
     */
    public function setStatus($status, $update = false) {$this->setField('status', $status, $update);}

    /**
     * Filter status
     * @param int $status
     * @param string $operation
     */
    public function filterStatus($status, $operation = false) {$this->filterField('status', $status, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductsnoticeofavailability');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductsNoticeOfAvailability
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductsNoticeOfAvailability
     */
    public static function Get($key) {return self::GetObject("XShopProductsNoticeOfAvailability", $key);}

}

SQLObject::SetFieldArray('shopproductsnoticeofavailability', array('id', 'productid', 'name', 'email', 'cdate', 'senddate', 'status'));
SQLObject::SetPrimaryKey('shopproductsnoticeofavailability', 'id');
