<?php
class finance_payment_control extends Engine_Class {

    public function process() {
        try {
            $payment = PaymentService::Get()->getPaymentByID(
                $this->getArgument('key')
            );

            $cuser = $this->getUser();

            // проверка ACL
            if ($cuser->isDenied('finance-account-'.$payment->getAccountid().'-view')) {
                throw new ServiceUtils_Exception();
            }
            if ($cuser->isDenied('finance-account-'.$payment->getAccountid().'-control')) {
                throw new ServiceUtils_Exception();
            }

            // если есть связанный платеж
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
                }
            }

            $this->setValue('id', $payment->getId());

            if ($this->getArgumentSecure('delete')) {
                try {
                    if ($cuser->isDenied('finance-account-'.$payment->getAccountid().'-delete')) {
                        throw new ServiceUtils_Exception();
                    }

                    // удаление
                    PaymentService::Get()->deletePayment($payment, $cuser);

                    header("Location: /admin/shop/finance/");
                    exit();
                } catch (ServiceUtils_Exception $de) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorArray', $de->getErrorsArray());
                }
            }

            if ($this->getArgumentSecure('ok')) {
                try {
                    $amount = StringUtils_FormatterPrice::format($this->getControlValue('amount'));

                    // редактирование
                    PaymentService::Get()->editPayment(
                        $payment,
                        $cuser,
                        $this->getControlValue('accountid'),
                        $amount,
                        $this->getControlValue('direction'),
                        'proceed',
                        $this->getControlValue('pdate'),
                        $this->getControlValue('clientid'),
                        $this->getControlValue('accountdirectionid'),
                        $this->getControlValue('accountrate'),
                        $this->getControlValue('categoryid'),
                        $this->getControlValue('code'),
                        $this->getControlValue('bankdetail'),
                        $this->getControlValue('comment'),
                        $this->getControlValue('file'),
                        $this->getControlValue('deletefile'),
                        $this->getControlValue('linkkeyorder'),
                        $this->getArgumentSecure('noBalance'),
                        $this->getControlValue('currencyrate'),
                        $this->getControlValue('orderamountbase')
                    );

                    $this->setValue('message', 'success');
                } catch (Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorArray', $e->getErrors());

                    // чтобы не слетали поля
                    try {
                        // возвращаем клиента
                        $client = Shop::Get()->getUserService()->getUserByID(
                            $this->getControlValue('clientid')
                        );

                        $this->setValue('client', $client->makeName());
                    } catch (ServiceUtils_Exception $ce) {

                    }
                }

            }

            // передаем данные о платеже
            $this->setControlValue('accountid', $payment->getAccountid());
            $this->setControlValue('amount', abs($payment->getAmount()));
            $this->setControlValue('comment', $payment->getComment());
            $this->setControlValue('categoryid', $payment->getCategoryid());
            $this->setControlValue('code', $payment->getCode());
            $this->setControlValue('bankdetail', $payment->getBankdetail());
            $this->setControlValue('noBalance', $payment->getNoBalance());
            $this->setControlValue('currencyrate', $payment->getCurrencyrate());

            try {
                $order = $payment->getOrder();
                $this->setControlValue('linkkeyorder', $order->getId());
                $this->setControlValue('orderamountbase', $payment->getOrderamountbase());
            } catch (Exception $e) {

            }

            try {
                $payment->getTransferPayment();

                $this->setValue('canEditLinkOrder', false);
            } catch (Exception $e) {
                $this->setValue('canEditLinkOrder', true);
            }

            $this->setValue('canDelete', $cuser->isAllowed('finance-account-'.$payment->getAccountid().'-delete'));

            // статус платежа
            if (Checker::CheckDate($payment->getPdate())) {
                $this->setControlValue('paymentStatus', 'proceed');
                $this->setControlValue('pdate', $payment->getPdate());
            } elseif (Checker::CheckDate($payment->getRdate())) {
                $this->setControlValue('paymentStatus', 'rejected');
                $this->setControlValue('rdate', $payment->getRdate());
            } else {
                $this->setControlValue('paymentStatus', 'undefined');
            }

            // файл
            if ($payment->getFile()) {
                $this->setValue('fileName', htmlspecialchars($payment->getFilename()));
                $this->setValue(
                    'fileURL', 
                    Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-finance-payment-download',
                        $payment->getId(),
                        'key'
                    )
                );
            }

            // направление платежа
            $this->setValue('isTransfer', $payment->isTransfer());
            if ($payment->isTransfer()) {
                try {
                    if ($payment->getAmount() >= 0) {
                        $this->setControlValue('direction', 'fromaccount');
                    } else {
                        $this->setControlValue('direction', 'toaccount');
                    }

                    $transferPayment = $payment->getTransferPayment();
                    $this->setControlValue('accountdirectionid', $transferPayment->getAccountid());
                } catch (ServiceUtils_Exception $te) {

                }
            } else {
                if ($payment->getAmount() >= 0) {
                    $this->setControlValue('direction', 'fromclient');
                } else {
                    $this->setControlValue('direction', 'toclient');
                }

                try {
                    $this->setControlValue('clientid', $payment->getClientid());
                    $this->setValue('client', $payment->getClient()->makeName());
                } catch (Exception $clientEx) {

                }
            }


            // Аккаунты (тут уже все, а не только активные, так как это редактирование)
            $accounts = FinanceService::Get()->getAccountsAll();
            $a = array();
            while ($x = $accounts->getNext()) {
                if ($this->getUser()->isDenied('finance-account-'.$x->getId().'-control')) {
                    continue;
                }

                try {
                    //надо только активные или текущий аккаунт платежа (если он закрыт)
                    if ($x->getActive() == 1 || $x->getId() == $payment->getAccountid()) {
                        $a[$x->getContractor()->getName()][] = array(
                            'id' => $x->getId(),
                            'name' => $x->getName()
                        );
                    }
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
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
        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}