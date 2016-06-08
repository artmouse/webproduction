<?php
class finance_payment_add extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();


        if ($this->getControlValue('ok') || $this->getArgumentSecure('oknext')) {

            $amount = StringUtils_FormatterPrice::format($this->getControlValue('amount'));
            // добавление
            try {
                PaymentService::Get()->addPayment(
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
                    $this->getArgumentSecure('invoiceid'),
                    $this->getControlValue('file'),
                    false,
                    $this->getArgumentSecure('noBalance'),
                    false,
                    $this->getControlValue('orderId')
                );

                $this->setValue('message', 'success');

                if ($this->getControlValue('ok')) {
                    $this->setValue(
                        'urlredirect',
                        Engine::GetLinkMaker()->makeURLByContentID(
                            'shop-finance-index'
                        )
                    );
                } else {
                    $this->setValue('clearFields', true);
                }

                // если сумма платежа +-10% ставим галочку (получен) в ожидаемых платежах
                $probation = new XFinanceProbation();
                $probation->addWhere('orderid', $this->getControlValue('orderId'), '=');
                while ($x = $probation->getNext()) {
                    $amountbase = $x->getAmountbase();
                    $percent = $amountbase - $amountbase*0.1;
                    if ($amount > $percent) {
                        $x->setReceived(1);
                        $x->update();
                    }
                }

            } catch (ServiceUtils_Exception $se) {
                $this->setValue('message', 'error');
                $this->setValue('errorArray', $se->getErrorsArray());

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
        } else {
            // по умолчанию платеж проведен
            $this->setControlValue('paymentStatus', 'proceed');
            $this->setControlValue('pdate', date('Y-m-d H:i:s'));
        }

        // Аккаунты
        $accounts = FinanceService::Get()->getAccountsActive();
        if (isset($invoice)) {
            // если создается платеж привязанный к счету,
            // аккаунт может быть только юр лица из счета
            $accounts->setContractorid($invoice->getContractorid());
        }
        $a = array();
        while ($x = $accounts->getNext()) {
            if ($this->getUser()->isDenied('finance-account-'.$x->getId().'-control')) {
                continue;
            }
            try {
                $a[$x->getContractor()->getName()][] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName()
                );
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
    }

}