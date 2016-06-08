<?php
class report_orderprobation extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('ok')) {
            $dateFrom = $this->getArgumentSecure('datefrom', 'date');
            $dateTo = $this->getArgumentSecure('dateto', 'date');
        } else {
            // даты платежей по умолчанию
            $dateFrom = DateTime_Object::Now()->setFormat('Y-m-d')->__toString();
            $this->setControlValue('datefrom', $dateFrom);

            //$dateTo = DateTime_Object::Now()->setFormat('Y-m-d')->__toString();
            //$this->setControlValue('dateto', $dateTo);
            $dateTo = false;
        }

        $payments = new XFinanceProbation();
        $payments->setOrder('pdate', 'ASC');

        $payments->addWhere('pdate', $dateFrom, '>=');
        if ($dateTo) {
            $payments->addWhere('pdate', $dateTo, '<=');
        }

        $filterManagerID = $this->getArgumentSecure('managerid', 'int');
        $payedID = $this->getArgumentSecure('payedid', 'int');
        $filterContractorID = $this->getArgumentSecure('contractorid', 'int');
        if ($payedID) {
            $payments->setManagerid($payedID);
        }

        $reportArray = array();
        $balanceSum = 0;
        $probation = 0;
        $probationPay = 0;
        while ($payment = $payments->getNext()) {
            try {
                $currency = SHop::Get()->getCurrencyService()->getCurrencyByID(
                    $payment->getCurrencyid()
                );
            } catch (Exception $e) {
                $currency = false;
            }

            try {
                $order = Shop::Get()->getShopService()->getOrderByID(
                    $payment->getOrderid()
                );

                if ($filterManagerID && $filterManagerID != $order->getManagerid()) {
                    continue;
                }
                
                if ($filterContractorID && $filterContractorID != $order->getContractorid()) {
                    continue;
                }
            } catch (Exception $e) {
                $order = false;
            }
            
            $clientName = false;
            $clientID = false;
            $clientURL = false;

            $managerName = false;
            $managerID = false;
            $managerURL = false;
            $accountArray = array();
            $legalentity = false;

            if ($order) {
                try {
                    $client = $order->getClient();
                    $clientName = $client->makeName();
                    $clientID = $client->getId();
                    $clientURL = $client->makeURLEdit();
                } catch (Exception $e) {

                }

                try {
                    $manager = $order->getManager();
                    $managerName = $manager->makeName(true, 'lfm');
                    $managerID = $manager->getId();
                    $managerURL = $manager->makeURLEdit();
                } catch (Exception $e) {

                }
                
                try {
                    $account = FinanceAccount::Get($payment->getAccountid());
                    $accountArray = array(
                        'url' => $account->makeURL(),
                        'name' => $account->getName(),
                    );
                } catch (Exception $e) {
                    
                }
                try {
                    $contractorid = $payment->getContractorid();
                    $legalentity = Shop::Get()->getShopService()->getContractorByID($contractorid)->makeName();
                } catch (Exception $e) {
                    
                }
            }

            $reportArray[] = array(
                'id' => $payment->getId(),
                'pdate' => $payment->getPdate(),
                'amount' => $payment->getAmount(),
                'currency' => $currency ? $currency->getName():false,
                'orderId' => $payment->getOrderid(),
                'orderName' => $order ? $order->makeName(false):'#'.$payment->getOrderid(),
                'orderUrl' => $order ? $order->makeURLEdit():false,
                'clientID' => $clientID,
                'clientName' => $clientName,
                'clientURL' => $clientURL,
                'managerID' => $managerID,
                'managerName' => $managerName,
                'managerURL' => $managerURL,
                'received' => $payment->getReceived(),
                'legalentity' => $legalentity,
                'account' => $accountArray
            );

            if ($currency) {
                $balanceSum += Shop::Get()->getCurrencyService()->convertCurrency(
                    $payment->getAmount(),
                    $currency,
                    Shop::Get()->getCurrencyService()->getCurrencySystem()
                );
            }

            if ($payment->getReceived() == 0) {
                $probation += $payment->getAmount();
            } else {
                $probationPay += $payment->getAmount();
            }
        }

        $this->setValue('currencyName', Shop::Get()->getCurrencyService()->getCurrencySystem()->getName());
        $this->setValue('reportArray', $reportArray);
        $this->setValue('balanceSum', $balanceSum);
        $this->setValue('probation', $probation);
        $this->setValue('probationPay', $probationPay);

        $a = array();
        $manager = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $manager->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, 'lfm'),
            );
        }
        $b = array();
        $contractor = Shop::Get()->getShopService()->getContractorsActive();
        while ($c = $contractor->getNext()) {
            $b[] = array(
                'id' => $c->getId(),
                'name' => $c->makeName(),
            );
        }
        $this->setValue('contractorArray', $b);
        $this->setValue('managerArray', $a);
    }

}