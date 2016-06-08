<?php
/**
 * Сервис отвечающий за оплаты в модуле finance
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.ua>
 * 
 * @package module/finance
 */
class PaymentService extends ServiceUtils_AbstractService {

    /**
     * Получить оплату по ее номеру
     *
     * @param int $paymentID
     *
     * @return FinancePayment
     */
    public function getPaymentByID($paymentID) {
        try {
            return $this->getObjectByID($paymentID, 'FinancePayment');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('FinancePayment by id not found');
    }

    /**
     * Получить все платежи
     *
     * @return FinancePayment
     */
    public function getPaymentsAll() {
        $x = new FinancePayment();
        $x->setOrder('cdate', 'DESC');
        $x->setDeleted(0);
        return $x;
    }

    /**
     * Получить все платежи которые имеет право видеть пользователь
     *
     * @param User $user
     *
     * @return FinancePayment
     */
    public function getPaymentsByUser(User $user) {
        $x = $this->getPaymentsAll();

        $x->addWhereArray(
            FinanceService::Get()->getAccountIDsArrayByUser($user, 'view'),
            'accountid'
        );

        return $x;
    }

    /**
     * Получить все платежи по заказу
     *
     * @param ShopOrder $order
     *
     * @return FinancePayment
     */
    public function getPaymentsByOrder(ShopOrder $order) {
        $x = $this->getPaymentsAll();
        $x->setOrderid($order->getId());
        return $x;
    }

    /**
     * Получить все платежи по клиенту
     *
     * @param ShopOrder $order
     *
     * @return FinancePayment
     */
    public function getPaymentsByClient(User $user) {
        $x = $this->getPaymentsAll();
        $x->setClientid($user->getId());
        return $x;
    }

    /**
     * Получить все платежи по счету
     *
     * @param FinanceInvoice $invoice
     *
     * @deprecated
     *
     * @return FinancePayment
     */
    public function getPaymentsByInvoice(User $user, FinanceInvoice $invoice) {
        $x = $this->getPaymentsByUser($user);
        $x->setInvoiceid($invoice->getId());
        return $x;
    }

    /**
     * Получить сумму оплат по заказу.
     * Возвращает в валюте заказа.
     *
     * @param ShopOrder $order
     *
     * @return decimal
     */
    public function calculatePaymentSumByOrder(ShopOrder $order, $virtual = false) {
        $currencyOrder = $order->getCurrency();
        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

        $result = 0;

        $payments = $this->getPaymentsByOrder($order);
        while ($x = $payments->getNext()) {
            if ($x->getCurrencyid() == $currencyOrder->getId()) {
                // если валюта совпадает с валютой заказа
                $result += $x->getAmount();
            } elseif ($x->getOrderamountbase()) {
                // если задана сумма в валюте заказа
                $result += $x->getOrderamountbase();
            } else {
                // если валюта не совпадает
                $result += Shop::Get()->getCurrencyService()->convertCurrency(
                    $x->getAmountbase(),
                    $currencySystem,
                    $currencyOrder
                );
            }
        }

        if ($virtual) {
            $paymentsVirtual = new XFinanceProbation();
            $paymentsVirtual->setOrderid($order->getId());
            while ($x = $paymentsVirtual->getNext()) {
                $result += Shop::Get()->getCurrencyService()->convertCurrency(
                    $x->getAmountbase(),
                    $currencySystem,
                    $currencyOrder
                );
            }
        }

        $childs = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $childs->setParentid($order->getId());
        while ($x = $childs->getNext()) {
            if ($x->getId() != $x->getParentid()) {
                $tmp = $this->calculatePaymentSumByOrder($x);

                $result += Shop::Get()->getCurrencyService()->convertCurrency(
                    $tmp,
                    $x->getCurrency(),
                    $order->getCurrency()
                );
            }
        }

        return $result;
    }

    /**
     * Добавить новый платеж
     *
     * @param User $cuser
     * @param int $accountID
     * @param float $sum
     * @param string $direction
     * @param string $status
     * @param string $date
     * @param int $clientID
     * @param int $accountDirectionID
     * @param int $accountDirectionRate
     * @param int $categoryID
     * @param string $code
     * @param string $bankDetail
     * @param string $comment
     * @param int $invoiceID
     * @param array $file
     * @param string $linkkey
     * @param bool $noBalance
     * @param int $orderCurrencyID
     * @param int $orderId
     *
     * @return FinancePayment
     */
    public function addPayment(User $cuser, $accountID, $sum, $direction, $status, $date,
    $clientID, $accountDirectionID, $accountDirectionRate, $categoryID, $code, $bankDetail,
    $comment, $invoiceID, $file, $linkkey = false, $noBalance = false, $orderCurrencyID = false, $orderId = false) {

        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $sum = (float) $sum;
            $accountDirectionRate = (int) $accountDirectionRate;
            $comment = strip_tags($comment);
            $code = strip_tags($code);
            $bankDetail = strip_tags($bankDetail);

            if ($date) {
                $date = DateTime_Corrector::CorrectDateTime($date);
            }

            if ($sum <= 0) {
                $ex->addError('sum');
            }

            if ($accountDirectionRate < 0) {
                $ex->addError('accountDirectionRate');
            }

            // проверка аккаунта
            try {
                $account = FinanceService::Get()->getAccountByID($accountID);
                $currency = $account->getCurrency();
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('account');
            }

            // проверка ACL
            if ($cuser->isDenied('finance-account-'.$accountID.'-view')) {
                $ex->addError('permission');
            }
            if ($cuser->isDenied('finance-account-'.$accountID.'-control')) {
                $ex->addError('permission');
            }

            // проверка категории
            if ($categoryID) {
                try {
                    FinanceService::Get()->getCategoryByID($categoryID);
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('category');
                }
            }

            // проверка счета
            if ($invoiceID) {
                try {
                    InvoiceService::Get()->getInvoiceByID($invoiceID);
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('invoice');
                }
            }

            // проверка клиента
            if ($clientID || $direction == 'toclient' || $direction == 'fromclient') {
                try {
                    Shop::Get()->getUserService()->getUserByID($clientID);
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('client');
                }
            }

            // проверка аккаута при платеже между аккаунтами
            if ($accountDirectionID || $direction == 'fromaccount' || $direction == 'toaccount') {
                try {
                    FinanceService::Get()->getAccountByID($accountDirectionID);
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('accountDirection');
                }
            }

            if (!in_array($direction, array('toclient', 'fromclient', 'fromaccount', 'toaccount')) ||
            ($invoiceID && !in_array($direction, array('toclient', 'fromclient')))) {
                $ex->addError('direction');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $cdate = date('Y-m-d H:i:s');
            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // создаем платеж
            $payment = new FinancePayment();
            $payment->setOrderid($orderId);
            $payment->setCdate($cdate);
            $payment->setUserid($cuser->getId());
            $payment->setAccountid($accountID);
            $payment->setComment($comment);
            $payment->setCategoryid($categoryID);
            $payment->setCode($code);
            $payment->setBankdetail($bankDetail);
            $payment->setInvoiceid($invoiceID);
            $payment->setCurrencyrate($currency->getRate());
            $payment->setCurrencyid($currency->getId());
            $payment->setLinkkey($linkkey);
            $payment->setNoBalance($noBalance);

            // статус платежа
            if ($status == 'proceed') {
                if (!$date) {
                    $date = date('Y-m-d H:i:s');
                }
                $payment->setPdate($date);
            }
            if ($status == 'rejected') {
                $payment->setRdate(date('Y-m-d H:i:s'));
            }

            // сохраняем файл
            $filename = @$file['name'];
            $file = @$file['tmp_name'];
            if ($file) {
                $path = Shop::Get()->getShopService()->makeFileUploadUrl($file);
                copy($file, MEDIA_PATH.'shop/'.$path);
                $payment->setFile($path);

                $filename = trim(strip_tags($filename));
                $filename = str_replace(' ', '_', $filename);
                $payment->setFilename($filename);
            }

            // направление платежа

            // если направление платежа - клиенту
            // то сумма с минусом
            if ($direction == 'toclient') {
                $sum *= -1;

                // определяем цену в системной валюте
                $money = new ShopMoney($sum, $currency, 0);
                $sumBase = $money->changeCurrency($currencySystem)->getAmount();

                try {
                    $orderCurrency = Shop::Get()->getCurrencyService()->getCurrencyByID($orderCurrencyID);
                    $orderAmountBase = $money->changeCurrency($orderCurrency)->getAmount();
                    $payment->setOrderamountbase($orderAmountBase);
                } catch (ServiceUtils_Exception $se) {

                }

                $payment->setAmount($sum);
                $payment->setAmountbase($sumBase);
                $payment->setClientid($clientID);
                $payment->insert();
            } elseif ($direction == 'fromclient') {
                // если направление платежа - от клиента
                // то это обычное получение денег

                // определяем цену в системной валюте
                $money = new ShopMoney($sum, $currency, 0);
                $sumBase = $money->changeCurrency($currencySystem)->getAmount();

                try {
                    $orderCurrency = Shop::Get()->getCurrencyService()->getCurrencyByID($orderCurrencyID);
                    $orderAmountBase = $money->changeCurrency($orderCurrency)->getAmount();
                    $payment->setOrderamountbase($orderAmountBase);
                } catch (ServiceUtils_Exception $se) {

                }

                $payment->setAmount($sum);
                $payment->setAmountbase($sumBase);
                $payment->setClientid($clientID);
                $payment->insert();
            } elseif ($direction == 'fromaccount') {
                // если направление платежа - от аккаунта
                // то это перевод между аккаунтами

                $transferPayment = clone $payment;

                $transferAccount = FinanceService::Get()->getAccountByID($accountDirectionID);
                $transferCurrency = $transferAccount->getCurrency();

                $rateTo = FinanceService::Get()->getAccountByID($payment->getAccountid())->getCurrency()->getRate();
                if (!$accountDirectionRate) {
                    $rateFrom = $transferCurrency->getRate();
                } else {
                    $rateFrom = $accountDirectionRate;
                }

                // определяем цену в системной валюте
                $money = new ShopMoney($sum, $currency, 0);
                $sumBase = $money->changeCurrency($currencySystem)->getAmount();

                $transferAmount = round($sum * $rateTo / $rateFrom, 2);
                // определяем цену в системной валюте
                $money = new ShopMoney($transferAmount, $transferCurrency, 0);
                $transferAmountBase = $money->changeCurrency($currencySystem)->getAmount();

                $payment->setAmount($sum);
                $payment->setAmountbase($sumBase);
                $payment->insert();

                $transferPayment->setAmount(-$transferAmount);
                $transferPayment->setAmountbase(-$transferAmountBase);
                $transferPayment->setLinkkey('transfer-'.$payment->getId());
                $transferPayment->setAccountid($accountDirectionID);
                $transferPayment->setCurrencyrate($transferCurrency->getRate());
                $transferPayment->setCurrencyid($transferCurrency->getId());
                $transferPayment->insert();

                $payment->setLinkkey('transfer-'.$transferPayment->getId());
                $payment->update();
            } elseif ($direction == 'toaccount') {
                // если направление платежа - на аккаунт
                // то это перевод между аккаунтами

                $transferPayment = clone $payment;

                $transferAccount = FinanceService::Get()->getAccountByID($accountDirectionID);
                $transferCurrency = $transferAccount->getCurrency();

                $rateTo = FinanceService::Get()->getAccountByID($payment->getAccountid())->getCurrency()->getRate();
                if (!$accountDirectionRate) {
                    $rateFrom = $transferCurrency->getRate();
                } else {
                    $rateFrom = $accountDirectionRate;
                }

                // определяем цену в системной валюте
                $money = new ShopMoney($sum, $currency, 0);
                $sumBase = $money->changeCurrency($currencySystem)->getAmount();

                $transferAmount = round($sum * $rateTo / $rateFrom, 2);
                // определяем цену в системной валюте
                $money = new ShopMoney($transferAmount, $transferCurrency, 0);
                $transferAmountBase = $money->changeCurrency($currencySystem)->getAmount();

                $payment->setAmount(-$sum);
                $payment->setAmountbase(-$sumBase);
                $payment->insert();

                $transferPayment->setAmount($transferAmount);
                $transferPayment->setAmountbase($transferAmountBase);
                $transferPayment->setLinkkey('transfer-'.$payment->getId());
                $transferPayment->setAccountid($accountDirectionID);
                $transferPayment->setCurrencyrate($transferCurrency->getRate());
                $transferPayment->setCurrencyid($transferCurrency->getId());
                $transferPayment->insert();

                $payment->setLinkkey('transfer-'.$transferPayment->getId());
                $payment->update();
            }

            // комментарий к заказу
            if (preg_match("/^order-(\d+)$/ius", $linkkey, $r)) {
                $order = Shop::Get()->getShopService()->getOrderByID($r[1]);

                $payment->setOrderid($r[1]);
                $payment->update();

                if ($direction == 'fromclient') {
                    $content = "Получена";
                } elseif ($direction == 'toclient') {
                    $content = "Отправлена";
                }

                $content .= " оплата #{$payment->getId()}";
                $content .= " на сумму {$payment->getAmount()} {$payment->getCurrency()->getSymbol()}";
                Shop::Get()->getShopService()->addOrderNotify($order, $cuser, $content);
            }

            SQLObject::TransactionCommit();

            return $payment;
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Редактировать платеж
     *
     * @param FinancePayment $payment
     * @param User $cuser
     * @param int $accountID
     * @param decimal $sum
     * @param string $direction
     * @param string $status
     * @param string $date
     * @param int $clientID
     * @param int $accountDirectionID
     * @param int $accountDirectionRate
     * @param int $categoryID
     * @param string $code
     * @param string $bankDetail
     * @param string $comment
     * @param array $file
     * @param bool $deleteFile
     * @param string $linkkeyOrder
     * @param bool $noBalance
     * @param decimal $currencyRate
     * @param decimal $orderAmountBase
     *
     * @return FinancePayment
     */
    public function editPayment(FinancePayment $payment, User $cuser, $accountID, $sum,
    $direction, $status, $date, $clientID, $accountDirectionID, $accountDirectionRate,
    $categoryID, $code, $bankDetail, $comment, $file, $deleteFile, $linkkeyOrder, $noBalance,
    $currencyRate, $orderAmountBase = false) {

        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $sum = (float) $sum;
            $orderAmountBase = (float) $orderAmountBase;
            $currencyRate = (float) $currencyRate;
            $accountDirectionRate = (int) $accountDirectionRate;
            $comment = strip_tags($comment);
            $code = strip_tags($code);
            $bankDetail = strip_tags($bankDetail);

            if ($date) {
                $date = DateTime_Corrector::CorrectDateTime($date);
            }

            if ($sum <= 0) {
                $ex->addError('sum');
            }

            if ($accountDirectionRate < 0) {
                $ex->addError('accountDirectionRate');
            }

            // проверка аккаунта
            try {
                $account = FinanceService::Get()->getAccountByID($accountID);
                $currency = $account->getCurrency();

                if (!$currencyRate) {
                    $currencyRate = $currency->getRate();
                }
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('account');
            }

            // проверка ACL
            if ($cuser->isDenied('finance-account-'.$accountID.'-view')) {
                $ex->addError('permission');
            }
            if ($cuser->isDenied('finance-account-'.$accountID.'-control')) {
                $ex->addError('permission');
            }

            // проверка категории
            if ($categoryID) {
                try {
                    FinanceService::Get()->getCategoryByID($categoryID);
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('category');
                }
            }

            // проверка клиента
            if ($clientID || $direction == 'toclient' || $direction == 'fromclient') {
                try {
                    Shop::Get()->getUserService()->getUserByID($clientID);
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('client');
                }
            }

            // проверка аккаута при платеже между аккаунтами
            if ($accountDirectionID || $direction == 'fromaccount' || $direction == 'toaccount') {
                try {
                    FinanceService::Get()->getAccountByID($accountDirectionID);
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('accountDirection');
                }
            }

            if (!in_array($direction, array('toclient', 'fromclient', 'fromaccount', 'toaccount')) ||
            ($payment->getInvoiceid() && !in_array($direction, array('toclient', 'fromclient')))) {
                $ex->addError('direction');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $cdate = date('Y-m-d H:i:s');
            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // обновляем платеж
            $payment->setAccountid($accountID);
            $payment->setComment($comment);
            $payment->setCategoryid($categoryID);
            $payment->setCode($code);
            $payment->setBankdetail($bankDetail);
            $payment->setCurrencyrate($currencyRate);
            $payment->setCurrencyid($currency->getId());
            $payment->setNoBalance($noBalance);
            $payment->setOrderamountbase($orderAmountBase);

            try {
                $payment->getTransferPayment();

                $canEdit = false;
            } catch (Exception $transferEx) {
                $canEdit = true;
            }

            if ($canEdit) {
                if ($linkkeyOrder) {
                    $payment->setLinkkey('order-'.$linkkeyOrder);
                    $payment->setOrderid($linkkeyOrder);
                } else {
                    $payment->setLinkkey('');
                    $payment->setOrderid(0);
                }
            }

            // статус платежа
            if ($status == 'proceed') {
                if (!$date) {
                    $date = date('Y-m-d H:i:s');
                }
                $payment->setPdate($date);
                $payment->setRdate('');
            }
            if ($status == 'rejected') {
                $payment->setPdate('');
                $payment->setRdate(date('Y-m-d H:i:s'));
            }

            // сохраняем файл
            $filename = @$file['name'];
            $file = @$file['tmp_name'];

            if ($deleteFile) {
                $payment->setFile('');
            } elseif ($file) {
                $path = Shop::Get()->getShopService()->makeFileUploadUrl($file);
                copy($file, MEDIA_PATH.'shop/'.$path);
                $payment->setFile($path);

                $filename = trim(strip_tags($filename));
                $filename = str_replace(' ', '_', $filename);
                $payment->setFilename($filename);
            }

            // направление платежа

            // если направление платежа - клиенту
            // то сумма с минусом
            if ($direction == 'toclient') {
                $sum *= -1;

                $payment->setAmount($sum);
                $payment->setAmountbase(round($sum * $currencyRate / $currencySystem->getRate(), 2));
                $payment->setClientid($clientID);
                $payment->update();
            } elseif ($direction == 'fromclient') {
                // если направление платежа - от клиента
                // то это обычное получение денег

                $payment->setAmount($sum);
                $payment->setAmountbase(round($sum * $currencyRate / $currencySystem->getRate(), 2));
                $payment->setClientid($clientID);
                $payment->update();
            } elseif ($direction == 'fromaccount') {
                // если направление платежа - от аккаунта
                // то это перевод между аккаунтами

                $transferAccount = FinanceService::Get()->getAccountByID($accountDirectionID);
                $transferCurrency = $transferAccount->getCurrency();

                $rateTo = FinanceService::Get()->getAccountByID($payment->getAccountid())->getCurrency()->getRate();
                if (!$accountDirectionRate) {
                    $rateFrom = $transferCurrency->getRate();
                } else {
                    $rateFrom = $accountDirectionRate;
                }

                // определяем цену в системной валюте
                $money = new ShopMoney($sum, $currency, 0);
                $sumBase = $money->changeCurrency($currencySystem)->getAmount();

                $transferAmount = round($sum * $rateTo / $rateFrom, 2);
                // определяем цену в системной валюте
                $money = new ShopMoney($transferAmount, $transferCurrency, 0);
                $transferAmountBase = $money->changeCurrency($currencySystem)->getAmount();

                $payment->setAmount($sum);
                $payment->setAmountbase($sumBase);
                $payment->update();

                $transferPayment = $payment->getTransferPayment();
                $transferPayment->setComment($payment->getComment());
                $transferPayment->setCategoryid($payment->getCategoryid());
                $transferPayment->setCode($payment->getCode());
                $transferPayment->setBankdetail($payment->getBankdetail());
                $transferPayment->setPdate($payment->getPdate());
                $transferPayment->setRdate($payment->getRdate());
                $transferPayment->setFile($payment->getFile());
                $transferPayment->setFilename($payment->getFilename());

                $transferPayment->setAmount(-$transferAmount);
                $transferPayment->setAmountbase(-$transferAmountBase);
                $transferPayment->setAccountid($accountDirectionID);
                $transferPayment->setCurrencyrate($transferCurrency->getRate());
                $transferPayment->setCurrencyid($transferCurrency->getId());
                $transferPayment->update();
            } elseif ($direction == 'toaccount') {
                // если направление платежа - на аккаунт
                // то это перевод между аккаунтами

                $transferAccount = FinanceService::Get()->getAccountByID($accountDirectionID);
                $transferCurrency = $transferAccount->getCurrency();

                $rateTo = FinanceService::Get()->getAccountByID($payment->getAccountid())->getCurrency()->getRate();
                if (!$accountDirectionRate) {
                    $rateFrom = $transferCurrency->getRate();
                } else {
                    $rateFrom = $accountDirectionRate;
                }

                // определяем цену в системной валюте
                $money = new ShopMoney($sum, $currency, 0);
                $sumBase = $money->changeCurrency($currencySystem)->getAmount();

                $transferAmount = round($sum * $rateTo / $rateFrom, 2);
                // определяем цену в системной валюте
                $money = new ShopMoney($transferAmount, $transferCurrency, 0);
                $transferAmountBase = $money->changeCurrency($currencySystem)->getAmount();

                $payment->setAmount(-$sum);
                $payment->setAmountbase(-$sumBase);
                $payment->update();

                $transferPayment = $payment->getTransferPayment();
                $transferPayment->setComment($payment->getComment());
                $transferPayment->setCategoryid($payment->getCategoryid());
                $transferPayment->setCode($payment->getCode());
                $transferPayment->setBankdetail($payment->getBankdetail());
                $transferPayment->setPdate($payment->getPdate());
                $transferPayment->setRdate($payment->getRdate());
                $transferPayment->setFile($payment->getFile());
                $transferPayment->setFilename($payment->getFilename());

                $transferPayment->setAmount($transferAmount);
                $transferPayment->setAmountbase($transferAmountBase);
                $transferPayment->setAccountid($accountDirectionID);
                $transferPayment->setCurrencyrate($transferCurrency->getRate());
                $transferPayment->setCurrencyid($transferCurrency->getId());
                $transferPayment->update();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Удаление платежа
     *
     * @param FinancePayment $payment
     * @param User $cuser
     */
    public function deletePayment(FinancePayment $payment, User $cuser) {
        try {
            SQLObject::TransactionStart();

            // проверка ACL
            if ($cuser->isDenied('finance-account-'.$payment->getAccountid().'-view')) {
                throw new ServiceUtils_Exception('permission');
            }
            if ($cuser->isDenied('finance-account-'.$payment->getAccountid().'-control')) {
                throw new ServiceUtils_Exception('permission');
            }

            // удаление привязанной записи
            if ($payment->isTransfer()) {
                try {
                    $transferPayment = $payment->getTransferPayment();
                } catch (ServiceUtils_Exception $se) {

                }

                if (isset($transferPayment)) {
                    // проверка ACL
                    if ($cuser->isDenied('finance-account-'.$transferPayment->getAccountid().'-view')) {
                        throw new ServiceUtils_Exception('permission');
                    }
                    if ($cuser->isDenied('finance-account-'.$transferPayment->getAccountid().'-control')) {
                        throw new ServiceUtils_Exception('permission');
                    }

                    $transferPayment->setDeleted(1);
                    $transferPayment->update();
                    //$transferPayment->delete();
                }

            }

            $payment->setDeleted(1);
            $payment->update();
            //$payment->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Получить объект PaymentService
     *
     * @return PaymentService
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