<?php
class report_summary extends Engine_Class {

    public function process() {
        $groupBy = $this->getArgumentSecure('groupby');
        if (!$groupBy) {
            $groupBy = 'hour';
        }

        if ($this->getArgumentSecure('ok')) {
            $datefrom = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateFrom'));
            $dateto = DateTime_Corrector::CorrectDate($this->getControlValue('dateTo')).' 23:59:59';
        } else {
            $dateto = DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now());

            if ($groupBy == 'hour') {
                $datefrom = 
                DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now()->addDay(-0)->setFormat('Y-m-d 00:00:00'));
            } elseif ($groupBy == 'day') {
                $datefrom = 
                DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now()->addDay(-30)->setFormat('Y-m-d'));
            } elseif ($groupBy == 'month') {
                $datefrom = 
                DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now()->addMonth(-6)->setFormat('Y-m-01'));
            }

            $this->setControlValue('dateFrom', $datefrom);
            $this->setControlValue('dateTo', $dateto);
        }

        if ($groupBy == 'hour' && DateTime_Differ::DiffHour($dateto, $datefrom) > 72) {
            $groupBy = 'day';
            $this->setControlValue('groupby', $groupBy);
        }

        $noIncremental = $this->getArgumentSecure('noincremental', 'bool');

        $box = Engine::Get()->getConfigFieldSecure('project-box');
        $this->setValue('box', $box);

        $isOrder = Shop_ModuleLoader::Get()->isImported('order');
        $this->setValue('isOrderImported', $isOrder);

        $isFinance = Shop_ModuleLoader::Get()->isImported('finance');
        $this->setValue('isFinanceImported', $isFinance);

        $managerID = $this->getArgumentSecure('managerid', 'int');

        if ($box) {
            // список юзеров которые раболи в системе
            $users = Shop::Get()->getUserService()->getUsersAll(
                $this->getUser()
            );
            $today = date('Y-m-d');
            $users->addWhere('activitydate', $dateto, '<=');
            $users->addWhere('activitydate', $datefrom, '>=');
            $users->addWhere('level', 2, '>=');
            $users->setOrder('activitydate', 'DESC');
            $a = array();
            while ($x = $users->getNext()) {

                /*$notifyPercent = 100;

                $notifys = IssueService::Get()->getIssuesAll();
                $notifys->addWhereQuery('cdate > NOW() - INTERVAL 1 MONTH');
                $notifys->setManagerid($x->getId());
                $notifyAll = $notifys->getCount();

                $notifys = IssueService::Get()->getIssuesAll();
                $notifys->addWhereQuery('cdate > NOW() - INTERVAL 1 MONTH');
                $notifys->setManagerid($x->getId());
                $notifys->addWhere('dateshipped', '0000-00-00 00:00:00', '!=');
                $notifyDone = $notifys->getCount();

                if ($notifyAll > 0) {
                $notifyPercent = round($notifyDone / $notifyAll * 100);
                }*/
                $sdate = false;
                $ip = false;
                try {
                    $xx = new XUserAuth();
                    $xx->setUserid($x->getId());
                    $xxAuth = $xx->getNext();
                    if ($xxAuth) {
                        $sdate = $xxAuth->getSdate();
                        $ip = $xxAuth->getIp();
                    }
                    
                } catch (Exception $ex) {

                }                
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'url' => $x->makeURLEdit(),
                'adate' => $x->getActivitydate(),
                'sdate' => $sdate,
                'ip' => $ip,
                'today' => DateTime_Object::FromString($x->getActivitydate())->setFormat('Y-m-d') == $today,
                'diff' => DateTime_Differ::DiffHour('now', $x->getActivitydate()),
                'adatePhonetic' => DateTime_Formatter::DateTimePhonetic($x->getActivitydate()),
                'image' => $x->makeImageThumb(50, false, 'prop', true),
                //'notifypercent' => $notifyPercent,
                );
            }
            $this->setValue('userArray', $a);
        }

        $aclOrder = $this->getUser()->isAllowed('orders');
        $aclUser = $this->getUser()->isAllowed('users');
        $aclEvent = $this->getUser()->isAllowed('report_event');
        $aclFinance = $this->getUser()->isAllowed('finance');

        // статусы заказов
        $statusArray = array();
        $status = Shop::Get()->getShopService()->getStatusAll();
        while ($x = $status->getNext()) {
            try {
                $category = $x->getCategory();
                if ($category->getType() == 'issue' || $category->getType() == 'project') {
                    continue;
                }

                $statusArray[$x->getId()] = $category->getName().' / '.$x->getName();
            } catch (Exception $e) {
                $statusArray[$x->getId()] = $x->getName();
            }
        }
        asort($statusArray);

        // идем по датам
        if ($groupBy == 'hour') {
            $d = DateTime_Object::FromString($datefrom)->setFormat('Y-m-d H');
            $dateto = DateTime_Object::FromString($dateto)->setFormat('Y-m-d H')->__toString();
        } elseif ($groupBy == 'day') {
            $d = DateTime_Object::FromString($datefrom)->setFormat('Y-m-d');
            $dateto = DateTime_Object::FromString($dateto)->setFormat('Y-m-d')->__toString();
        } elseif ($groupBy == 'month') {
            $d = DateTime_Object::FromString($datefrom)->setFormat('Y-m');
            $dateto = DateTime_Object::FromString($dateto)->setFormat('Y-m')->__toString();
        }

        $totalOrder = 0;
        $totalSum = 0;
        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

        $reportArray = array();
        $dateArray = array();

        while ($d->__toString() <= $dateto) {

            $date = $d->__toString();

            if ($groupBy == 'hour') {
                $dateStart = $date;
                $dateEnd = $date.':59:59';

                $date .= ':00';
            } elseif ($groupBy == 'day') {
                $dateStart = $date;
                $dateEnd = $date.' 23:59:59';
            } elseif ($groupBy == 'month') {
                $dateStart = $date.'-01';
                $month = DateTime_Object::FromString($dateStart)->setFormat('Y-m-t')->__toString();
                $dateEnd = $month.' 23:59:59';
            }

            $dateArray[] = $date;

            // созданные заказы да эту дату
            if ($aclOrder) {
                $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
                $orders->addWhere('cdate', $dateStart, '>=');
                $orders->addWhere('cdate', $dateEnd, '<=');
                if ($managerID) {
                    $orders->setManagerid($managerID);
                }
                while ($x = $orders->getNext()) {
                    try {
                        $orderSum = Shop::Get()->getCurrencyService()->convertCurrency(
                            $x->getSum(),
                            $x->getCurrency(),
                            $currencySystem
                        );

                        $totalOrder ++;
                        $totalSum += $orderSum;

                        @$reportArray[$date]['orderCreated'] ++;
                        @$reportArray[$date]['orderCreatedSum'] += $orderSum;
                    } catch (Exception $e) {

                    }
                }

                if (!$noIncremental) {
                    @$reportArray[$date]['orderCreated'] += $reportArray[$dateLast]['orderCreated'];
                    @$reportArray[$date]['orderCreatedSum'] += $reportArray[$dateLast]['orderCreatedSum'];
                }

                /*// обновленные заказы
                $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
                $orders->addWhere('udate', $dateStart, '>=');
                $orders->addWhere('udate', $dateEnd, '<=');
                if ($managerID) {
                $orders->setManagerid($managerID);
                }
                while ($x = $orders->getNext()) {
                try {
                $orderSum = Shop::Get()->getCurrencyService()->convertCurrency(
                $x->getSum(),
                $x->getCurrency(),
                $currencySystem
                );

                $totalOrder ++;
                $totalSum += $orderSum;

                @$reportArray[$date]['orderUpdated'] ++;
                @$reportArray[$date]['orderUpdatedSum'] += $orderSum;
                } catch (Exception $e) {

                }
                }*/

                if ($box) {
                    // переходы заказов
                    foreach ($statusArray as $statusID => $statusName) {
                        $change = new XShopOrderChange();
                        $change->setKey('statusid');
                        $change->addWhere('cdate', $dateStart, '>=');
                        $change->addWhere('cdate', $dateEnd, '<=');
                        $change->setValue($statusID);
                        if ($managerID) {
                            $change->addWhereQuery(
                                "orderid IN (SELECT id FROM shoporder WHERE managerid={$managerID})"
                            );
                        }
                        while ($x = $change->getNext()) {
                            try {
                                $order = Shop::Get()->getShopService()->getOrderByID(
                                    $x->getOrderid()
                                );

                                $orderSum = Shop::Get()->getCurrencyService()->convertCurrency(
                                    $order->getSum(),
                                    $order->getCurrency(),
                                    $currencySystem
                                );

                                @$reportArray[$date]['orderStatus'][$statusID] ++;
                                @$reportArray[$date]['orderStatusSum'][$statusID] += $orderSum;
                            } catch (Exception $e) {

                            }
                        }

                        if (!$noIncremental) {
                            
                            @$reportArray[$date]['orderStatus'][$statusID] += 
                            $reportArray[$dateLast]['orderStatus'][$statusID];
                            
                            @$reportArray[$date]['orderStatusSum'][$statusID] += 
                            $reportArray[$dateLast]['orderStatusSum'][$statusID];
                        }
                    }
                }
            }

            // платежи на эту дату
            if (Shop_ModuleLoader::Get()->isImported('finance')) {
                if ($aclFinance) {
                    $payments = PaymentService::Get()->getPaymentsByUser($this->getUser());
                    $payments->addWhere('pdate', $dateStart, '>=');
                    $payments->addWhere('pdate', $dateEnd, '<=');
                    if ($managerID) {
                        $payments->setUserid($managerID);
                    }
                    while ($x = $payments->getNext()) {
                        if ($x->isTransfer()) {
                            continue;
                        }

                        if ($x->getAmountbase() > 0) {
                            @$reportArray[$date]['paymentInSum'] += $x->getAmountbase();
                        } else {
                            @$reportArray[$date]['paymentOutSum'] += $x->getAmountbase();
                        }
                    }

                    if (!$noIncremental) {
                        @$reportArray[$date]['paymentInSum'] += $reportArray[$dateLast]['paymentInSum'];
                        @$reportArray[$date]['paymentOutSum'] += $reportArray[$dateLast]['paymentOutSum'];
                    }
                }
            }

            if ($box) {
                if ($aclEvent) {
                    // события на эту дату
                    $events = new ShopEvent();
                    if ($managerID) {
                        try {
                            $manager = Shop::Get()->getUserService()->getUserByID($managerID);
                            $events = $manager->getEvents();
                        } catch (Exception $e) {
                            $events->addWhereQuery("1=0");
                        }
                    }
                    $events->addWhere('cdate', $dateStart, '>=');
                    $events->addWhere('cdate', $dateEnd, '<=');
                    $events->setHidden(0);

                    while ($x = $events->getNext()) {
                        if ($x->getDirection() == 0) {
                            $direction = 'Our';
                        } elseif ($x->getDirection() > 0) {
                            $direction = 'Out';
                        } elseif ($x->getDirection() < 0) {
                            $direction = 'In';
                        }

                        if ($x->getType() == 'call') {
                            @$reportArray[$date]['eventCall'.$direction] ++;
                        } elseif ($x->getType() == 'email') {
                            @$reportArray[$date]['eventEmail'.$direction] ++;
                        }
                    }

                    if (!$noIncremental) {
                        @$reportArray[$date]['eventCallIn'] += $reportArray[$dateLast]['eventCallIn'];
                        @$reportArray[$date]['eventCallOut'] += $reportArray[$dateLast]['eventCallOut'];
                        @$reportArray[$date]['eventCallOur'] += $reportArray[$dateLast]['eventCallOur'];
                        @$reportArray[$date]['eventEmailIn'] += $reportArray[$dateLast]['eventEmailIn'];
                        @$reportArray[$date]['eventEmailOut'] += $reportArray[$dateLast]['eventEmailOut'];
                        @$reportArray[$date]['eventEmailOur'] += $reportArray[$dateLast]['eventEmailOur'];
                    }
                }
            }

            // клиенты на эту дату
            if ($aclUser) {
                $clients = Shop::Get()->getUserService()->getUsersAll($this->getUser());
                $clients->addWhere('cdate', $dateStart, '>=');
                $clients->addWhere('cdate', $dateEnd, '<=');
                if ($managerID) {
                    $clients->setManagerid($managerID);
                }
                while ($x = $clients->getNext()) {
                    @$reportArray[$date]['clientCreated'] ++;
                }

                if (!$noIncremental) {
                    @$reportArray[$date]['clientCreated'] += $reportArray[$dateLast]['clientCreated'];
                }

                /*$clients = Shop::Get()->getUserService()->getUsersAll($this->getUser());
                $clients->addWhere('udate', $dateStart, '>=');
                $clients->addWhere('udate', $dateEnd, '<=');
                if ($managerID) {
                $clients->setManagerid($managerID);
                }
                while ($x = $clients->getNext()) {
                @$reportArray[$date]['clientUpdated'] ++;
                }*/
            }

            $dateLast = $date;

            // увеличиваем дату
            if ($groupBy == 'hour') {
                $d->addHour(+1);
            } elseif ($groupBy == 'day') {
                $d->addDay(+1);
            } elseif ($groupBy == 'month') {
                $d->addMonth(+1);
            }
        }

        // идем по всем заказам и считаем статистику

        $productstat = Shop::Get()->getShopService()->getOrdersAll();
        $productstat->addWhere('cdate', $dateStart, '>=');
        $productstat->addWhere('cdate', $dateEnd, '<=');
        if ($managerID) {
            $productstat->setManagerid($managerID);
        }

        $productArray = array();
        $reportsArray = array();
        while ($productstat2 = $productstat->getNext()) {
            $ops2 = $productstat2->getOrderProducts();
            while ($op2 = $ops2->getNext()) {
                try {
                    $productArray[$op2->getProductid()] = $op2->getCategoryname();
                } catch (Exception $e) {

                }
                @$reportsArray[$op2->getProductid()] += $op2->getProductcount();
            }
        }
        arsort($reportsArray);
        $productStatArray = array();
        foreach ($productArray as $key=>$value) {
            if (array_key_exists($value, $productStatArray)) {
                $productStatArray[$value]+=$reportsArray[$key];
                continue;
            }
            if (count($productStatArray)==5)
            break;
            $productStatArray[$value]=$reportsArray[$key];
        }

        $this->setValue('productStatArray', $productStatArray);
        $this->setValue('dateArray', $dateArray);
        $this->setValue('statusArray', $statusArray);
        $this->setValue('reportArray', $reportArray);
        $this->setValue('totalSum', $totalSum);
        $this->setValue('totalOrder', $totalOrder);
        $this->setValue('totalCurrency', $currencySystem->getSymbol());

        // -------------------------- //

        // cписок менеджеров
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        $a = array();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            );
        }
        $this->setValue('managerArray', $a);
    }
}