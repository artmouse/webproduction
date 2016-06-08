<?php
/**
 * Class XShopCoupon is ORM to table shopcoupon
 * @author SQLObject
 * @package SQLObject
 */
class XShopCoupon extends SQLObject {

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
     * Get dateused
     * @return string
     */
    public function getDateused() { return $this->getField('dateused');}

    /**
     * Set dateused
     * @param string $dateused
     */
    public function setDateused($dateused, $update = false) {$this->setField('dateused', $dateused, $update);}

    /**
     * Filter dateused
     * @param string $dateused
     * @param string $operation
     */
    public function filterDateused($dateused, $operation = false) {$this->filterField('dateused', $dateused, $operation);}

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
     * Get sendcoupon
     * @return int
     */
    public function getSendcoupon() { return $this->getField('sendcoupon');}

    /**
     * Set sendcoupon
     * @param int $sendcoupon
     */
    public function setSendcoupon($sendcoupon, $update = false) {$this->setField('sendcoupon', $sendcoupon, $update);}

    /**
     * Filter sendcoupon
     * @param int $sendcoupon
     * @param string $operation
     */
    public function filterSendcoupon($sendcoupon, $operation = false) {$this->filterField('sendcoupon', $sendcoupon, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopcoupon');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopCoupon
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopCoupon
     */
    public static function Get($key) {return self::GetObject("XShopCoupon", $key);}

}

SQLObject::SetFieldArray('shopcoupon', array('id', 'code', 'dateused', 'amount', 'currencyid', 'orderid', 'comment', 'sendcoupon'));
SQLObject::SetPrimaryKey('shopcoupon', 'id');
