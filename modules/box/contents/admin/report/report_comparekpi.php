<?php
class report_comparekpi extends Engine_Class {

    public function process() {
        // даты
        $dateFrom = $this->getArgumentSecure('datefrom');
        $dateTo = $this->getArgumentSecure('dateto');

        if (!$dateFrom) {
            $dateFrom = DateTime_Object::Now()->addDay(+0)->setFormat('Y-m-01')->__toString();

            $this->setControlValue('datefrom', $dateFrom);
        } else {
            $dateFrom = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d')->__toString();
        }
        if (!$dateTo) {
            $dateTo = DateTime_Object::Now()->addMonth(+0)->setFormat('Y-m-t')->__toString();

            $this->setControlValue('dateto', $dateTo);
        } else {
            $dateTo = DateTime_Object::FromString($dateTo)->setFormat('Y-m-d')->__toString();
        }

        $userIDArray = $this->getArgumentSecure('userid', 'array');
        $kpiIDArray = $this->getArgumentSecure('kpiid', 'array');

        $this->setValue('userIDArraySelected', $userIDArray);
        $this->setValue('kpiIDArraySelected', $kpiIDArray);

        $dateTo .= ' 23:59:59';

        // строим отчет
        $reportArray = array();

        // идем по всем KPI
        $kpis = KPIService::Get()->getKPIAll();
        if ($kpiIDArray) {
            $kpis->addWhereArray($kpiIDArray);
        }
        while ($kpi = $kpis->getNext()) {
            $dataArray = array();

            // получаем всех сотрудников, у которых есть такие KPI
            $kpiUser = new XShopKPIUser();
            $kpiUser->setKpiid($kpi->getId());
            $kpiUser->addWhere('cdate', $dateFrom, '>=');
            $kpiUser->addWhere('cdate', $dateTo, '<=');
            $kpiUser->setGroupByQuery('userid');
            if ($userIDArray) {
                $kpiUser->addWhereArray($userIDArray, 'userid');
            }
            while ($x = $kpiUser->getNext()) {
                try {
                    // получаем KPI этого юзера
                    $tmp = new XShopKPIUser();
                    $tmp->setKpiid($kpi->getId());
                    $tmp->setUserid($x->getUserid());
                    $tmp->addWhere('cdate', $dateFrom, '>=');
                    $tmp->addWhere('cdate', $dateTo, '<=');
                    $tmp->setOrder('cdate', 'DESC');
                    $tmp->setLimitCount(1);
                    if ($xtmp = $tmp->getNext()) {
                        $user = Shop::Get()->getUserService()->getUserByID($xtmp->getUserid());
                        $userName = $user->makeName(true, 'lfm');
                        $userURL = $user->makeURLEdit();

                        $fact = $xtmp->getValue();
                        $plan = $xtmp->getValuePlan();

                        $diff = round($fact - $plan, 2);
                        if ($fact) {
                            $diffPercent = round(($fact - $plan) / $plan * 100);
                        } else {
                            $diffPercent = 0;
                        }

                        $dataArray[] = array(
                        'userName' => $userName,
                        'userURL' => $userURL,
                        'plan' => $plan,
                        'fact' => $fact,
                        'diff' => $diff,
                        'diffPercent' => $diffPercent,
                        );
                    }
                } catch (Exception $e) {

                }
            }

            if (!$dataArray) {
                continue;
            }

            $reportArray[] = array(
                'name' => htmlspecialchars($kpi->getName()),
                'dataArray' => $dataArray,
            );
        }
        $this->setValue('reportArray', $reportArray);

        // сотрудники
        $manager = Shop::Get()->getUserService()->getUsersManagers();
        $a = array();
        while ($x = $manager->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(true, 'lfm'),
            );
        }
        $this->setValue('userArray', $a);

        // kpi
        $kpi = KPIService::Get()->getKPIAll();
        $a = array();
        while ($x = $kpi->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
            );
        }
        $this->setValue('kpiArray', $a);

        if (!Checker::CheckDate($dateFrom)) {
            $this->setControlValue('datefrom', DateTime_Object::Now()->addDay(-1)->setFormat('Y-m-d')->__toString());
        }
        if (!Checker::CheckDate($dateTo)) {
            $this->setControlValue('dateto', DateTime_Object::Now()->addDay(-1)->setFormat('Y-m-d')->__toString());
        }
    }

}