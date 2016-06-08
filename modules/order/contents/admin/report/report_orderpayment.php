<?php
class report_orderpayment extends Engine_Class {

    public function process() {
        $typeArray = $this->getArgumentSecure('type', 'array');
        if (!$typeArray) {
            $typeArray = array('', 'order', 'project');
        }
        foreach ($typeArray as $x) {
            if ($x == 'order') {
                $typeArray[] = '';
                break;
            }
        }
        $this->setValue('typeArray', $typeArray);

        if ($this->getArgumentSecure('ok')) {
            $dateFrom = $this->getArgumentSecure('datefrom', 'date');
            $dateTo = $this->getArgumentSecure('dateto', 'date');

            $datePaymentFrom = $this->getArgumentSecure('paymentfrom', 'date');
            $datePaymentTo = $this->getArgumentSecure('paymentto', 'date');

            $sourceID = $this->getArgumentSecure('sourceid', 'int');
            $managerID = $this->getArgumentSecure('managerid', 'int');
            $authorID = $this->getArgumentSecure('authorid', 'int');
            $contractorID = $this->getArgumentSecure('contractorid', 'int');
            $groupCompany = $this->getArgumentSecure('groupcompany', 'bool');
            $direction = $this->getArgumentSecure('direction', 'string');
            $noBalance = $this->getArgumentSecure('nobalance', 'string');

            $workflowIDArray = $this->getArgumentSecure('workflowid', 'array');
            $statusIDArray = $this->getArgumentSecure('statusid', 'array');

            // -------

            // идем по всем заказам и считаем статистику

            $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
            $orders->addWhereArray($typeArray, 'type');
            if ($direction == 'in') {
                $orders->setOutcoming(0);
            }
            if ($direction == 'out') {
                $orders->setOutcoming(1);
            }
            if ($dateFrom) {
                $orders->addWhere('cdate', $dateFrom, '>=');
            }
            if ($dateTo) {
                $orders->addWhere('cdate', $dateTo.' 23:59:59', '<=');
            }
            if ($workflowIDArray) {
                $orders->addWhereArray($workflowIDArray, 'categoryid');
            }
            if ($sourceID) {
                $orders->setSourceid($sourceID);
            }
            if ($managerID) {
                $orders->setManagerid($managerID);
            }
            if ($authorID) {
                $orders->setAuthorid($authorID);
            }
            if ($contractorID) {
                $orders->setContractorid($contractorID);
            }
            if ($statusIDArray) {
                $orders->addWhereArray($statusIDArray, 'statusid');
            }

            $reportArray = array();

            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('currency', $currencySystem->getSymbol());

            $orderInSum = 0;
            $orderOutSum = 0;
            $payedInSum = 0;
            $payedOutSum = 0;
            $balanceSum = 0;

            while ($order = $orders->getNext()) {
                try {
                    // обнуляем все значения
                    $sumIn = 0;
                    $sumOut = 0;
                    $payedIn = 0;
                    $payedOut = 0;

                    // сумма заказа
                    // @todo: amountbase
                    $sum = $order->getSumbase();

                    // сумма оплат по заказу
                    $payed = 0;
                    $payments = new FinancePayment();
                    $payments->setOrderid($order->getId());
                    if (!$noBalance) {
                        $payments->setNobalance(0);
                    }
                    if ($datePaymentFrom) {
                        $payments->addWhere('pdate', $datePaymentFrom, '>=');
                    }
                    if ($datePaymentTo) {
                        $payments->addWhere('pdate', $datePaymentTo.' 23:59:59', '<=');
                    }
                    while ($x = $payments->getNext()) {
                        $payed += $x->getAmountbase();
                    }

                    if ($datePaymentFrom && !$payed) {
                        continue;
                    }

                    // конвертируем суммы если надо
                    if ($order->getOutcoming()) {
                        $sumOut = $sum;
                        $payedOut = $payed;
                    } else {
                        $sumIn = $sum;
                        $payedIn = $payed;
                    }

                    $diff = $order->makeSumBalance();
                    $diff = Shop::Get()->getCurrencyService()->convertCurrency(
                        $diff,
                        $order->getCurrency(),
                        $currencySystem
                    );
                    $balanceSum += $diff;

                    $orderOutSum += $sumOut;
                    $orderInSum += $sumIn;

                    $payedOutSum += $payedOut;
                    $payedInSum += $payedIn;


                    $reportArray[] = array(
                    'clientName' => $this->_escapeString($order->getUser()->makeName()),
                    'clientURL' => $order->getUser()->makeURLEdit(),
                    'clientId' => $order->getUserid(),
                    'orderName' => $order->makeName(),
                    'orderId' => $order->getId(),
                    'orderURL' => $order->makeURLEdit(),
                    'sumIn' => $sumIn,
                    'sumOut' => $sumOut,
                    'payedIn' => $payedIn,
                    'payedOut' => $payedOut,
                    'balance' => $diff,
                    );


                } catch (Exception $e) {

                }
            }

            if ($groupCompany) {
                $reportCompanyArray = array();
                foreach ($reportArray as $clientID => $a) {
                    try {
                        $client = Shop::Get()->getUserService()->getUserByID($clientID);
                    } catch (Exception $e) {
                        continue;
                    }

                    $company = $client->getCompany();
                    if (!$company) {
                        $company = $client->makeName();
                    }

                    $reportCompanyArray[$company]['clientName'] = $company;
                    @$reportCompanyArray[$company]['count'] += $a['count'];
                    @$reportCompanyArray[$company]['sumIn'] += $a['sumIn'];
                    @$reportCompanyArray[$company]['sumOut'] += $a['sumOut'];
                    @$reportCompanyArray[$company]['payedIn'] += $a['payedIn'];
                    @$reportCompanyArray[$company]['payedOut'] += $a['payedOut'];
                    @$reportCompanyArray[$company]['balance'] += $a['balance'];
                }

                $this->setValue('reportArray', $reportCompanyArray);
            } else {
                $this->setValue('reportArray', $reportArray);
            }

            $this->setValue('payedInSum', $payedInSum);
            $this->setValue('payedOutSum', $payedOutSum);
            $this->setValue('orderInSum', $orderInSum);
            $this->setValue('orderOutSum', $orderOutSum);
            $this->setValue('balanceSum', $balanceSum);
        } else {
            // даты платежей по умолчанию
            $dateFrom = DateTime_Object::Now()->setFormat('Y-m-01')->__toString();
            $this->setControlValue('paymentfrom', $dateFrom);

            $dateTo = DateTime_Object::Now()->setFormat('Y-m-d')->__toString();
            $this->setControlValue('paymentto', $dateTo);
        }

        // -------

        // менеджеры
        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            );
        }
        $this->setValue('managerArray', $a);

        // источники заказов
        $sources = Shop::Get()->getShopService()->getSourceAll();
        $this->setValue('sourceArray', $sources->toArray());

        // юридические лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $this->setValue('contractorArray', $contractors->toArray());

        // статусы заказов
        $block = Engine::GetContentDriver()->getContent('workflow-filter-block');
        $this->setValue('block_workflow_filter', $block->render());
    }

    private function _escapeString($s) {
        $s = trim($s);
        $s = str_replace("\n", '', $s);
        $s = str_replace("\r", '', $s);
        $s = str_replace("\t", '', $s);
        $s = str_replace("'", '', $s);
        $s = str_replace("\"", '', $s);
        return $s;
    }

}