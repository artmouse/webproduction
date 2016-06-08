<?php
class report_notify extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom', 'date');
        $dateTo = $this->getArgumentSecure('dateto', 'date');

        if (!$dateFrom) {
            $dateFrom = DateTime_Object::Now()->addMonth(-1)->setFormat('Y-m-d')->__toString();
            $this->setValue('datefrom', $dateFrom);
        }

        $doneFrom = $this->getArgumentSecure('donefrom', 'date');
        $doneTo = $this->getArgumentSecure('doneto', 'date');

        $managerID = $this->getArgumentSecure('managerid', 'int');
        $status = $this->getArgumentSecure('status');

        // -------

        $notify = IssueService::Get()->getIssuesAll();
        $workflowID = Engine::Get()->getConfigField('project-box-notify-workflowid');
        $notify->setCategoryid($workflowID);

        if ($dateFrom) {
            $notify->addWhere('cdate', $dateFrom, '>=');
        }
        if ($dateTo) {
            $notify->addWhere('cdate', $dateTo.' 23:59:59', '<=');
        }
        if ($doneFrom) {
            $notify->addWhere('dateclosed', $doneFrom, '>=');
        }
        if ($doneTo) {
            $notify->addWhere('dateclosed', $doneTo.' 23:59:59', '<=');
        }
        if ($managerID) {
            $notify->setUserid($managerID);
        }
        if ($status == 'done') {
            $notify->addWhere('dateclosed', '0000-00-00 00:00:00', '!=');
        } elseif ($status == 'undone') {
            $notify->setDateclosed('0000-00-00 00:00:00');
        }

        $reportArray = array();
        $chartArray = array();
        $summaryArray = array();

        while ($x = $notify->getNext()) {
            try {
                $manager = Shop::Get()->getUserService()->getUserByID(
                $x->getUserid()
                );

                $overtime = false;

                $cdate = $this->_formatDate($x->getCdate());
                $edate = $this->_formatDate($x->getDateto());
                $rdate = $this->_formatDate($x->getDateclosed());

                if (!$edate) {
                    $edate = DateTime_Object::FromString($cdate)->addDay(+3)->__toString();
                }

                if ($rdate) {
                    $overtime = $this->_makeDiff($rdate, $edate);
                } else {
                    $overtime = $this->_makeDiff(date('Y-m-d H:i:s'), $edate);
                }

                $reportArray[] = array(
                'managerName' => $manager->makeName(),
                'managerURL' => $manager->makeURLEdit(),
                'managerId' => $manager->getId(),
                'url' => $x->makeURLEdit(),
                'content' => $x->getComments(),
                'cdate' => $cdate,
                'edate' => $edate,
                'rdate' => $rdate,
                'rdiff' => $this->_makeDiff($x->getDateclosed(), $x->getCdate()),
                'overtime' => $overtime,
                );

                if ($rdate) {
                    $done = 'done';
                    $diff = DateTime_Differ::DiffDay($x->getDateclosed(), $x->getCdate());
                } else {
                    $done = 'undone';
                    $diff = 0;
                }
                @$chartArray[$this->_escapeString($manager->makeName(true, 'lfm'))][$done]++;

                @$summaryArray[$manager->getId()][$done] ++;
                @$summaryArray[$manager->getId()]['diff'] += $diff;
            } catch (Exception $e) {

            }
        }

        foreach ($summaryArray as $managerID => $x) {
            if (!empty($x['done'])) {
                $summaryArray[$managerID]['avg'] = round($x['diff'] / $x['done'], 2);
            }
        }

        $this->setValue('summaryArray', $summaryArray);
        $this->setValue('reportArray', $reportArray);
        $this->setValue('chartArray', $chartArray);

        // -------

        // менеджеры
        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('managerid' => $x->getId())),
            );
        }
        $this->setValue('managerArray', $a);
    }

    private function _formatDate($date) {
        if (Checker::CheckDate($date)) {
            return $date;
        }
        return false;
    }

    private function _makeDiff($a, $b) {
        if (!Checker::CheckDate($a)) {
            return false;
        }

        if (!Checker::CheckDate($b)) {
            return false;
        }

        if ($a <= $b) {
            return false;
        }

        $x = DateTime_Differ::DiffHour($a, $b);
        if ($x < 24) {
            return $x.' ч.';
        }

        $x = DateTime_Differ::DiffDay($a, $b);
        if ($x < 30) {
            return $x.' д.';
        }

        $x = DateTime_Differ::DiffMonth($a, $b);
        return $x.' мес.';
    }

    private function _escapeString($s) {
        $s = trim($s);
        $s = str_replace("\"", '', $s);
        $s = str_replace("'", '', $s);
        $s = str_replace("\n", '', $s);
        $s = str_replace("\r", '', $s);
        $s = str_replace("\t", '', $s);
        $s = str_replace("'", '', $s);
        $s = str_replace("\"", '', $s);
        return $s;
    }

}