<?php
/**
 * Class XShopOrderProduct is ORM to table shoporderproduct
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderProduct extends SQLObject {

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
     * Get productcount
     * @return float
     */
    public function getProductcount() { return $this->getField('productcount');}

    /**
     * Set productcount
     * @param float $productcount
     */
    public function setProductcount($productcount, $update = false) {$this->setField('productcount', $productcount, $update);}

    /**
     * Filter productcount
     * @param float $productcount
     * @param string $operation
     */
    public function filterProductcount($productcount, $operation = false) {$this->filterField('productcount', $productcount, $operation);}

    /**
     * Get productname
     * @return string
     */
    public function getProductname() { return $this->getField('productname');}

    /**
     * Set productname
     * @param string $productname
     */
    public function setProductname($productname, $update = false) {$this->setField('productname', $productname, $update);}

    /**
     * Filter productname
     * @param string $productname
     * @param string $operation
     */
    public function filterProductname($productname, $operation = false) {$this->filterField('productname', $productname, $operation);}

    /**
     * Get productprice
     * @return float
     */
    public function getProductprice() { return $this->getField('productprice');}

    /**
     * Set productprice
     * @param float $productprice
     */
    public function setProductprice($productprice, $update = false) {$this->setField('productprice', $productprice, $update);}

    /**
     * Filter productprice
     * @param float $productprice
     * @param string $operation
     */
    public function filterProductprice($productprice, $operation = false) {$this->filterField('productprice', $productprice, $operation);}

    /**
     * Get discountpercent
     * @return float
     */
    public function getDiscountpercent() { return $this->getField('discountpercent');}

    /**
     * Set discountpercent
     * @param float $discountpercent
     */
    public function setDiscountpercent($discountpercent, $update = false) {$this->setField('discountpercent', $discountpercent, $update);}

    /**
     * Filter discountpercent
     * @param float $discountpercent
     * @param string $operation
     */
    public function filterDiscountpercent($discountpercent, $operation = false) {$this->filterField('discountpercent', $discountpercent, $operation);}

    /**
     * Get producttax
     * @return int
     */
    public function getProducttax() { return $this->getField('producttax');}

    /**
     * Set producttax
     * @param int $producttax
     */
    public function setProducttax($producttax, $update = false) {$this->setField('producttax', $producttax, $update);}

    /**
     * Filter producttax
     * @param int $producttax
     * @param string $operation
     */
    public function filterProducttax($producttax, $operation = false) {$this->filterField('producttax', $producttax, $operation);}

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
     * Get serial
     * @return string
     */
    public function getSerial() { return $this->getField('serial');}

    /**
     * Set serial
     * @param string $serial
     */
    public function setSerial($serial, $update = false) {$this->setField('serial', $serial, $update);}

    /**
     * Filter serial
     * @param string $serial
     * @param string $operation
     */
    public function filterSerial($serial, $operation = false) {$this->filterField('serial', $serial, $operation);}

    /**
     * Get warranty
     * @return string
     */
    public function getWarranty() { return $this->getField('warranty');}

    /**
     * Set warranty
     * @param string $warranty
     */
    public function setWarranty($warranty, $update = false) {$this->setField('warranty', $warranty, $update);}

    /**
     * Filter warranty
     * @param string $warranty
     * @param string $operation
     */
    public function filterWarranty($warranty, $operation = false) {$this->filterField('warranty', $warranty, $operation);}

    /**
     * Get categoryname
     * @return string
     */
    public function getCategoryname() { return $this->getField('categoryname');}

    /**
     * Set categoryname
     * @param string $categoryname
     */
    public function setCategoryname($categoryname, $update = false) {$this->setField('categoryname', $categoryname, $update);}

    /**
     * Filter categoryname
     * @param string $categoryname
     * @param string $operation
     */
    public function filterCategoryname($categoryname, $operation = false) {$this->filterField('categoryname', $categoryname, $operation);}

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
     * Get statusid
     * @return int
     */
    public function getStatusid() { return $this->getField('statusid');}

    /**
     * Set statusid
     * @param int $statusid
     */
    public function setStatusid($statusid, $update = false) {$this->setField('statusid', $statusid, $update);}

    /**
     * Filter statusid
     * @param int $statusid
     * @param string $operation
     */
    public function filterStatusid($statusid, $operation = false) {$this->filterField('statusid', $statusid, $operation);}

    /**
     * Get storageid
     * @return int
     */
    public function getStorageid() { return $this->getField('storageid');}

    /**
     * Set storageid
     * @param int $storageid
     */
    public function setStorageid($storageid, $update = false) {$this->setField('storageid', $storageid, $update);}

    /**
     * Filter storageid
     * @param int $storageid
     * @param string $operation
     */
    public function filterStorageid($storageid, $operation = false) {$this->filterField('storageid', $storageid, $operation);}

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
     * Get params
     * @return string
     */
    public function getParams() { return $this->getField('params');}

    /**
     * Set params
     * @param string $params
     */
    public function setParams($params, $update = false) {$this->setField('params', $params, $update);}

    /**
     * Filter params
     * @param string $params
     * @param string $operation
     */
    public function filterParams($params, $operation = false) {$this->filterField('params', $params, $operation);}

    /**
     * Get datefrom
     * @return string
     */
    public function getDatefrom() { return $this->getField('datefrom');}

    /**
     * Set datefrom
     * @param string $datefrom
     */
    public function setDatefrom($datefrom, $update = false) {$this->setField('datefrom', $datefrom, $update);}

    /**
     * Filter datefrom
     * @param string $datefrom
     * @param string $operation
     */
    public function filterDatefrom($datefrom, $operation = false) {$this->filterField('datefrom', $datefrom, $operation);}

    /**
     * Get dateto
     * @return string
     */
    public function getDateto() { return $this->getField('dateto');}

    /**
     * Set dateto
     * @param string $dateto
     */
    public function setDateto($dateto, $update = false) {$this->setField('dateto', $dateto, $update);}

    /**
     * Filter dateto
     * @param string $dateto
     * @param string $operation
     */
    public function filterDateto($dateto, $operation = false) {$this->filterField('dateto', $dateto, $operation);}

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
     * Get sortable
     * @return int
     */
    public function getSortable() { return $this->getField('sortable');}

    /**
     * Set sortable
     * @param int $sortable
     */
    public function setSortable($sortable, $update = false) {$this->setField('sortable', $sortable, $update);}

    /**
     * Filter sortable
     * @param int $sortable
     * @param string $operation
     */
    public function filterSortable($sortable, $operation = false) {$this->filterField('sortable', $sortable, $operation);}

    /**
     * Get sync
     * @return int
     */
    public function getSync() { return $this->getField('sync');}

    /**
     * Set sync
     * @param int $sync
     */
    public function setSync($sync, $update = false) {$this->setField('sync', $sync, $update);}

    /**
     * Filter sync
     * @param int $sync
     * @param string $operation
     */
    public function filterSync($sync, $operation = false) {$this->filterField('sync', $sync, $operation);}

    /**
     * Get startprice
     * @return float
     */
    public function getStartprice() { return $this->getField('startprice');}

    /**
     * Set startprice
     * @param float $startprice
     */
    public function setStartprice($startprice, $update = false) {$this->setField('startprice', $startprice, $update);}

    /**
     * Filter startprice
     * @param float $startprice
     * @param string $operation
     */
    public function filterStartprice($startprice, $operation = false) {$this->filterField('startprice', $startprice, $operation);}

    /**
     * Get storageincomingid
     * @return int
     */
    public function getStorageincomingid() { return $this->getField('storageincomingid');}

    /**
     * Set storageincomingid
     * @param int $storageincomingid
     */
    public function setStorageincomingid($storageincomingid, $update = false) {$this->setField('storageincomingid', $storageincomingid, $update);}

    /**
     * Filter storageincomingid
     * @param int $storageincomingid
     * @param string $operation
     */
    public function filterStorageincomingid($storageincomingid, $operation = false) {$this->filterField('storageincomingid', $storageincomingid, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoporderproduct');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderProduct
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderProduct
     */
    public static function Get($key) {return self::GetObject("XShopOrderProduct", $key);}

}

SQLObject::SetFieldArray('shoporderproduct', array('id', 'orderid', 'productid', 'productcount', 'productname', 'productprice', 'discountpercent', 'producttax', 'currencyid', 'serial', 'warranty', 'categoryname', 'comment', 'statusid', 'storageid', 'supplierid', 'params', 'datefrom', 'dateto', 'linkkey', 'sortable', 'sync', 'startprice', 'storageincomingid'));
SQLObject::SetPrimaryKey('shoporderproduct', 'id');
