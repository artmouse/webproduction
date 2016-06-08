<?php
class report_managermonitor extends Engine_Class {

    public function process() {
        Engine::Get()->enableErrorReporting();

        $managerArray = $this->getArgumentSecure('managerid', 'array');

        $employers = Shop::Get()->getUserService()->getUsersManagers();
        $employers->addWhere('level', 2, '>=');
        $employerArray = array();
        while ($x = $employers->getNext()) {
            $employerArray[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, 'lfm'),
            'selected' => @in_array($x->getId(), $managerArray),
            );
        }
        $this->setValue('managerArray', $employerArray);

        $employers = Shop::Get()->getUserService()->getUsersManagers();
        $employers->addWhere('level', 2, '>=');
        if ($managerArray) {
            $employers->addWhereArray($managerArray);
        }
        $employerArray = array();
        while ($x = $employers->getNext()) {
            $employerArray[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, 'lfm'),
            );
        }
        $this->setValue('employerArray', $employerArray);

        $reportArray = array();
        $dateArray = array();
        // берем последние даты
        for ($j = 0; $j < 10; $j++) {
            $day = DateTime_Object::Now()->addDay(-$j)->setFormat('Y-m-d')->__toString();
            $dateArray[] = $day;

            foreach ($employerArray as $x) {
                // количество выполненных задач в этот день
                $issues = IssueService::Get()->getIssuesAll();
                $issues->setManagerid($x['id']);
                $issues->addWhere('dateclosed', $day.' 00:00:00', '>=');
                $issues->addWhere('dateclosed', $day.' 23:59:59', '<=');

                $reportArray[$x['id']][$day]['issue'] = $issues->getCount();

                // количество совершенных событий
                $events = EventService::Get()->getEventsAll();
                $events->setDirection(+1);
                $events->setFromuserid($x['id']);
                $events->addWhere('cdate', $day.' 00:00:00', '>=');
                $events->addWhere('cdate', $day.' 23:59:59', '<=');

                $reportArray[$x['id']][$day]['event'] = $events->getCount();


                //$reportArray[$x['id']][$day]['money'] = $count;
            }
        }

        $dateArray = array_reverse($dateArray);
        $this->setValue('dateArray', $dateArray);
        $this->setValue('reportArray', $reportArray);
    }

}