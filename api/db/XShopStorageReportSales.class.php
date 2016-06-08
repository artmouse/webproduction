<?php
/**
 * Class XShopStorageReportSales is ORM to table shopstoragereportsales
 * @author SQLObject
 * @package SQLObject
 */
class XShopStorageReportSales extends SQLObject {

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
     * Get dateorder
     * @return string
     */
    public function getDateorder() { return $this->getField('dateorder');}

    /**
     * Set dateorder
     * @param string $dateorder
     */
    public function setDateorder($dateorder, $update = false) {$this->setField('dateorder', $dateorder, $update);}

    /**
     * Filter dateorder
     * @param string $dateorder
     * @param string $operation
     */
    public function filterDateorder($dateorder, $operation = false) {$this->filterField('dateorder', $dateorder, $operation);}

    /**
     * Get dateship
     * @return string
     */
    public function getDateship() { return $this->getField('dateship');}

    /**
     * Set dateship
     * @param string $dateship
     */
    public function setDateship($dateship, $update = false) {$this->setField('dateship', $dateship, $update);}

    /**
     * Filter dateship
     * @param string $dateship
     * @param string $operation
     */
    public function filterDateship($dateship, $operation = false) {$this->filterField('dateship', $dateship, $operation);}

    /**
     * Get dateincoming
     * @return string
     */
    public function getDateincoming() { return $this->getField('dateincoming');}

    /**
     * Set dateincoming
     * @param string $dateincoming
     */
    public function setDateincoming($dateincoming, $update = false) {$this->setField('dateincoming', $dateincoming, $update);}

    /**
     * Filter dateincoming
     * @param string $dateincoming
     * @param string $operation
     */
    public function filterDateincoming($dateincoming, $operation = false) {$this->filterField('dateincoming', $dateincoming, $operation);}

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
     * Get managerid
     * @return int
     */
    public function getManagerid() { return $this->getField('managerid');}

    /**
     * Set managerid
     * @param int $managerid
     */
    public function setManagerid($managerid, $update = false) {$this->setField('managerid', $managerid, $update);}

    /**
     * Filter managerid
     * @param int $managerid
     * @param string $operation
     */
    public function filterManagerid($managerid, $operation = false) {$this->filterField('managerid', $managerid, $operation);}

    /**
     * Get discountpercent
     * @return int
     */
    public function getDiscountpercent() { return $this->getField('discountpercent');}

    /**
     * Set discountpercent
     * @param int $discountpercent
     */
    public function setDiscountpercent($discountpercent, $update = false) {$this->setField('discountpercent', $discountpercent, $update);}

    /**
     * Filter discountpercent
     * @param int $discountpercent
     * @param string $operation
     */
    public function filterDiscountpercent($discountpercent, $operation = false) {$this->filterField('discountpercent', $discountpercent, $operation);}

    /**
     * Get sumorder
     * @return float
     */
    public function getSumorder() { return $this->getField('sumorder');}

    /**
     * Set sumorder
     * @param float $sumorder
     */
    public function setSumorder($sumorder, $update = false) {$this->setField('sumorder', $sumorder, $update);}

    /**
     * Filter sumorder
     * @param float $sumorder
     * @param string $operation
     */
    public function filterSumorder($sumorder, $operation = false) {$this->filterField('sumorder', $sumorder, $operation);}

    /**
     * Get sumship
     * @return float
     */
    public function getSumship() { return $this->getField('sumship');}

    /**
     * Set sumship
     * @param float $sumship
     */
    public function setSumship($sumship, $update = false) {$this->setField('sumship', $sumship, $update);}

    /**
     * Filter sumship
     * @param float $sumship
     * @param string $operation
     */
    public function filterSumship($sumship, $operation = false) {$this->filterField('sumship', $sumship, $operation);}

    /**
     * Get sumcost
     * @return float
     */
    public function getSumcost() { return $this->getField('sumcost');}

    /**
     * Set sumcost
     * @param float $sumcost
     */
    public function setSumcost($sumcost, $update = false) {$this->setField('sumcost', $sumcost, $update);}

    /**
     * Filter sumcost
     * @param float $sumcost
     * @param string $operation
     */
    public function filterSumcost($sumcost, $operation = false) {$this->filterField('sumcost', $sumcost, $operation);}

    /**
     * Get orderproductid
     * @return int
     */
    public function getOrderproductid() { return $this->getField('orderproductid');}

    /**
     * Set orderproductid
     * @param int $orderproductid
     */
    public function setOrderproductid($orderproductid, $update = false) {$this->setField('orderproductid', $orderproductid, $update);}

    /**
     * Filter orderproductid
     * @param int $orderproductid
     * @param string $operation
     */
    public function filterOrderproductid($orderproductid, $operation = false) {$this->filterField('orderproductid', $orderproductid, $operation);}

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
     * Get productamountorder
     * @return float
     */
    public function getProductamountorder() { return $this->getField('productamountorder');}

    /**
     * Set productamountorder
     * @param float $productamountorder
     */
    public function setProductamountorder($productamountorder, $update = false) {$this->setField('productamountorder', $productamountorder, $update);}

    /**
     * Filter productamountorder
     * @param float $productamountorder
     * @param string $operation
     */
    public function filterProductamountorder($productamountorder, $operation = false) {$this->filterField('productamountorder', $productamountorder, $operation);}

    /**
     * Get productamountship
     * @return float
     */
    public function getProductamountship() { return $this->getField('productamountship');}

    /**
     * Set productamountship
     * @param float $productamountship
     */
    public function setProductamountship($productamountship, $update = false) {$this->setField('productamountship', $productamountship, $update);}

    /**
     * Filter productamountship
     * @param float $productamountship
     * @param string $operation
     */
    public function filterProductamountship($productamountship, $operation = false) {$this->filterField('productamountship', $productamountship, $operation);}

    /**
     * Get productsumorder
     * @return float
     */
    public function getProductsumorder() { return $this->getField('productsumorder');}

    /**
     * Set productsumorder
     * @param float $productsumorder
     */
    public function setProductsumorder($productsumorder, $update = false) {$this->setField('productsumorder', $productsumorder, $update);}

    /**
     * Filter productsumorder
     * @param float $productsumorder
     * @param string $operation
     */
    public function filterProductsumorder($productsumorder, $operation = false) {$this->filterField('productsumorder', $productsumorder, $operation);}

    /**
     * Get productsumship
     * @return float
     */
    public function getProductsumship() { return $this->getField('productsumship');}

    /**
     * Set productsumship
     * @param float $productsumship
     */
    public function setProductsumship($productsumship, $update = false) {$this->setField('productsumship', $productsumship, $update);}

    /**
     * Filter productsumship
     * @param float $productsumship
     * @param string $operation
     */
    public function filterProductsumship($productsumship, $operation = false) {$this->filterField('productsumship', $productsumship, $operation);}

    /**
     * Get productsumcost
     * @return float
     */
    public function getProductsumcost() { return $this->getField('productsumcost');}

    /**
     * Set productsumcost
     * @param float $productsumcost
     */
    public function setProductsumcost($productsumcost, $update = false) {$this->setField('productsumcost', $productsumcost, $update);}

    /**
     * Filter productsumcost
     * @param float $productsumcost
     * @param string $operation
     */
    public function filterProductsumcost($productsumcost, $operation = false) {$this->filterField('productsumcost', $productsumcost, $operation);}

    /**
     * Get transactionid
     * @return int
     */
    public function getTransactionid() { return $this->getField('transactionid');}

    /**
     * Set transactionid
     * @param int $transactionid
     */
    public function setTransactionid($transactionid, $update = false) {$this->setField('transactionid', $transactionid, $update);}

    /**
     * Filter transactionid
     * @param int $transactionid
     * @param string $operation
     */
    public function filterTransactionid($transactionid, $operation = false) {$this->filterField('transactionid', $transactionid, $operation);}

    /**
     * Get storagenameid
     * @return int
     */
    public function getStoragenameid() { return $this->getField('storagenameid');}

    /**
     * Set storagenameid
     * @param int $storagenameid
     */
    public function setStoragenameid($storagenameid, $update = false) {$this->setField('storagenameid', $storagenameid, $update);}

    /**
     * Filter storagenameid
     * @param int $storagenameid
     * @param string $operation
     */
    public function filterStoragenameid($storagenameid, $operation = false) {$this->filterField('storagenameid', $storagenameid, $operation);}

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
     * Get storageprice
     * @return float
     */
    public function getStorageprice() { return $this->getField('storageprice');}

    /**
     * Set storageprice
     * @param float $storageprice
     */
    public function setStorageprice($storageprice, $update = false) {$this->setField('storageprice', $storageprice, $update);}

    /**
     * Filter storageprice
     * @param float $storageprice
     * @param string $operation
     */
    public function filterStorageprice($storageprice, $operation = false) {$this->filterField('storageprice', $storageprice, $operation);}

    /**
     * Get storageamountorder
     * @return float
     */
    public function getStorageamountorder() { return $this->getField('storageamountorder');}

    /**
     * Set storageamountorder
     * @param float $storageamountorder
     */
    public function setStorageamountorder($storageamountorder, $update = false) {$this->setField('storageamountorder', $storageamountorder, $update);}

    /**
     * Filter storageamountorder
     * @param float $storageamountorder
     * @param string $operation
     */
    public function filterStorageamountorder($storageamountorder, $operation = false) {$this->filterField('storageamountorder', $storageamountorder, $operation);}

    /**
     * Get storageamountship
     * @return float
     */
    public function getStorageamountship() { return $this->getField('storageamountship');}

    /**
     * Set storageamountship
     * @param float $storageamountship
     */
    public function setStorageamountship($storageamountship, $update = false) {$this->setField('storageamountship', $storageamountship, $update);}

    /**
     * Filter storageamountship
     * @param float $storageamountship
     * @param string $operation
     */
    public function filterStorageamountship($storageamountship, $operation = false) {$this->filterField('storageamountship', $storageamountship, $operation);}

    /**
     * Get storagesumorder
     * @return float
     */
    public function getStoragesumorder() { return $this->getField('storagesumorder');}

    /**
     * Set storagesumorder
     * @param float $storagesumorder
     */
    public function setStoragesumorder($storagesumorder, $update = false) {$this->setField('storagesumorder', $storagesumorder, $update);}

    /**
     * Filter storagesumorder
     * @param float $storagesumorder
     * @param string $operation
     */
    public function filterStoragesumorder($storagesumorder, $operation = false) {$this->filterField('storagesumorder', $storagesumorder, $operation);}

    /**
     * Get storagesumship
     * @return float
     */
    public function getStoragesumship() { return $this->getField('storagesumship');}

    /**
     * Set storagesumship
     * @param float $storagesumship
     */
    public function setStoragesumship($storagesumship, $update = false) {$this->setField('storagesumship', $storagesumship, $update);}

    /**
     * Filter storagesumship
     * @param float $storagesumship
     * @param string $operation
     */
    public function filterStoragesumship($storagesumship, $operation = false) {$this->filterField('storagesumship', $storagesumship, $operation);}

    /**
     * Get storagesumcost
     * @return float
     */
    public function getStoragesumcost() { return $this->getField('storagesumcost');}

    /**
     * Set storagesumcost
     * @param float $storagesumcost
     */
    public function setStoragesumcost($storagesumcost, $update = false) {$this->setField('storagesumcost', $storagesumcost, $update);}

    /**
     * Filter storagesumcost
     * @param float $storagesumcost
     * @param string $operation
     */
    public function filterStoragesumcost($storagesumcost, $operation = false) {$this->filterField('storagesumcost', $storagesumcost, $operation);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopstoragereportsales');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopStorageReportSales
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopStorageReportSales
     */
    public static function Get($key) {return self::GetObject("XShopStorageReportSales", $key);}

}

SQLObject::SetFieldArray('shopstoragereportsales', array('id', 'cdate', 'dateorder', 'dateship', 'dateincoming', 'orderid', 'clientid', 'managerid', 'discountpercent', 'sumorder', 'sumship', 'sumcost', 'orderproductid', 'productid', 'productname', 'productprice', 'productamountorder', 'productamountship', 'productsumorder', 'productsumship', 'productsumcost', 'transactionid', 'storagenameid', 'supplierid', 'storageid', 'storageprice', 'storageamountorder', 'storageamountship', 'storagesumorder', 'storagesumship', 'storagesumcost'));
SQLObject::SetPrimaryKey('shopstoragereportsales', 'id');
