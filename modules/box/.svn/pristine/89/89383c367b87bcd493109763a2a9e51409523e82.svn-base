<?php

class admin_report_worktime extends Engine_Class {

    public function process() {
        // даты
        $dateFrom = $this->getArgumentSecure('datefrom', 'date');
        $dateTo = $this->getArgumentSecure('dateto', 'date');
        $userID = $this->getArgumentSecure('userid', 'int');
        $ip = $this->getArgumentSecure('ip', 'string');

        if ($userID) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($userID);
                $this->setValue('name', $user->makeName());
            } catch (Exception $e) {
                
            }

            $dateArray = array();
            $timeArray = array();
            $reportArray = array();
            $d = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d');
            while ($d->__toString() <= $dateTo) {
                $dateCurrent = $d->preview('Y-m-d');
                $dateArray[] = $dateCurrent;

                // проверка данных за эту дату
                $data = new XShopHistory();
                $data->setUserid($userID);
                if ($ip) {
                    $data->setIp($ip);
                }
                $data->addWhere('cdate', $dateCurrent, '>=');
                $data->addWhere('cdate', $dateCurrent . ' 23:59:59', '<=');
                $data->addFieldQuery('HOUR(cdate) AS xh');
                //$data->setGroupByQuery('HOUR(cdate)');
                $data->setOrder('cdate', 'ASC');
                //$worktime->setCdate($cdate)
                while ($x = $data->getNext()) {
                    $hour = $x->getField('xh');
                    $timeArray[$hour] = $hour;

                    if (!isset($reportArray[$dateCurrent][$hour]['start'])) {
                        $reportArray[$dateCurrent][$hour]['start'] = DateTime_Formatter::TimeISO8601($x->getCdate());
                        $reportArray[$dateCurrent][$hour]['color1'] = 1;
                        $reportArray[$dateCurrent][$hour]['color2'] = 1;
                    } else {
                        $reportArray[$dateCurrent][$hour]['end'] = DateTime_Formatter::TimeISO8601($x->getCdate());
                        $reportArray[$dateCurrent][$hour]['color1'] = 1;
                        $reportArray[$dateCurrent][$hour]['color2'] = 1;
                    }
                }
                $worktime = new XShopUserWorkTime();
                $worktime->setUserid($data->getUserid());
                $worktime->addWhere('cdate', $dateCurrent, '>=');
                $worktime->addWhere('cdate', $dateCurrent . ' 23:59:59', '<=');

                while ($w = $worktime->getNext()) {
                    $startStart = DateTime_Formatter::TimeISO8601(
                        DateTime_Object::FromString($w->getCdate())->addMinute(-10)
                    );
                    $startEnd = DateTime_Formatter::TimeISO8601(
                        DateTime_Object::FromString($w->getCdate())->addMinute(+10)
                    );

                    $endStart = DateTime_Formatter::TimeISO8601(
                        DateTime_Object::FromString($w->getCdate())->addHour(+1)->addMinute(-10)
                    );
                    $endEnd = DateTime_Formatter::TimeISO8601(
                        DateTime_Object::FromString($w->getCdate())->addHour(+1)->addMinute(+10)
                    );

                    foreach ($reportArray[$dateCurrent] as $key => $hour) {

                        if ($hour['start'] >= $startStart && $hour['start'] <= $startEnd) {
                            $reportArray[$dateCurrent][$key]['color1'] = 0;
                        }
                        if ($hour['end'] >= $endStart && $hour['end'] <= $endEnd) {
                            $reportArray[$dateCurrent][$key]['color2'] = 0;
                        }
                    }
                }
                $d->addDay(+1);
            }

            sort($timeArray);
            $this->setValue('timeArray', $timeArray);
            $this->setValue('dateArray', $dateArray);
            $this->setValue('reportArray', $reportArray);
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
    }
}