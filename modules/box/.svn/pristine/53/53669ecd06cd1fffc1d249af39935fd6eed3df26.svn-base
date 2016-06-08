<?php
class admin_report_daycalendar extends Engine_Class {

    public function process() {
        // даты
        $dateFrom = $this->getArgumentSecure('datefrom', 'date');
        $dateTo = $this->getArgumentSecure('dateto', 'date');
        $userID = $this->getArgumentSecure('userid', 'int');

        if ($userID && $dateFrom && $dateTo) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($userID);
                $this->setValue('name', $user->makeName());

                $dateFrom = DateTime_Corrector::CorrectDate($dateFrom);
                $dateTo = DateTime_Corrector::CorrectDate($dateTo);

                $dateArray = array();
                $reportArray = array();

                $dateCurrent = $dateFrom;
                while ($dateCurrent <= $dateTo) {
                    $dateArray[] = $dateCurrent;
                    $ta = array();

                    $data = EventService::Get()->getEventsAll();
                    $data->addWhereArray(array('call', 'meeting'));
                    $data->addWhereQuery('(`touserid` = '.$userID.' OR `fromuserid` = '.$userID.')');
                    $data->addWhere('cdate', $dateCurrent, '>=');
                    $data->addWhere('cdate', $dateCurrent.' 23:59:59', '<=');
                    $data->addFieldQuery('HOUR(cdate) AS xh');
                    $data->setOrder('cdate', 'ASC');
                    while ($x = $data->getNext()) {
                        $hour = $x->getField('xh');
                        $time = DateTime_Object::FromString($x->getCdate())->setFormat('H:i')->__toString();

                        $a = array();
                        $a['name'] = $x->makeName();
                        $a['url'] = $x->makeURL();
                        $a['time'] = $time;

                        $ta[$hour][$time][] = $a;
                    }

                    $data = EventService::Get()->getEventsAll();
                    $data->setType('email');
                    $data->setFromuserid($userID);
                    $data->addWhere('cdate', $dateCurrent, '>=');
                    $data->addWhere('cdate', $dateCurrent.' 23:59:59', '<=');
                    $data->addFieldQuery('HOUR(cdate) AS xh');
                    $data->setOrder('cdate', 'ASC');
                    while ($x = $data->getNext()) {
                        $hour = $x->getField('xh');
                        $time = DateTime_Object::FromString($x->getCdate())->setFormat('H:i')->__toString();

                        $a = array();
                        $a['name'] = $x->makeName();
                        $a['url'] = $x->makeURL();
                        $a['time'] = DateTime_Object::FromString($x->getCdate())->setFormat('H:i')->__toString();

                        $ta[$hour][$time][] = $a;
                    }

                    $data = Shop::Get()->getShopService()->getOrdersAll();
                    $data->setAuthorid($userID);
                    $data->addWhere('cdate', $dateCurrent, '>=');
                    $data->addWhere('cdate', $dateCurrent.' 23:59:59', '<=');
                    $data->addFieldQuery('HOUR(cdate) AS xh');
                    $data->setOrder('cdate', 'ASC');
                    while ($x = $data->getNext()) {
                        $hour = $x->getField('xh');
                        $time = DateTime_Object::FromString($x->getCdate())->setFormat('H:i')->__toString();

                        $a = array();
                        $a['id'] = $x->getId();
                        $a['class'] = 'js-issue-preview';
                        $a['name'] = $x->makeName();
                        $a['url'] = $x->makeURLEdit();
                        $a['time'] = $time;

                        $ta[$hour][$time][] = $a;
                    }

                    $data = Shop::Get()->getUserService()->getUsersAll();
                    $data->setAuthorid($userID);
                    $data->addWhere('cdate', $dateCurrent, '>=');
                    $data->addWhere('cdate', $dateCurrent.' 23:59:59', '<=');
                    $data->addFieldQuery('HOUR(cdate) AS xh');
                    $data->setOrder('cdate', 'ASC');
                    while ($x = $data->getNext()) {
                        $hour = $x->getField('xh');
                        $time = DateTime_Object::FromString($x->getCdate())->setFormat('H:i')->__toString();

                        $a = array();
                        $a['id'] = $x->getId();
                        $a['class'] = 'js-contact-preview';
                        $a['name'] = $x->makeName();
                        $a['url'] = $x->makeURLEdit();
                        $a['time'] = $time;

                        $ta[$hour][$time][] = $a;
                    }

                    $data = CommentsAPI::Get()->getComments();
                    $data->setId_user($userID);
                    $data->addWhere('cdate', $dateCurrent, '>=');
                    $data->addWhere('cdate', $dateCurrent.' 23:59:59', '<=');
                    $data->addFieldQuery('HOUR(cdate) AS xh');
                    $data->setOrder('cdate', 'ASC');

                    while ($x = $data->getNext()) {
                        if (preg_match("/^shop-order-(\d+)$/ius", $x->getKey(), $r)) {
                            try {
                                $order = Shop::Get()->getShopService()->getOrderByID($r[1]);

                                $hour = $x->getField('xh');
                                $time = DateTime_Object::FromString($x->getCdate())->setFormat('H:i')->__toString();
                                $comment = StringUtils_Limiter::LimitLength($x->getContent(), 100);

                                $a = array();
                                $a['id'] = $order->getId();
                                $a['class'] = 'js-issue-preview';
                                $a['name'] = $order->makeName();
                                $a['url'] = $order->makeURLEdit();
                                $a['comment'] = $comment;
                                $a['time'] = $time;

                                $ta[$hour][$time][] = $a;
                            } catch (ServiceUtils_Exception $se) {

                            }
                        }
                    }

                    foreach ($ta as $k => $v) {
                        ksort($ta[$k]);
                    }

                    $reportArray[$dateCurrent] = $ta;
                    $dateCurrent = DateTime_Object::FromString($dateCurrent)->addDay(+1)->setFormat('Y-m-d')->__toString();
                }

                $hourArray = array();
                for ($i = 0; $i < 24; $i++) {
                    $hourArray[] = ($i < 10)?'0'.$i:$i;
                }

                $this->setValue('hourArray', $hourArray);
                $this->setValue('dateArray', $dateArray);
                $this->setValue('reportArray', $reportArray);
            } catch (Exception $e) {

            }
        }

        $manager = Shop::Get()->getUserService()->getUsersManagers();
        $a = array();
        while ($x = $manager->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, 'lfm'),
            );
        }
        $this->setValue('userArray', $a);

        if (!$dateFrom && !$dateTo) {
            $this->setControlValue('datefrom', DateTime_Object::Now()->addDay(-1)->setFormat('Y-m-d')->__toString());
            $this->setControlValue('dateto', DateTime_Object::Now()->addDay(-1)->setFormat('Y-m-d')->__toString());
        }
    }

}