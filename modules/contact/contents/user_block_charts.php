<?php
class user_block_charts extends Engine_Class {

    /**
     * @return User
     */
    private function _getUser() {
        return $this->getValue('user');
    }

    public function process() {
        PackageLoader::Get()->registerCSSFile('/_css/jit-base.css');
        PackageLoader::Get()->registerJSFile('/_js/jit-yc.js');

        $user = $this->_getUser();

        // список контактов по которым собираем статистику
        $userIDArray = array($user->getId());
        if ($user->getTypesex() == 'company' && $user->getCompany()) {
         $other = Shop::Get()->getUserService()->getUsersAll();
         $other->setCompany($user->getCompany());
         while ($x = $other->getNext()) {
          $userIDArray[] = $x->getId();
         }
        }

        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

        // last events (one month)
        $events = $user->getEvents($user->getTypesex() == 'company');
        $events->setOrder('cdate', 'DESC');
        $events->setHidden(0);
        $events->setLimitCount(50);
        $a = array();
        $nameArray = array();
        $ratingSum = 0;
        $ratingCount = 0;
        while ($x = $events->getNext()) {
            // по полю from определяем юзера
            try {
                $tmp = $x->getFromContact();

                $nameFrom = $tmp->makeName();
                $nameFromID = $tmp->getId();
            } catch (Exception $e) {
                $nameFrom = false;
                $nameFromID = false;
            }

            // по полю to определяем юзера
            try {
                $tmp = $x->getToContact();

                $nameTo = $tmp->makeName();
                $nameToID = $tmp->getId();
            } catch (Exception $e) {
                $nameTo = false;
                $nameToID = false;
            }

            // если ничего не известно - то прячем событие
            // если известно все - показываем
            if (!$nameFrom && !$nameTo) {
                continue;
            }

            if (!$nameFrom) {
                $nameFrom = $x->getFrom();
                $nameFromID = $x->getFrom();
            }
            if (!$nameTo) {
                $nameTo = $x->getTo();
                $nameToID = $x->getTo();
            }

            @$a[$nameFromID][$nameToID] ++;

            $nameArray[$nameFromID] = $nameFrom;
            $nameArray[$nameToID] = $nameTo;

            if ($x->getRating() > 0) {
                $ratingCount ++;
                $ratingSum += $x->getRating();
            }
        }

        if ($ratingCount > 0) {
            $this->setValue('rating', round($ratingSum / $ratingCount));
            $this->setValue('ratingValue', round($ratingSum / $ratingCount, 2));
        }

        if ($a) {
            $json = array();
            foreach ($nameArray as $nameFromID => $nameFrom) {
                $adjacencies = array();
                foreach ($nameArray as $nameToID => $nameTo) {
                    if (isset($a[$nameFromID][$nameToID])) {
                        $size = $a[$nameFromID][$nameToID];
                        if ($size >= 10) {
                            $color = 'red';
                        } else {
                            $color = 'gray';
                        }

                        $adjacencies[] = array(
                        'nodeTo' => $nameToID,
                        'nodeFrom' => $nameFromID,
                        'data' => array('$color' => $color /*, '$lineWidth' => $size*/),
                        );
                    }
                }

                $isManager = false;
                try {
                    $manager = Shop::Get()->getUserService()->getUserByID($nameFromID);
                    if ($manager->isAdmin()) {
                        $isManager = true;
                    }
                } catch (Exception $e) {

                }

                if ($isManager) {
                    $color = 'red';
                } elseif ($nameFromID != $nameFrom) {
                    $color = 'blue';
                } else {
                    $color = 'gray';
                }

                $json[] = array(
                'id' => $nameFromID,
                'name' => $nameFrom,
                'data' => array(
                '$color' => $color,
                '$type' => "circle",
                '$dim' => 5,
                ),
                'adjacencies' => $adjacencies,
                );
            }

            $json = json_encode($json);
            $this->setValue('eventJSON', $json);
        }

        $aclOrder = $this->getUser()->isAllowed('orders');
        $aclFinance = $this->getUser()->isAllowed('finance');
        $aclEvent = $this->getUser()->isAllowed('report_event');
        // (все графики строим по месяцам)
        $datefrom = DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now()->addYear(-1)->setFormat('Y-m'));
        $dateto = DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now()->addYear(0)->setFormat('Y-m'));
        $d = DateTime_Object::FromString($datefrom)->setFormat('Y-m');
        $dateArray = array();
        $reportArray = array();

        while ($d->__toString() <= $dateto) {
            $date = $d->__toString();
            $dateStart = $date.'-01';
            $month = DateTime_Object::FromString($dateStart)->setFormat('Y-m-t')->__toString();
            $dateEnd = $month.' 23:59:59';
            $dateArray[] = $date;
            // график заказов за год

            if ($aclOrder) {
                $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
                $orders->addWhere('cdate', $dateStart, '>=');
                $orders->addWhere('cdate', $dateEnd, '<=');
                $orders->addWhereArray($userIDArray, 'userid');
                while ($x = $orders->getNext()) {

                    try {
                        $orderSum = Shop::Get()->getCurrencyService()->convertCurrency(
                        $x->getSum(),
                        $x->getCurrency(),
                        $currencySystem
                        );
                        @$reportArray[$date]['orderCreated'] ++;
                        @$reportArray[$date]['orderCreatedSum'] += $orderSum;
                        @$reportArray['order'] ++;
                    } catch (Exception $e) {

                    }
                }
            }
            // график созданных заказов за год
            if ($aclOrder) {
                $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
                $orders->addWhere('cdate', $dateStart, '>=');
                $orders->addWhere('cdate', $dateEnd, '<=');
                $orders->setAuthorid($user->getId());
                while ($x = $orders->getNext()) {
                    try {
                        @$reportArray[$date]['created']++;
                        @$reportArray['order']++;
                    } catch (Exception $e) {

                    }
                }
            }

            // график платежей за год
            if (Shop_ModuleLoader::Get()->isImported('finance')) {
                if ($aclFinance) {
                    $payments = PaymentService::Get()->getPaymentsByUser($this->getUser());
                    $payments->addWhereArray($userIDArray, 'clientid');
                    $payments->addWhere('pdate', $dateStart, '>=');
                    $payments->addWhere('pdate', $dateEnd, '<=');
                    while ($x = $payments->getNext()) {
                        if ($x->getAmountbase() > 0) {
                            @$reportArray[$date]['paymentInSum'] += $x->getAmountbase();
                        } else {
                            @$reportArray[$date]['paymentOutSum'] += $x->getAmountbase();
                        }
                        @$reportArray['finance'] ++;
                    }
                }
            }

            // график call за год

            // график email за год

            if ($aclEvent) {
                // события на эту дату
                $events = $user->getEvents($user->getTypesex() == 'company');
                $events->addWhere('cdate', $dateStart, '>=');
                $events->addWhere('cdate', $dateEnd, '<=');
                $events->setHidden(0);
                while ($x = $events->getNext()) {
                    @$reportArray[$date]['event_'.$x->getType()] ++;
                    @$reportArray['event'] ++;
                    /*if ($x->getDirection() == 0) {
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
                    }*/
                }
            }
            $d->addMonth(+1);
        }

        $this->setValue('reportArray', $reportArray);
        $this->setValue('dateArray', $dateArray);
    }

}