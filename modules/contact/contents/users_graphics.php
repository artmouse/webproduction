<?php

class users_graphics extends Engine_Class {

    public function process() {
        $user = Shop::Get()->getUserService()->getUserByID(
            $this->getArgument('id')
        );

        if (!Shop::Get()->getUserService()->isUserViewAllowed($user, $this->getUser())) {
            throw new ServiceUtils_Exception('user');
        }

        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

        $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
        $menu->setValue('selected', 'graphics');
        $menu->setValue('userid', $user->getId());
        $this->setValue('menu', $menu->render());

        $aclOrder = $this->getUser()->isAllowed('orders');
        $aclFinance = $this->getUser()->isAllowed('finance');
        $aclEvent = $this->getUser()->isAllowed('report_event');

        // (все графики строим по месяцам)
        $datefrom = $this->getArgumentSecure('datefrom');
        $dateto = $this->getArgumentSecure('dateto');
        $group = $this->getArgumentSecure('group'); // day, month. year
        if ($datefrom && $dateto) {
            $datefrom = DateTime_Formatter::DateTimeISO9075(DateTime_Object::FromString($datefrom)->setFormat('Y-m-d'));
            $dateto = DateTime_Formatter::DateTimeISO9075(DateTime_Object::FromString($dateto)->setFormat('Y-m-d'));
        } else {
            $datefrom = DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now()->addYear(-1)->setFormat('Y-m'));
            $dateto = DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now()->addYear(0)->setFormat('Y-m-d'));

        }

        $d = DateTime_Object::FromString($datefrom)->setFormat('Y-m-d');

        $dateArray = array();
        $reportArray = array();

        while ($d->__toString() <= $dateto) {

            $date = $d->__toString();

            $dateStart = $date;
            // групируем результаты
            if ($group == 'day') {
                $month = DateTime_Object::FromString($dateStart)->setFormat('Y-m-d')->addDay(+1)->__toString();
            } else if ($group == 'week') {
                $month = DateTime_Object::FromString($dateStart)->setFormat('Y-m-t')->addDay(+7)->__toString();
            } else {
                $month = DateTime_Object::FromString($dateStart)->setFormat('Y-m-t')->__toString();
            }

            $dateEnd = $month . ' 23:59:59';
            $dateArray[] = $date;

            // график заказов за год
            if ($aclOrder) {
                $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
                $orders->addWhere('cdate', $dateStart, '>=');
                $orders->addWhere('cdate', $dateEnd, '<=');
                $orders->setUserid($user->getId());
                while ($x = $orders->getNext()) {
                    try {
                        $orderSum = Shop::Get()->getCurrencyService()->convertCurrency(
                            $x->getSum(),
                            $x->getCurrency(),
                            $currencySystem
                        );
                        if ($x->getAuthorid() == $user->getId()) {
                            @$reportArray[$date]['created']++;
                        }
                        @$reportArray[$date]['orderCreated']++;
                        @$reportArray[$date]['orderCreatedSum'] += $orderSum;
                        @$reportArray['order']++;
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
                    $payments->setClientid($user->getId());
                    $payments->addWhere('pdate', $dateStart, '>=');
                    $payments->addWhere('pdate', $dateEnd, '<=');
                    while ($x = $payments->getNext()) {
                        if ($x->getAmountbase() > 0) {
                            @$reportArray[$date]['paymentInSum'] += $x->getAmountbase();
                        } else {
                            @$reportArray[$date]['paymentOutSum'] += $x->getAmountbase();
                        }
                        @$reportArray['finance']++;
                    }
                }
            }

            // график call
            // график email
            if ($aclEvent) {
                // события на эту дату
                $events = $user->getEvents($user->getTypesex() == 'company');
                $events->addWhere('cdate', $dateStart, '>=');
                $events->addWhere('cdate', $dateEnd, '<=');
                $events->setHidden(0);

                while ($x = $events->getNext()) {
                    @$reportArray[$date]['event_' . $x->getType()]++;
                    @$reportArray['event']++;

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
            // grouping
            if ($group == 'day') {
                $d->addDay(+1);
            } else if ($group == 'week') {
                $d->addDay(+7);
            } else {
                $d->addMonth(+1);
            }

        }
        if (empty($reportArray)) {
            $this->setValue('empty', 'Пользователь не проводил активных действий и статистика отсутствует.');
        }
        $this->setValue('reportArray', $reportArray);
        $this->setValue('dateArray', $dateArray);

    }

}