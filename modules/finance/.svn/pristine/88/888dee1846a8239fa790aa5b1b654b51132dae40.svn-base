<?php
/**
 * OneBox
 * @copyright (C) 2011-2013 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class InvoiceService extends ServiceUtils_AbstractService {

    /**
     * @param int $id
     * @return FinanceInvoice
     */
    public function getInvoiceByID($id) {
        try {
            return $this->getObjectByID($id, 'FinanceInvoice');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('FinanceInvoice by id not found');
    }

    /**
     * @return FinanceInvoice
     */
    public function getInvoicesAll() {
        $x = new FinanceInvoice();
        $x->setOrder('cdate', 'DESC');
        return $x;
    }

    /**
     * Добавить счет
     * 
     * @param User $user
     * @param string $name
     * @param int $clientID
     * @param int $contractorID
     * @param float $sum
     * @param int $currencyID
     * @param string $type
     * @param string $date
     * @param string $linkkey
     * @param array $productArray
     * @return FinanceInvoice
     */
    public function addInvoice(User $user, $name, $clientID, $contractorID, $sum, $currencyID,
    $type, $date, $linkkey = false, $productArray = array()) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();
            
            $name = strip_tags($name);

            if ($sum < 0) {
                $ex->addError('sum');
            }
            
            if ($date) {
                $date = DateTime_Corrector::CorrectDateTime($date);
            }

            // проверка валюты
            try {
                Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('currency');
            }

            // проверка юридического лица
            try {
                $contractor = Shop::Get()->getShopService()->getContractorByID($contractorID);
                $contractorTax = $contractor->getTax();
            } catch (ServiceUtils_Exception $se) {
                try {
                    $contractor = $this->getContractorDefault();
                    $contractorID = $contractor->getId();
                    $contractorTax = $contractor->getTax();
                } catch (Exception $e) {
                    $contractorID = 0;
                    $contractorTax = 0;
                }
            }

            // проверка клиента
            if ($clientID) {
                try {
                    Shop::Get()->getUserService()->getUserByID($clientID);
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('client');
                }
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            // оформление счета
            $invoice = new FinanceInvoice();
            $invoice->setCdate(date('Y-m-d H:i:s'));
            $invoice->setUserid($user->getId());
            $invoice->setName($name);
            $invoice->setType($type);
            $invoice->setSum($sum);
            $invoice->setCurrencyid($currencyID);
            $invoice->setClientid($clientID);
            $invoice->setContractorid($contractorID);
            $invoice->setLinkkey($linkkey);
            $invoice->setDate($date?$date:$invoice->getCdate());
            $invoice->insert();

            foreach ($productArray as $p) {
                $ip = new FinanceInvoiceProduct();
                $ip->setInvoiceid($invoice->getId());
                $ip->setProductid($p['productid']);
                $ip->setName($p['productname']);
                $ip->setAmount($p['amount']);
                $ip->setPrice($p['price']);
                $ip->setCurrencyid($p['currencyid']);
                $ip->insert();
            }

            SQLObject::TransactionCommit();

            return $invoice;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Редактировать счет
     * @todo проверка прав
     * 
     * @param FinanceInvoice $invoice
     * @param User $user
     * @param string $name
     * @param int $clientID
     * @param int $contractorID
     * @param float $sum
     * @param int $currencyID
     * @param string $type
     * @param string $date
     * @return FinanceInvoice
     */
    public function editInvoice(FinanceInvoice $invoice, User $user, $name, $clientID, 
    $contractorID, $sum, $currencyID, $type, $date) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            if ($invoice->getLinkkey()) {
                $ex->addError('link');
            }
            
            $name = strip_tags($name);

            if ($sum < 0) {
                $ex->addError('sum');
            }
            
            if ($date) {
                $date = DateTime_Corrector::CorrectDateTime($date);
            }

            // проверка валюты
            try {
                Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('currency');
            }

            // проверка юридического лица
            try {
                $contractor = Shop::Get()->getShopService()->getContractorByID($contractorID);
                $contractorTax = $contractor->getTax();
            } catch (ServiceUtils_Exception $se) {
                try {
                    $contractor = $this->getContractorDefault();
                    $contractorID = $contractor->getId();
                    $contractorTax = $contractor->getTax();
                } catch (Exception $e) {
                    $contractorID = 0;
                    $contractorTax = 0;
                }
            }

            // проверка клиента
            if ($clientID) {
                try {
                    Shop::Get()->getUserService()->getUserByID($clientID);
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('client');
                }
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $invoice->setName($name);
            $invoice->setSum($sum);
            $invoice->setCurrencyid($currencyID);
            $invoice->setClientid($clientID);
            $invoice->setContractorid($contractorID);
            $invoice->setType($type);
            $invoice->setDate($date?$date:$invoice->getCdate());
            $invoice->update();

            SQLObject::TransactionCommit();

            return $invoice;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удаление счета
     * @todo проверка прав
     *
     * @param FinanceInvoice $invoice
     * @param User $user
     */
    public function deleteInvoice(FinanceInvoice $invoice, User $user) {
        try {
            SQLObject::TransactionStart();

            $products = $this->getInvoiceProductsByInvoice($invoice);
            while ($product = $products->getNext()) {
                $product->delete();
            }

            $invoice->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }
    
    /**
     * Создать счет по заказу от клиента
     *
     * @param ShopOrder $order
     * @param User $cuser
     * @return FinanceInvoice
     */
    public function makeInvoiceByOrder(ShopOrder $order, User $cuser) {
        try {
            SQLObject::TransactionStart();

            $productArray = array();
            $orderProducts = $order->getOrderProducts();
            while ($op = $orderProducts->getNext()) {
            	$productArray[] = array(
            	'productid' => $op->getProductid(),
            	'productname' => $op->getProductname(),
            	'price' => $op->getProductprice(),
            	'currencyid' => $op->getCurrencyid(),
            	'amount' => $op->getProductcount()
            	);
            }
            
            $invoice = $this->addInvoice(
            $cuser,
            '',       
            $order->getUserid(), 
            $order->getContractorid(), 
            $order->getSum(), 
            $order->getCurrencyid(), 
            'out',
            false, 
            'order-'.$order->getId(), 
            $productArray
            );

            SQLObject::TransactionCommit();
            
            return $invoice;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * @param int $id
     * @return FinanceInvoiceProduct
     */
    public function getInvoiceProductByID($id) {
        try {
            return $this->getObjectByID($id, 'FinanceInvoiceProduct');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('FinanceInvoiceProduct by id not found');
    }

    /**
     * @return FinanceInvoiceProduct
     */
    public function getInvoiceProductsAll() {
        $x = new FinanceInvoiceProduct();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * @param FinanceInvoice $invoice
     * @return FinanceInvoiceProduct
     */
    public function getInvoiceProductsByInvoice(FinanceInvoice $invoice) {
        $x = $this->getInvoiceProductsAll();
        $x->setInvoiceid($invoice->getId());
        return $x;
    }

    /**
     * @return InvoiceService
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private static $_Instance = null;

}