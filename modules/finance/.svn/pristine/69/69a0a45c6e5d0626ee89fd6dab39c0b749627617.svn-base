<?php
class report_balance extends Engine_Class {

    public function process() {
        $startDate = $this->getArgumentSecure('startdate');
        $endDate = $this->getArgumentSecure('enddate');
        $clientID = $this->getArgumentSecure('clientid');

        $cuser = $this->getUser();

        if (!$startDate && !$endDate) {
            $this->setValue('text', true);
        }

        if (!$startDate) {
            $startDate = date("Y-m-d", time()-60*60*24*14);
            $this->setControlValue('startdate', $startDate);
        }

        if (!$endDate) {
            $endDate = date("Y-m-d");
            $this->setControlValue('enddate', $endDate);
        }

        $startDate = DateTime_Corrector::CorrectDate($startDate);
        $endDate = DateTime_Corrector::CorrectDate($endDate);

        if ($startDate || $endDate) {
            $a = array();
            $all = array();

            $defaultCurrency = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('currency', $defaultCurrency->getName());

            // платежи
            $payments = PaymentService::Get()->getPaymentsByUser($cuser);
            if ($clientID) {
                $payments->setClientid($clientID);
            }
            $payments->addWhereQuery('( DATE(`pdate`) >= \''.$startDate.'\' )');
            $payments->addWhereQuery('( DATE(`pdate`) <= \''.$endDate.'\' )');

            while ($x = $payments->getNext()) {
                $amount = $x->getAmount();

                $account = new XFinanceAccount();
                $account->setId($x->getAccountid());
                if ($account->select()) {
                    $curency = Shop::Get()->getCurrencyService()->getCurrencyByID($account->getCurrencyid());
                } else {
                    $curency = Shop::Get()->getCurrencyService()->getCurrencySystem();
                }

                $amount = Shop::Get()->getCurrencyService()->convertCurrency($amount, $curency, $defaultCurrency);

                if ($amount > 0) {
                    @$a[$x->getClientid()]['payments_out'] += $amount;
                    @$all['payments_out'] += $amount;
                } else {
                    @$a[$x->getClientid()]['payments_in'] += $amount;
                    @$all['payments_in'] += $amount;
                }
            }

            // счета
            $invoices = InvoiceService::Get()->getInvoicesAll();
            if ($clientID) {
                $invoices->setClientid($clientID);
            }
            $invoices->addWhereQuery('( DATE(`date`) >= \''.$startDate.'\' )');
            $invoices->addWhereQuery('( DATE(`date`) <= \''.$endDate.'\' )');

            while ($x = $invoices->getNext()) {
                $amount = $x->getSum();
                $curency = $x->getCurrency();

                $amount = Shop::Get()->getCurrencyService()->convertCurrency($amount, $curency, $defaultCurrency);

                if ($x->getType() == 'out') {
                    @$a[$x->getClientid()]['invoices_out'] += $amount;
                    @$all['invoices_out'] += $amount;
                } else {
                    @$a[$x->getClientid()]['invoices_in'] += $amount;
                    @$all['invoices_in'] += $amount;
                }
            }

            // баланс
            $payments = PaymentService::Get()->getPaymentsByUser($cuser);
            if ($clientID) {
                $payments->setClientid($clientID);
            }
            $payments->addWhere('pdate', '0000-00-00 00:00:00', '>');
            $payments->addWhereQuery('( DATE(`pdate`) < \''.$startDate.'\' )');

            // получаем суммы платежей для баланса
            while ($x = $payments->getNext()) {
                $amount = $x->getAmount();

                $account = new XFinanceAccount();
                $account->setId($x->getAccountid());
                if ($account->select()) {
                    $curency = Shop::Get()->getCurrencyService()->getCurrencyByID($account->getCurrencyid());
                } else {
                    $curency = Shop::Get()->getCurrencyService()->getCurrencySystem();
                }

                $amount = Shop::Get()->getCurrencyService()->convertCurrency($amount, $curency, $defaultCurrency);

                @$a[$x->getClientid()]['balance_start']['payments'] += $x->getAmount();
            }
            
            // получаем суммы счетов для баланса
            $invoices = InvoiceService::Get()->getInvoicesAll();
            if ($clientID) {
                $invoices->setClientid($clientID);
            }
            $invoices->addWhereQuery('( DATE(`date`) < \''.$startDate.'\' )');
            
            while ($x = $invoices->getNext()) {
                $amount = $x->getSum();
                if ($x->getType() == 'in') {
                    $amount = -$amount;
                }

                $amount = Shop::Get()->getCurrencyService()->convertCurrency($amount, $x->getCurrency(), $defaultCurrency);

                @$a[$x->getClientid()]['balance_start']['invoices'] += $amount;
            }
            
            // считаем балансы
            foreach ($a as $k => $el) {
                $balance_start = 0;
                $balance_start = @$el['balance_start']['invoices'] - @$el['balance_start']['payments'];
                @$a[$k]['balance_start'] = $balance_start;
                @$all['balance_start'] += $balance_start;
                
                $balance_end = $balance_start + @$a[$k]['invoices_out'] - @$a[$k]['invoices_in'] - 
                @$a[$k]['payments_out'] - @$a[$k]['payments_in'];
                @$a[$k]['balance_end'] = $balance_end;
                @$all['balance_end'] += $balance_end;
            }

            arsort($a);
            $this->setValue('table', $a);
            $this->setValue('all', $all);
            
            $clients = Shop::Get()->getUserService()->getUsersAll();
            $clients->addWhereQuery('(`id` IN (SELECT `clientid` FROM `financepayment`) OR `id` IN (SELECT `clientid` FROM `financeinvoice`))');
            $a = array();
            while ($client = $clients->getNext()) {
                $a[$client->getId()] = array(
                'name' => $client->makeName(),
                'id' => $client->getId()
                );
            }
            
            $this->setValue('clientArray', $a);
        }
    }

}