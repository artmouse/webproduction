<?php
class user_finance_block extends Engine_Class {

    public function process() {
        $userIDArray = $this->getValue('userIDArray');

        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
        $orders->addWhereArray($userIDArray, 'userid');
        $totalSumPayed = 0;
        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
        while ($x = $orders->getNext()) {
            try {
                $totalSum = Shop::Get()->getCurrencyService()->convertCurrency(
                    $x->getSum(),
                    $x->getCurrency(),
                    $currencySystem
                );

                if ($x->getOutcoming()) {
                    if ($x->getStatus()->getPayed() || $x->getStatus()->getPrepayed()) {
                        $totalSumPayed += $totalSum;
                    }
                } else {
                    if ($x->getStatus()->getPayed() || $x->getStatus()->getPrepayed()) {
                        $totalSumPayed -= $totalSum;
                    }
                }
            } catch (Exception $ex) {

            }
        }

        $payments = PaymentService::Get()->getPaymentsAll();
        $payments->addWhereArray($userIDArray, 'clientid');
        $sumIn = 0;
        $sumOut = 0;
        $cntIn = 0;
        $cntOut = 0;
        while ($x = $payments->getNext()) {
            if ($x->getAmountbase() > 0) {
                $sumIn += $x->getAmountbase();
                $cntIn ++;
            } else {
                $sumOut += $x->getAmountbase();
                $cntOut ++;
            }
        }

        $sumIn = round($sumIn, 2);
        $sumOut = round($sumOut, 2);

        $this->setValue('paymentInCount', $cntIn);
        $this->setValue('paymentOutCount', $cntOut);

        $this->setValue('paymentInSum', $sumIn);
        $this->setValue('paymentOutSum', $sumOut);

        // считаем баланс
        $users = Shop::Get()->getUserService()->getUsersAll();
        // тупой lifehack, потому что в блок передается массив userID, а нам реально нужен
        // только первый user
        $users->filterId($userIDArray[0]);
        $balance = 0;
        while ($x = $users->getNext()) {
            $balance += $x->makeSumBalance();
        }
        $this->setValue('balance', $balance);
        $this->setValue('balanceColor', ($balance >= 0)?'green':'red');
        $this->setValue('userID', $this->getArgument('id'));
    }

}