<?php
/**
 * Class XShopProductSupplier is ORM to table shopproductsupplier
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductSupplier extends SQLObject {

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
     * Get article
     * @return string
     */
    public function getArticle() { return $this->getField('article');}

    /**
     * Set article
     * @param string $article
     */
    public function setArticle($article, $update = false) {$this->setField('article', $article, $update);}

    /**
     * Filter article
     * @param string $article
     * @param string $operation
     */
    public function filterArticle($article, $operation = false) {$this->filterField('article', $article, $operation);}

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
        $this->setTablename('shopproductsupplier');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductSupplier
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductSupplier
     */
    public static function Get($key) {return self::GetObject("XShopProductSupplier", $key);}

}

SQLObject::SetFieldArray('shopproductsupplier', array('id', 'productid', 'supplierid', 'code', 'price', 'article', 'discount', 'currencyid', 'avail', 'availtext', 'date', 'minretail', 'minretail_cur_id', 'recommretail', 'recommretail_cur_id', 'comment'));
SQLObject::SetPrimaryKey('shopproductsupplier', 'id');
