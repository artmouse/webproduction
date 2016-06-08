<?php
/**
 * Class XShopTmpPrice is ORM to table shoptmpprice
 * @author SQLObject
 * @package SQLObject
 */
class XShopTmpPrice extends SQLObject {

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
     * Get articul
     * @return string
     */
    public function getArticul() { return $this->getField('articul');}

    /**
     * Set articul
     * @param string $articul
     */
    public function setArticul($articul, $update = false) {$this->setField('articul', $articul, $update);}

    /**
     * Filter articul
     * @param string $articul
     * @param string $operation
     */
    public function filterArticul($articul, $operation = false) {$this->filterField('articul', $articul, $operation);}

    /**
     * Get price
     * @return float
     */
    public function getPrice() { return $this->getField('price');}

    /**
     * Set price
     * @param float $price
     */
    public function setPrice($price, $update = false) {$this->setField('price', $price, $update);}

    /**
     * Filter price
     * @param float $price
     * @param string $operation
     */
    public function filterPrice($price, $operation = false) {$this->filterField('price', $price, $operation);}

    /**
     * Get minretail
     * @return float
     */
    public function getMinretail() { return $this->getField('minretail');}

    /**
     * Set minretail
     * @param float $minretail
     */
    public function setMinretail($minretail, $update = false) {$this->setField('minretail', $minretail, $update);}

    /**
     * Filter minretail
     * @param float $minretail
     * @param string $operation
     */
    public function filterMinretail($minretail, $operation = false) {$this->filterField('minretail', $minretail, $operation);}

    /**
     * Get minretailcurrrncyid
     * @return int
     */
    public function getMinretailcurrrncyid() { return $this->getField('minretailcurrrncyid');}

    /**
     * Set minretailcurrrncyid
     * @param int $minretailcurrrncyid
     */
    public function setMinretailcurrrncyid($minretailcurrrncyid, $update = false) {$this->setField('minretailcurrrncyid', $minretailcurrrncyid, $update);}

    /**
     * Filter minretailcurrrncyid
     * @param int $minretailcurrrncyid
     * @param string $operation
     */
    public function filterMinretailcurrrncyid($minretailcurrrncyid, $operation = false) {$this->filterField('minretailcurrrncyid', $minretailcurrrncyid, $operation);}

    /**
     * Get recommretail
     * @return float
     */
    public function getRecommretail() { return $this->getField('recommretail');}

    /**
     * Set recommretail
     * @param float $recommretail
     */
    public function setRecommretail($recommretail, $update = false) {$this->setField('recommretail', $recommretail, $update);}

    /**
     * Filter recommretail
     * @param float $recommretail
     * @param string $operation
     */
    public function filterRecommretail($recommretail, $operation = false) {$this->filterField('recommretail', $recommretail, $operation);}

    /**
     * Get recommretailcurrruncyid
     * @return int
     */
    public function getRecommretailcurrruncyid() { return $this->getField('recommretailcurrruncyid');}

    /**
     * Set recommretailcurrruncyid
     * @param int $recommretailcurrruncyid
     */
    public function setRecommretailcurrruncyid($recommretailcurrruncyid, $update = false) {$this->setField('recommretailcurrruncyid', $recommretailcurrruncyid, $update);}

    /**
     * Filter recommretailcurrruncyid
     * @param int $recommretailcurrruncyid
     * @param string $operation
     */
    public function filterRecommretailcurrruncyid($recommretailcurrruncyid, $operation = false) {$this->filterField('recommretailcurrruncyid', $recommretailcurrruncyid, $operation);}

    /**
     * Get availtext
     * @return string
     */
    public function getAvailtext() { return $this->getField('availtext');}

    /**
     * Set availtext
     * @param string $availtext
     */
    public function setAvailtext($availtext, $update = false) {$this->setField('availtext', $availtext, $update);}

    /**
     * Filter availtext
     * @param string $availtext
     * @param string $operation
     */
    public function filterAvailtext($availtext, $operation = false) {$this->filterField('availtext', $availtext, $operation);}

    /**
     * Get avail
     * @return int
     */
    public function getAvail() { return $this->getField('avail');}

    /**
     * Set avail
     * @param int $avail
     */
    public function setAvail($avail, $update = false) {$this->setField('avail', $avail, $update);}

    /**
     * Filter avail
     * @param int $avail
     * @param string $operation
     */
    public function filterAvail($avail, $operation = false) {$this->filterField('avail', $avail, $operation);}

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
     * Get isnew
     * @return int
     */
    public function getIsnew() { return $this->getField('isnew');}

    /**
     * Set isnew
     * @param int $isnew
     */
    public function setIsnew($isnew, $update = false) {$this->setField('isnew', $isnew, $update);}

    /**
     * Filter isnew
     * @param int $isnew
     * @param string $operation
     */
    public function filterIsnew($isnew, $operation = false) {$this->filterField('isnew', $isnew, $operation);}

    /**
     * Get date
     * @return string
     */
    public function getDate() { return $this->getField('date');}

    /**
     * Set date
     * @param string $date
     */
    public function setDate($date, $update = false) {$this->setField('date', $date, $update);}

    /**
     * Filter date
     * @param string $date
     * @param string $operation
     */
    public function filterDate($date, $operation = false) {$this->filterField('date', $date, $operation);}

    /**
     * Get discount
     * @return int
     */
    public function getDiscount() { return $this->getField('discount');}

    /**
     * Set discount
     * @param int $discount
     */
    public function setDiscount($discount, $update = false) {$this->setField('discount', $discount, $update);}

    /**
     * Filter discount
     * @param int $discount
     * @param string $operation
     */
    public function filterDiscount($discount, $operation = false) {$this->filterField('discount', $discount, $operation);}

    /**
     * Get olddate
     * @return string
     */
    public function getOlddate() { return $this->getField('olddate');}

    /**
     * Set olddate
     * @param string $olddate
     */
    public function setOlddate($olddate, $update = false) {$this->setField('olddate', $olddate, $update);}

    /**
     * Filter olddate
     * @param string $olddate
     * @param string $operation
     */
    public function filterOlddate($olddate, $operation = false) {$this->filterField('olddate', $olddate, $operation);}

    /**
     * Get isremoveminretail
     * @return int
     */
    public function getIsremoveminretail() { return $this->getField('isremoveminretail');}

    /**
     * Set isremoveminretail
     * @param int $isremoveminretail
     */
    public function setIsremoveminretail($isremoveminretail, $update = false) {$this->setField('isremoveminretail', $isremoveminretail, $update);}

    /**
     * Filter isremoveminretail
     * @param int $isremoveminretail
     * @param string $operation
     */
    public function filterIsremoveminretail($isremoveminretail, $operation = false) {$this->filterField('isremoveminretail', $isremoveminretail, $operation);}

    /**
     * Get isremoverecommretail
     * @return int
     */
    public function getIsremoverecommretail() { return $this->getField('isremoverecommretail');}

    /**
     * Set isremoverecommretail
     * @param int $isremoverecommretail
     */
    public function setIsremoverecommretail($isremoverecommretail, $update = false) {$this->setField('isremoverecommretail', $isremoverecommretail, $update);}

    /**
     * Filter isremoverecommretail
     * @param int $isremoverecommretail
     * @param string $operation
     */
    public function filterIsremoverecommretail($isremoverecommretail, $operation = false) {$this->filterField('isremoverecommretail', $isremoverecommretail, $operation);}

    /**
     * Get matchreason
     * @return string
     */
    public function getMatchreason() { return $this->getField('matchreason');}

    /**
     * Set matchreason
     * @param string $matchreason
     */
    public function setMatchreason($matchreason, $update = false) {$this->setField('matchreason', $matchreason, $update);}

    /**
     * Filter matchreason
     * @param string $matchreason
     * @param string $operation
     */
    public function filterMatchreason($matchreason, $operation = false) {$this->filterField('matchreason', $matchreason, $operation);}

    /**
     * Get oldprice
     * @return float
     */
    public function getOldprice() { return $this->getField('oldprice');}

    /**
     * Set oldprice
     * @param float $oldprice
     */
    public function setOldprice($oldprice, $update = false) {$this->setField('oldprice', $oldprice, $update);}

    /**
     * Filter oldprice
     * @param float $oldprice
     * @param string $operation
     */
    public function filterOldprice($oldprice, $operation = false) {$this->filterField('oldprice', $oldprice, $operation);}

    /**
     * Get oldpricecurrencyid
     * @return int
     */
    public function getOldpricecurrencyid() { return $this->getField('oldpricecurrencyid');}

    /**
     * Set oldpricecurrencyid
     * @param int $oldpricecurrencyid
     */
    public function setOldpricecurrencyid($oldpricecurrencyid, $update = false) {$this->setField('oldpricecurrencyid', $oldpricecurrencyid, $update);}

    /**
     * Filter oldpricecurrencyid
     * @param int $oldpricecurrencyid
     * @param string $operation
     */
    public function filterOldpricecurrencyid($oldpricecurrencyid, $operation = false) {$this->filterField('oldpricecurrencyid', $oldpricecurrencyid, $operation);}

    /**
     * Get oldavailtext
     * @return string
     */
    public function getOldavailtext() { return $this->getField('oldavailtext');}

    /**
     * Set oldavailtext
     * @param string $oldavailtext
     */
    public function setOldavailtext($oldavailtext, $update = false) {$this->setField('oldavailtext', $oldavailtext, $update);}

    /**
     * Filter oldavailtext
     * @param string $oldavailtext
     * @param string $operation
     */
    public function filterOldavailtext($oldavailtext, $operation = false) {$this->filterField('oldavailtext', $oldavailtext, $operation);}

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
     * Get createnew
     * @return int
     */
    public function getCreatenew() { return $this->getField('createnew');}

    /**
     * Set createnew
     * @param int $createnew
     */
    public function setCreatenew($createnew, $update = false) {$this->setField('createnew', $createnew, $update);}

    /**
     * Filter createnew
     * @param int $createnew
     * @param string $operation
     */
    public function filterCreatenew($createnew, $operation = false) {$this->filterField('createnew', $createnew, $operation);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoptmpprice');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopTmpPrice
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopTmpPrice
     */
    public static function Get($key) {return self::GetObject("XShopTmpPrice", $key);}

}

SQLObject::SetFieldArray('shoptmpprice', array('id', 'priceid', 'productid', 'supplierid', 'currencyid', 'code', 'name', 'articul', 'price', 'minretail', 'minretailcurrrncyid', 'recommretail', 'recommretailcurrruncyid', 'availtext', 'avail', 'comment', 'datelifeto', 'isnew', 'date', 'discount', 'olddate', 'isremoveminretail', 'isremoverecommretail', 'matchreason', 'oldprice', 'oldpricecurrencyid', 'oldavailtext', 'onlyretail', 'createnew', 'dateupload'));
SQLObject::SetPrimaryKey('shoptmpprice', 'id');
