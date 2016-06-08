<?php
class user_kpi extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
                $this->getArgument('id')
            );

            if (!Shop::Get()->getUserService()->isUserChangeAllowed($user, $this->getUser())) {
                throw new ServiceUtils_Exception('user');
            }

            Engine::GetHTMLHead()->setTitle($user->makeName());

            $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
            $menu->setValue('selected', 'kpi');
            $menu->setValue('userid', $user->getId());
            $this->setValue('block_menu', $menu->render());

            // получаем валюту системы
            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // получаем массив KPI и фактические показатели под эти KPI
            $kpiIDArray = array(-1);
            $kpiFactArray = array();
            $roleArray = $user->getRoleArray();
            foreach ($roleArray as $role) {
                try {
                    $role = RoleService::Get()->getRoleByName($role);

                    $kpis = KPIService::Get()->getKPIByRole($role);
                    while ($kpi = $kpis->getNext()) {
                        $kpiIDArray[] = $kpi->getId();
                        $kpiFactArray[$kpi->getId()] = KPIService::Get()->getKPIFactByRole($role, $kpi);
                    }
                } catch (Exception $e) {

                }
            }

            // (все графики строим по месяцам)
            $datefrom = $this->getArgumentSecure('datefrom');
            $dateto = $this->getArgumentSecure('dateto');
            $group = $this->getArgumentSecure('group'); // day, month. year
            if ($datefrom && $dateto) {
                $datefrom = DateTime_Formatter::DateTimeISO9075(
                    DateTime_Object::FromString($datefrom)->setFormat('Y-m-d')
                );
                $dateto = DateTime_Formatter::DateTimeISO9075(
                    DateTime_Object::FromString($dateto)->setFormat('Y-m-d')
                );
            } else {
                $datefrom = DateTime_Formatter::DateTimeISO9075(
                    DateTime_Object::Now()->addMonth(-1)->setFormat('Y-m-d')
                );
                $dateto = DateTime_Formatter::DateTimeISO9075(
                    DateTime_Object::Now()->addMonth(0)->setFormat('Y-m-d')
                );

                $this->setControlValue('datefrom', $datefrom);
                $this->setControlValue('dateto', $dateto);
            }

            if (!$group) {
                $group = 'day';
            }

            $d = DateTime_Object::FromString($datefrom)->setFormat('Y-m-d');

            $dateArray = array();
            $reportArray = array();
            $kpiArray = array();

            while ($d->__toString() <= $dateto) {
                $date = $d->__toString();

                $dateStart = $date;

                // групируем результаты
                if ($group == 'day') {
                    $month = DateTime_Object::FromString($dateStart)->setFormat('Y-m-d')->addDay(+0)->__toString();
                } else if ($group == 'week') {
                    $month = DateTime_Object::FromString($dateStart)->setFormat('Y-m-t')->addDay(+6)->__toString();
                } else {
                    $month = DateTime_Object::FromString($dateStart)->setFormat('Y-m-t')->__toString();
                }

                $dateEnd = $month . ' 23:59:59';
                $dateArray[] = $date;

                $kpis = KPIService::Get()->getKPIAll();
                $kpis->filterID($kpiIDArray);
                while ($kpi = $kpis->getNext()) {
                    $kpiArray[$kpi->getId()] = htmlspecialchars($kpi->getName());

                    $tmp = new XShopKPIUser();
                    $tmp->setUserid($user->getId());
                    $tmp->setKpiid($kpi->getId());
                    $tmp->addWhere('cdate', $dateStart, '>=');
                    $tmp->addWhere('cdate', $dateEnd, '<=');
                    $tmp->setOrder('cdate', 'DESC');
                    $tmp->setLimitCount(1);

                    if ($x = $tmp->getNext()) {
                        try {
                            @$reportArray[$kpi->getId()][$date]['count']++;
                            @$reportArray[$kpi->getId()][$date]['fact'] += $x->getValue();
                            @$reportArray[$kpi->getId()][$date]['plan'] += $x->getValuePlan();
                        } catch (Exception $e) {

                        }
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

            $this->setValue('kpiArray', $kpiArray);
            $this->setValue('kpiFactArray', $kpiFactArray);
            $this->setValue('reportArray', $reportArray);
            $this->setValue('dateArray', $dateArray);

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}