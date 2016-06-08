<?php
class finance_payment_block extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();
            $linkkey = $this->getValue('linkkey');

            if (!$linkkey) {
                throw new ServiceUtils_Exception($se);
            }

            $order = $this->_getObjectByLinkkey($linkkey);

            // текущий авторизированный пользователь
            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $cuser);
            $this->setValue('canEdit', $canEdit);

            if (($this->getControlValue('paymentadd')
            || $this->getArgumentSecure('ok'))
            ) {
                // добавление
                $amount = StringUtils_FormatterPrice::format($this->getControlValue('amount'));

                try {
                    $payment = PaymentService::Get()->addPayment(
                        $cuser,
                        $this->getControlValue('accountid'),
                        $amount,
                        $this->getControlValue('paymentdirection'),
                        'proceed',
                        $this->getControlValue('pdate'),
                        $order->getUserid(),
                        false,
                        false,
                        $this->getControlValue('paymentcategoryid'),
                        $this->getControlValue('code'),
                        $this->getControlValue('bankdetail'),
                        $this->getControlValue('comment'),
                        $this->getControlValue('invoiceid'),
                        $this->getControlValue('file'),
                        $linkkey,
                        $this->getArgumentSecure('noBalance'),
                        $order->getCurrencyid()
                    );
                } catch (ServiceUtils_Exception $se) {
                    $this->setValue('message_block_payment', 'error');
                    $this->setValue('errorArray', $se->getErrorsArray());
                }
            } else {
                // по умолчанию платеж проведен
                $this->setControlValue('paymentStatus', 'proceed');
                $this->setControlValue('pdate', date('Y-m-d H:i:s'));
            }

            if ($this->getArgumentSecure('probationadd')) {
                $amount = $this->getArgumentSecure('amountprobation');
                $currencyId = $this->getArgumentSecure('currency');
                $date = $this->getArgumentSecure('date');
                if ($amount && $currencyId && $date) {
                    if ($this->getArgumentSecure('probationpaymentdirection') == 'toclient') {
                        $amount *= -1;
                    }

                    try {
                        $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyId);
                        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

                        // определяем цену в системной валюте
                        $money = new ShopMoney($amount, $currency, 0);
                        $amountBase = $money->changeCurrency($currencySystem)->getAmount();

                        $probation = new XFinanceProbation();
                        $probation->setAmount($amount);
                        $probation->setAmountbase($amountBase);
                        $probation->setCurrencyid($currencyId);
                        $probation->setPdate($date);
                        $probation->setCdate(DateTime_Object::Now());
                        $probation->setManagerid($this->getUser()->getId());
                        $probation->setOrderid($order->getId());
                        $probation->setAccountid($this->getArgumentSecure('accountid'));
                        $probation->setContractorid($this->getArgumentSecure('contractorid'));
                        $probation->insert();
                    } catch (ServiceUtils_Exception $pe) {

                    }
                } else {
                    $errorArray = array();
                    if (!$amount) {
                        $errorArray[] = 'probationAmount';
                    }
                    if (!$date) {
                        $errorArray[] = 'probationDate';
                    }
                    $this->setValue('message_block_probation', 'error');
                    $this->setValue('errorArray', $errorArray);
                }
            }

            if ($deleteId = $this->getArgumentSecure('probationDelete')) {
                FinanceService::Get()->deleteProbationById($deleteId);
            }

            // update contractor when get argument from hidden input
            if ($canEdit && $this->getArgumentSecure('contractorsend')) {
                try {
                    $contractor = Shop::Get()->getShopService()->getContractorByID(
                        $this->getControlValue('contractor')
                    );
                    $order->setContractorid($contractor->getId());
                } catch (Exception $e) {
                    $order->setContractorid(0);
                }
                $order->update();
            }

            // ожидаемые платежи
            $probationArray = array();
            $probation = new XFinanceProbation();
            $probation->setOrder('pdate');
            $probation->setOrderid($order->getId());
            while ($x = $probation->getNext()) {
                try{
                    $probationArray[] = array(
                        'id' => $x->getId(),
                        'date' => $x->getPdate(),
                        'sum' => $x->getAmount(),
                        'currency' => Shop::Get()->getCurrencyService()->getCurrencyByID($x->getCurrencyid())
                            ->getName(),
                        'parentId' => $order->getId(),
                        'parentName' => $order->getName(),
                        'parentUrl' => $order->makeURLEdit(),
                        'received' => $x->getReceived()
                    );
                } catch (Exception $e) {

                }
                
            }
            $this->setValue('probationArray', $probationArray);

            // валюты
            $currencyArray = array();
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $currency->setHidden(0);
            while ($x = $currency->getNext()) {
                $currencyArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
                );
            }

            $this->setValue('currencyArray', $currencyArray);

            $payments = PaymentService::Get()->getPaymentsByOrder($order);
            $a = array();
            while ($x = $payments->getNext()) {
                try {
                    $author = $x->getUser();
                    $authorName = $author->makeName(false, 'lfm');
                    $authorURL = $author->makeURLEdit();
                } catch (Exception $e) {
                    $authorName = false;
                    $authorURL = false;
                }

                $accountArray = array();
                try {
                    $account = $x->getAccount();
                    $accountArray = array(
                        'url' => $account->makeURL(),
                        'name' => $account->getName(),
                    );

                } catch (Exception $e) {

                }

                try {
                    $a[] = array(
                    'pdate' => DateTime_Formatter::DateTimeISO9075($x->getPdate()),
                    'cdate' => DateTime_Formatter::DateTimeISO9075($x->getCdate()),
                    'amount' => $x->getAmount(),
                    'currency' => $x->getCurrency()->getName(),
                    'id' => $x->getId(),
                    'noBalance' => $x->getNoBalance(),
                    'url' => Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-finance-payment-control', $x->getId(), 'key'
                    ),
                    'userId' => $x->getUserid(),
                    'userName' => $authorName,
                    'userUrl' => $authorURL,
                    'parentId' => $order->getId(),
                    'parentName' => $order->getName(),
                    'parentUrl' => $order->makeURLEdit(),
                    'account' => $accountArray
                    );
                } catch (Exception $e) {

                }
            }

            // общая статистика
            $this->setValue('sum', $order->makeSum());
            $this->setValue('sumPaid', $order->makeSumPaid());
            $this->setValue('sumBalance', $order->makeSumBalance());

            // подзадачи
            $b = array();
            $probationChildArray = array();
            $paymentsChildArray = Shop::Get()->getShopService()->getOrderChilds($order);
            foreach ($paymentsChildArray as $orderChild) {
                try{
                    if (!$orderChild) {
                        continue;
                    }

                    // Ожидаемые платежи
                    $probation = new XFinanceProbation();
                    $probation->setOrder('pdate');
                    $probation->setOrderid($orderChild->getId());
                    while ($x = $probation->getNext()) {
                        try{
                            $probationChildArray[] = array(
                                'id' => $x->getId(),
                                'date' => $x->getPdate(),
                                'sum' => $x->getAmount(),
                                'currency' => Shop::Get()->getCurrencyService()->getCurrencyByID(
                                    $x->getCurrencyid()
                                )->getName(),
                                'parentId' => $orderChild->getId(),
                                'parentName' => $orderChild->getName(),
                                'parentUrl' => $orderChild->makeURLEdit()
                            );
                        } catch (Exception $e) {

                        }

                    }

                    // Платежи
                    $payments = PaymentService::Get()->getPaymentsByOrder($orderChild);
                    while ($x = $payments->getNext()) {
                        try {
                            $author = $x->getUser();
                            $authorName = $author->makeName(false, 'lfm');
                            $authorURL = $author->makeURLEdit();
                        } catch (Exception $e) {
                            $authorName = false;
                            $authorURL = false;
                        }

                        $accountArray = array();
                        try {
                            $account = $x->getAccount();
                            $accountArray = array(
                                'url' => $account->makeURL(),
                                'name' => $account->getName(),
                            );

                        } catch (Exception $e) {

                        }

                        try {
                            $b[] = array(
                                'pdate' => DateTime_Formatter::DateTimeISO9075($x->getPdate()),
                                'cdate' => DateTime_Formatter::DateTimeISO9075($x->getCdate()),
                                'amount' => $x->getAmount(),
                                'currency' => $x->getCurrency()->getName(),
                                'id' => $x->getId(),
                                'noBalance' => $x->getNoBalance(),
                                'url' => Engine::GetLinkMaker()->makeURLByContentIDParam(
                                    'shop-finance-payment-control', $x->getId(), 'key'
                                ),
                                'userId' => $x->getUserid(),
                                'userName' => $authorName,
                                'userUrl' => $authorURL,
                                'parentId' => $orderChild->getId(),
                                'parentName' => $orderChild->getName(),
                                'parentUrl' => $orderChild->makeURLEdit(),
                                'account' => $accountArray
                            );
                        } catch (Exception $e) {

                        }
                    }


                } catch (Exception $e) {

                }
            }
            $this->setValue('paymentArray', $a);
            $this->setValue('paymentChildArray', $b);
            $this->setValue('probationChildArray', $probationChildArray);
            $this->setControlValue('contractorid', $order->getContractorid());

            // view contractor in block payments
            $contractors = Shop::Get()->getShopService()->getContractorsActive();
            $this->setValue('contractorArray', $contractors->toArray());
            try {
                $this->setValue('contractorName', $order->getContractor()->makeName());
            } catch (Exception $e) {

            }

            // валюта заказа
            $currency = $order->getCurrency();
            $this->setValue('currency', $currency->getName());

            // Аккаунты
            $accounts = FinanceService::Get()->getAccountsActive();
            if ($order->getContractorid()) {
                // если создается платеж привязанный к счету,
                // аккаунт может быть только юр лица из счета
                $accounts->setContractorid($order->getContractorid());
            }
            $a = array();
            while ($x = $accounts->getNext()) {
                if ($this->getUser()->isDenied('finance-account-'.$x->getId().'-control')) {
                    continue;
                }

                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
                );
            }
            $this->setValue('accountArray', $a);

            // Категория
            $categories = FinanceService::Get()->getCategoryAll();
            $categories->setActive(1);
            $a = array();
            while ($x = $categories->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
                );
            }
            $this->setValue('categoryArray', $a);
        } catch (Exception $e) {

        }
    }

    /**
     * GetObjectByLinkkey
     *
     * @param string $linkkey
     *
     * @return ShopOrder
     */
    private function _getObjectByLinkkey($linkkey) {
        preg_match("/^(\w+)-(\d+)$/ius", $linkkey, $r);
        if (!isset($r[1]) || !isset($r[2])) {
            throw new ServiceUtils_Exception();
        }

        if ($r[1] == 'order') {
            return Shop::Get()->getShopService()->getOrderByID($r[2]);
        }

        throw new ServiceUtils_Exception();

    }

}