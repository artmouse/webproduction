<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_PredictionEvent {

    public function process() {
        $mailArray = array();

        $weekDayArray = array();
        $weekDayArray[1] = 'Mon';
        $weekDayArray[2] = 'Tue';
        $weekDayArray[3] = 'Wed';
        $weekDayArray[4] = 'Thu';
        $weekDayArray[5] = 'Fri';
        $weekDayArray[6] = 'Sat';
        $weekDayArray[7] = 'Sun';

        // все контакты
        $contacts = new User();
        $contacts->addWhere('level', 1, '<=');
        while ($x = $contacts->getNext()) {
            // анализируем среднее время между событиями
            $events = $x->getEvents(false, 'from');
            $events->setOrder('cdate', 'ASC');
            //$events->setDirection(-1); // только входящие события
            $events->setHidden(0);
            //$events->setLimitCount(100); // только последние события

            // последнее событие
            $prevent = false;
            $preventEventObject = false;

            // распределение событий по типам
            $typeArray = array();

            // даты событий
            $diffArray = array();
            $diffArrayCount = 0;

            // время первого события
            $diffHourArray = array(); // без учета дней
            $diffHourDayArray = array(); // с учетом дней
            $diffHourArrayCount = 0;

            $cnt = 0;
            while ($e = $events->getNext()) {
                if ($prevent) {
                    $d = DateTime_Differ::DiffDay($e->getCdate(), $prevent);
                    @$diffArray[round($d)] ++;
                    $diffArrayCount ++;

                    // записываем время только для первых контактов
                    if (round($d) > 0) {
                        $h = DateTime_Object::FromString($e->getCdate())->setFormat('H')->__toString();
                        @$diffHourArray[round($h)] ++;
                        $diffHourArrayCount ++;

                        $day = DateTime_Object::FromString($e->getCdate())->setFormat('D')->__toString();
                        @$diffHourDayArray[$day][round($h)] ++;
                    }
                }

                $prevent = $e->getCdate();
                $preventEventObject = $e;
                @$typeArray[$e->getType()] ++;
                $cnt ++;
            }

            // если нет событий - идем лесом сразу
            if (!$preventEventObject) {
                continue;
            }

            arsort($diffArray);
            arsort($diffHourArray);

            // данные по контакту
            print 'ContactID = '.$x->getId()."\n";
            print 'ContactName = '.$x->makeName()."\n";
            print 'Last event = '.$prevent."\n";
            print 'Event count = '.$cnt."\n";
            print "\n";

            // если событий мало - нечего считать
            if ($cnt < 5) {
                print "No event count (".$cnt.") for prediction.\n";
                print "\n";
                continue;
            }

            // вероятность события к интервалу времени
            foreach ($diffArray as $diff => $diffCount) {
                print 'Event diff probablity: '.$diff.' day = '.round($diffCount / $diffArrayCount * 100, 2)."%\n";
            }
            print "\n";

            // вероятность первого события в заданный час
            $time = false;
            foreach ($diffHourArray as $h => $diffCount) {
                print 'Event diff probablity: '.$h.':00 = '.round($diffCount / $diffHourArrayCount * 100, 2)."%\n";

                if (!$time) {
                    $time = $h;
                }
            }
            print "\n";

            //print_r($diffHourDayArray);

            foreach ($typeArray as $type => $typeCount) {
                print 'Type '.$type.' = ';
                print round($typeCount / $cnt * 100, 2).'%';
                print "\n";
            }
            print "\n";

            // сколько событий будет за 1 день
            /*if (isset($diffArray[0])) {
            $dailyCount = round(1 / ($diffArray[0] / $diffArrayCount));

            print 'Event daily count probablity = '.round(1 / ($diffArray[0] / $diffArrayCount))."\n";
            } else {
            $dailyCount = false;
            }
            print "\n";*/

            $prevent = DateTime_Formatter::DateISO9075($prevent);

            // считаем вероятность будущих событий
            foreach ($diffArray as $diff => $diffCount) {
                if ($diffCount <= 1) {
                    continue;
                }

                // дата будущего события
                $dateOnly = DateTime_Object::FromString($prevent)->addDay($diff)->setFormat('Y-m-d')->__toString();
                $dateDay = DateTime_Object::FromString($prevent)->addDay($diff)->setFormat('D')->__toString();

                // время с учетом дней
                $dayTimeArray = @$diffHourDayArray[$dateDay];
                if ($dayTimeArray) {
                    arsort($dayTimeArray);
                    foreach ($dayTimeArray as $dt => $dtc) {
                        if ($dtc <= 1) {
                            break;
                        }

                        $time = $dt;
                        break;
                    }
                }

                $date = DateTime_Object::FromString($prevent)->addDay($diff)->addHour($time)->setFormat('Y-m-d H:i')->__toString();


                // вероятность события в эту дату
                $probablity = round($diffCount / $diffArrayCount * 100, 2);

                print 'New event will be at: '.$date.' = '.$probablity."%\n";

                // получаем менеджера по полю "to"
                try {
                    $manager = Shop::Get()->getUserService()->findUserByContact($preventEventObject->getTo(), $preventEventObject->getType());
                    if ($manager->getLevel() < 2) {
                        throw new ServiceUtils_Exception();
                    }

                    print 'Manager = '.$manager->makeName()."\n";
                } catch (Exception $e) {
                    continue;
                }

                if ($date < date('Y-m-d H:i')) {
                    continue;
                }

                $probablityCall = round(@$typeArray['call'] / $cnt * 100, 2);
                $probablityEmail = round(@$typeArray['email'] / $cnt * 100, 2);

                $content = '';
                $contentMessage = '';
                $content .= "{$date} ";
                if ($probablityCall >= 100 || $probablityEmail == 0) {
                    $content .= 'позвонит ';
                    $contentMessage .= 'Позвонит ';
                } elseif ($probablityEmail >= 100 || $probablityCall == 0) {
                    $content .= 'напишет ';
                    $contentMessage .= 'Напишет ';
                } else {
                    $content .= 'позвонит ('.$probablityCall.'%) или напишет ('.$probablityEmail.'%) ';
                    $contentMessage .= 'Позвонит ('.$probablityCall.'%) или напишет ('.$probablityEmail.'%) ';
                }
                $content .= $x->makeName().'. ';
                $content .= 'Вероятность этого события '.$probablity.'%.';
                /*if ($probablity) {
                $content .= 'Высокая вероятность события.';
                } else {
                $content .= 'Низкая вероятность события.';
                }*/

                $mailArray[] = $manager->makeName()."\n".$content."\n";

                // запись предсказания
                if ($date >= date('Y-m-d H:i')) {
                    $tmp = new XShopUserEventPrediction();
                    $tmp->setUserid($x->getId());
                    $tmp->setPdate($date.':00');
                    if (!$tmp->select()) {
                        $tmp->setCdate(date('Y-m-d H:i:s'));
                        $tmp->insert();
                    }
                    $tmp->setComment($contentMessage);
                    $tmp->setProbablity($probablity);
                    $tmp->update();
                }

                // создаем уведомление
                if ($dateOnly == date('Y-m-d')) {
                    // сохраняем уведомление
                    /*NotifyService::Get()->addNotify(
                    $manager,
                    'event-prediction-'.$x->getId().'-'.$date,
                    $content,
                    $x->makeURLEdit(),
                    $probablity >= 5 ? 1 : 0
                    );*/

                    // @todo
                }
                print "\n";
            }

            // запоминаем рекомендуемое время в заданные дни
            foreach ($weekDayArray as $dayIndex => $dayName) {
                $time = false;

                $dayTimeArray = @$diffHourDayArray[$dayName];
                if (!$dayTimeArray) {
                    continue;
                }

                arsort($dayTimeArray);
                foreach ($dayTimeArray as $dt => $dtc) {
                    if ($dtc <= 1) {
                        break;
                    }

                    $time = $dt;
                    break;
                }

                if (!$time) {
                    continue;
                }

                $time .= ':00';

                $tmp = new XShopUserEventRecommend();
                $tmp->setUserid($x->getId());
                $tmp->setDay($dayIndex);
                if (!$tmp->select()) {
                    $tmp->setTime($time);
                    $tmp->insert();
                } else {
                    $tmp->setTime($time);
                    $tmp->update();
                }
            }


            print "\n";
        }

        if ($mailArray) {
            //mail('max@webproduction.ua', '[OneBox] Event prediction', implode("\n", $mailArray));
        }
    }

}