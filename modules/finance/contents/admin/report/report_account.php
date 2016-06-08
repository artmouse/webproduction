<?php
class report_account extends Engine_Class {

    public function process() {
        $startDate = $this->getArgumentSecure('startdate');
        $endDate = $this->getArgumentSecure('enddate');
        
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
            $defaultCurrencyName = $defaultCurrency->getName();

            $payments = PaymentService::Get()->getPaymentsByUser($cuser);
            
            $payments->addWhereQuery('( DATE(`pdate`) >= \''.$startDate.'\' )');
            $payments->addWhereQuery('( DATE(`pdate`) <= \''.$endDate.'\' )');            
            
            while ($x = $payments->getNext()) {
                // Получаем акаунт. Если у записи нету акаунта, оносим ее к элементу массива "Без акаунта"
                // У Этих записей валютой является базовая валюта!!!
                $amount = $x->getAmount();
                if ($x->getAccountid()) {
                    $acauntname = FinanceService::Get()->getAccountByID($x->getAccountid())->getName();
                } else {
                    $acauntname = Shop::Get()->getTranslateService()->getTranslateSecure('translate_bez_akaunta');
                }

                // Разбираемся с текущей валютой.
                $account = new XFinanceAccount();
                $account->setId($x->getAccountid());
                if ($account->select()) {
                    $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($account->getCurrencyid());
                    $curencyName = $currency->getName();
                    @$a[$acauntname]['currency'] = $curencyName;
                } else {
                    @$a[$acauntname]['currency'] = $defaultCurrencyName;
                    $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
                }

                if ($x->getNoBalance()) {
                    $amount = 0;
                }

                if ($amount > 0) {
                    @$a[$acauntname]['it'] += $amount;
                    @$a[$acauntname]['balance'] += $amount;

                    $amount = Shop::Get()->getCurrencyService()->convertCurrency($amount, $currency, $defaultCurrency);
                    @$all['it'] += $amount;
                    @$all['balance'] += $amount;
                } else {
                    $amount *= -1;
                    @$a[$acauntname]['gone'] -= $amount;
                    @$a[$acauntname]['balance'] -= $amount;

                    $amount = Shop::Get()->getCurrencyService()->convertCurrency($amount, $currency, $defaultCurrency);
                    @$all['gone'] += $amount;
                    @$all['balance'] -= $amount;
                }
            }

            arsort($a);
            $this->setValue('table', $a);
            $this->setValue('all', $all);
            $this->setValue('defaultCurrency', $defaultCurrencyName);
        }

    }

}