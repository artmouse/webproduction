<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class FinanceService extends ServiceUtils_AbstractService {

    /**
     * GetAccountByID
     *
     * @param int $accountID
     *
     * @return FinanceAccount
     */
    public function getAccountByID($accountID) {
        try {
            return $this->getObjectByID($accountID, 'FinanceAccount');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('FinanceAccount by id not found');
    }

    /**
     * GetCategoryByID
     *
     * @param int $categoryID
     *
     * @return FinanceCategory
     */
    public function getCategoryByID($categoryID) {
        try {
            return $this->getObjectByID($categoryID, 'FinanceCategory');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('FinanceCategory by id not found');
    }

    /**
     * GetAccountsAll
     *
     * @return FinanceAccount
     */
    public function getAccountsAll() {
        $x = new FinanceAccount();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * GetAccountsActive
     *
     * @return FinanceAccount
     */
    public function getAccountsActive() {
        $x = $this->getAccountsAll();
        $x->setActive(1);
        return $x;
    }

    /**
     * GetCategoryAll
     *
     * @return FinanceCategory
     */
    public function getCategoryAll() {
        $x = new FinanceCategory();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * Добавить акккаунт
     *
     * @param User $cuser
     * @param string $name
     * @param string $description
     * @param int $currencyID
     * @param bool $active
     * @param int $contractorID
     * @param float $balancestart
     *
     * @return FinanceAccount
     */
    public function addAccount(User $cuser, $name, $description, $currencyID, $active,
    $contractorID, $balancestart) {
        $cuser;

        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $balancestart = (float) $balancestart;
            $name = trim(strip_tags($name));
            $description = strip_tags($description);

            // проверка имени
            if (!$name) {
                $ex->addError('name');
            }

            // проверка уникальности имени
            $x = $this->getAccountsAll();
            $x->setName($name);
            if ($x->select()) {
                $ex->addError('exists');
            }

            // проверка валюты
            try {
                Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('currency');
            }

            // проверка юр лица
            try {
                Shop::Get()->getShopService()->getContractorByID($contractorID);
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('contractor');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            // создаем аккаунт
            $account = new FinanceAccount();
            $account->setName($name);
            $account->setDescription($description);
            $account->setCurrencyid($currencyID);
            $account->setActive($active);
            $account->setContractorid($contractorID);
            $account->setBalancestart($balancestart);
            $account->insert();

            SQLObject::TransactionCommit();

            return $account;
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Редактировать акккаунт
     *
     * @param User $cuser
     * @param FinanceAccount $account
     * @param string $name
     * @param string $description
     * @param int $currencyID
     * @param bool $active
     * @param int $contractorID
     * @param float $balancestart
     */
    public function editAccount(FinanceAccount $account, User $cuser, $name,
    $description, $currencyID, $active, $contractorID, $balancestart) {
        $cuser;
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $balancestart = (float) $balancestart;
            $name = trim(strip_tags($name));
            $description = strip_tags($description);

            // проверка имени
            if (!$name) {
                $ex->addError('name');
            }

            // проверка уникальности имени
            $x = $this->getAccountsAll();
            $x->setName($name);
            $x->addWhere('id', $account->getId(), '<>');
            if ($x->getNext()) {
                $ex->addError('exists');
            }

            // проверка валюты
            try {
                Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('currency');
            }

            // проверка юр лица
            try {
                Shop::Get()->getShopService()->getContractorByID($contractorID);
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('contractor');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            // создаем аккаунт
            $account->setName($name);
            $account->setDescription($description);
            $account->setCurrencyid($currencyID);
            $account->setActive($active);
            $account->setContractorid($contractorID);
            $account->setBalancestart($balancestart);
            $account->update();

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Удалить аккаунт
     *
     * @param FinanceAccount $account
     * @param User $cuser
     */
    public function deleteAccount(FinanceAccount $account, User $cuser) {
        $cuser;
        try {
            SQLObject::TransactionStart();

            // проверка
            $x = PaymentService::Get()->getPaymentsAll();
            $x->setAccountid($account->getId());
            if ($x->select()) {
                throw new ServiceUtils_Exception('payment');
            }

            $account->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }
    
    /**
     * GetProbationsAll
     *
     * @return XFinanceProbation
     */
    public function getProbationsAll() {
        return $this->getObjectsAll('XFinanceProbation');
    }

    /**
     * Удалить ожидаемый платеж по ID
     *
     * @param XFinanceProbation $probation
     *
     * @throws Exception
     */
    public function deleteProbationById($probationId) {
        try {

            $probation = new XFinanceProbation($probationId);
            $probation->delete();

        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * CalculateAccountBalance
     *
     * @param FinanceAccount $account
     *
     * @return float
     */
    public function calculateAccountBalance(FinanceAccount $account) {
        $balance = $account->getBalancestart();

        $payments = PaymentService::Get()->getPaymentsAll();
        $payments->addWhere('pdate', '0000-00-00 00:00:00', '>');
        $payments->setAccountid($account->getId());
        $payments->setNoBalance(0);
        while ($x = $payments->getNext()) {
            $balance += $x->getAmount();
        }

        $balance = round($balance, 2);
        return $balance;
    }

    /**
     * Разрешено ли просматривать платежи аккаунт
     *
     * @param User $cuser
     * @param FinanceAccount $account
     *
     * @return bool
     */
    public function isAccountViewAllowed(User $cuser, FinanceAccount $account) {
        return $cuser->isAllowed('finance-account-'.$account->getId().'-view');
    }

    /**
     * Разрешено ли создавать платежи аккаунта
     *
     * @param User $cuser
     * @param FinanceAccount $account
     *
     * @return bool
     */
    public function isAccountControlAllowed(User $cuser, FinanceAccount $account) {
        return $cuser->isAllowed('finance-account-'.$account->getId().'-control');
    }

    /**
     * Получить массив ID аккаунтов, в которых пользователю разрешена операция
     *
     * @param User $cuser
     * @param string $operation
     *
     * @return array
     */
    public function getAccountIDsArrayByUser(User $cuser, $operation) {
        $accounts = $this->getAccountsAll();
        $accountIDArray = array(-1);
        while ($account = $accounts->getNext()) {
            if ($cuser->isAllowed('finance-account-'.$account->getId().'-'.$operation)) {
                $accountIDArray[] = $account->getId();
            }
        }
        return $accountIDArray;
    }

    /**
     * Получить массив аккаунтов
     * (для быстрого доступа к данным аккаунтов)
     *
     * @return array
     */
    public function getAccountArray() {
        if (!$this->_accountArray) {

            $accounts = $this->getAccountsAll();

            $accountArray = array();
            while ($account = $accounts->getNext()) {
                try {
                    $accountArray[$account->getId()] = array(
                    'name' => $account->getName(),
                    'currencyid' => $account->getCurrencyid(),
                    'currencyname' => $account->getCurrency()->getName()
                    );
                } catch (ServiceUtils_Exception $se){

                }
            }

            $this->_accountArray = $accountArray;
        }
        return $this->_accountArray;
    }

    /**
     * Обновить суммы фондов
     */
    public function updateCategoriesCache() {
        try {
            SQLObject::TransactionStart(false, true);

            $categories = $this->getCategoryAll();
            while ($category = $categories->getNext()) {
                if (!$category->getFundpercent() && !$category->getFundsum()) {
                    continue;
                }
                
                $lastPaymentID = $category->getLastpaymentid();

                $payments = PaymentService::Get()->getPaymentsAll();
                $payments->addWhere('id', $lastPaymentID, '>');
                $payments->setOrder('id', 'ASC');
                $payments->setNoBalance(0);
                
                while ($payment = $payments->getNext()) {                    
                    $lastPaymentID = $payment->getId();

                    if ($payment->isTransfer()) {
                        continue;
                    }
                                       
                    $paymentSum = $payment->getAmountbase();
                    $fundSum = 0;

                    if ($payment->getCategoryid() == $category->getId()) {
                        $fundSum = $paymentSum;
                    }

                    if (!$payment->getCategoryid() && $category->getFundpercent() > 0) {
                        $fundSum = $paymentSum * $category->getFundpercent() / 100;
                    }

                    if (!$payment->getCategoryid() && $category->getFundsum() > 0) {
                        if ($paymentSum > 0) {
                            $fundSum = ($category->getFundsum() < $paymentSum)?$category->getFundsum():$paymentSum;
                        } else {
                            $fundSum = ($category->getFundsum() < -$paymentSum)?-$category->getFundsum():$paymentSum;
                        }
                    }

                    $fundTotal = $category->getFundtotal() + $fundSum;

                    $category->setFundtotal($fundTotal);
                }
                
                $category->setLastpaymentid($lastPaymentID);
                $category->update();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Get
     *
     * @return FinanceService
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

    private $_accountArray = array();

}