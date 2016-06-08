<?php
class report_clientorders extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom');
        $dateTo = $this->getArgumentSecure('dateto');

        if (!$dateFrom) {
            $dateFrom = DateTime_Object::Now()->addDay(+0)->setFormat('Y-m-01')->__toString();

            $this->setControlValue('datefrom', $dateFrom);
        } else {
            $dateFrom = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d')->__toString();
        }
        if (!$dateTo) {
            $dateTo = DateTime_Object::Now()->addMonth(+1)->setFormat('Y-m-t')->__toString();

            $this->setControlValue('dateto', $dateTo);
        } else {
            $dateTo = DateTime_Object::FromString($dateTo)->setFormat('Y-m-d')->__toString();
        }

        $workflowIDArray = $this->getArgumentSecure('workflowid', 'array');
        $statusIDArray = $this->getArgumentSecure('statusid', 'array');
        $sourceID = $this->getArgumentSecure('sourceid', 'int');
        $managerID = $this->getArgumentSecure('managerid', 'int');
        $authorID = $this->getArgumentSecure('authorid', 'int');
        $contractorID = $this->getArgumentSecure('contractorid', 'int');
        $groupCompany = $this->getArgumentSecure('groupcompany', 'bool');
        $direction = $this->getArgumentSecure('direction', 'string');

        $typeArray = $this->getArgumentSecure('type', 'array');
        if (!$typeArray) {
            $typeArray = array('', 'order', 'project');
        }
        $this->setValue('typeArray', $typeArray);
        
        // -------

        // идем по всем заказам и считаем статистику

        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
        $orders->addWhereArray($typeArray, 'type');
        $orders->addWhere('cdate', $dateFrom, '>=');
        $orders->addWhere('cdate', $dateTo.' 23:59:59', '<=');
        if ($direction == 'in') {
            $orders->setOutcoming(0);
        }
        if ($direction == 'out') {
            $orders->setOutcoming(1);
        }
        if ($workflowIDArray) {
            $orders->addWhereArray($workflowIDArray, 'categoryid');
        }
        if ($sourceID) {
            $orders->setSourceid($sourceID);
        }
        if ($managerID) {
            $orders->setManagerid($managerID);
        }
        if ($authorID) {
            $orders->setAuthorid($authorID);
        }
        if ($contractorID) {
            $orders->setContractorid($contractorID);
        }
        if ($statusIDArray) {
            $orders->addWhereArray($statusIDArray, 'statusid');
        }

        $reportArray = array();

        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $this->setValue('currency', $currencySystem->getSymbol());

        while ($order = $orders->getNext()) {
            try {
                $sum = $order->getSumbase();

                if (empty($reportArray[$order->getUserid()])) {
                    $reportArray[$order->getUserid()] = array(
                    'name' => $this->_escapeString($order->getUser()->makeName()),
                    'count' => 1,
                    'sum' => $sum,
                    );
                } else {
                    $reportArray[$order->getUserid()]['count'] ++;
                    $reportArray[$order->getUserid()]['sum'] += $sum;
                }
            } catch (Exception $e) {

            }
        }

        // считаем другие показатели
        foreach ($reportArray as $clientID => $a) {
            $a['avg'] = round($a['sum'] / $a['count'], 2);

            try {
                $client = Shop::Get()->getUserService()->getUserByID($clientID);
            } catch (Exception $e) {
                continue;
            }

            $a['id'] = $client->getId();
            $a['url'] = $client->makeURLEdit();
            // количество входящих звонков
            $events = $client->getEvents(false, 'from');
            $events->setType('call');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['calls_in'] = $events->getCount();

            // количество исходящих звонков
            $events = $client->getEvents(false, 'to');
            $events->setType('call');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['calls_out'] = $events->getCount();

            $a['calls_total'] = $a['calls_in'] + $a['calls_out'];

            // количество входящих email
            $events = $client->getEvents(false, 'from');
            $events->setType('email');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['emails_in'] = $events->getCount();

            // количество исходящих email
            $events = $client->getEvents(false, 'to');
            $events->setType('email');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['emails_out'] = $events->getCount();

            $a['emails_total'] = $a['emails_in'] + $a['emails_out'];

            // количество meeting
            $events = $client->getEvents();
            $events->setType('meeting');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['meeting_total'] = $events->getCount();

            // количество skype
            $events = $client->getEvents();
            $events->setType('skype');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['skype_total'] = $events->getCount();

            // количество SMS
            $events = $client->getEvents();
            $events->setType('sms');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['sms_total'] = $events->getCount();

            $a['events_total'] = $a['calls_total'];
            $a['events_total'] += $a['emails_total'];
            $a['events_total'] += $a['meeting_total'];
            $a['events_total'] += $a['skype_total'];
            $a['events_total'] += $a['sms_total'];

            if ($a['events_total']) {
                $a['events_price'] = round($a['sum'] / $a['events_total'], 2);
            } else {
                $a['events_price'] = 0;
            }

            $reportArray[$clientID] = $a;
        }

        if ($groupCompany) {
            $reportCompanyArray = array();
            foreach ($reportArray as $clientID => $a) {
                try {
                    $client = Shop::Get()->getUserService()->getUserByID($clientID);
                } catch (Exception $e) {
                    continue;
                }

                $company = $client->getCompany();
                if (!$company) {
                    $company = $client->makeName();
                }

                $reportCompanyArray[$company]['id'] = $client->getId();
                $reportCompanyArray[$company]['name'] = $company;
                $reportCompanyArray[$company]['url'] = $client->makeURLEdit();
                @$reportCompanyArray[$company]['count'] += $a['count'];
                @$reportCompanyArray[$company]['sum'] += $a['sum'];
                @$reportCompanyArray[$company]['calls_in'] += $a['calls_in'];
                @$reportCompanyArray[$company]['calls_out'] += $a['calls_out'];
                @$reportCompanyArray[$company]['calls_total'] += $a['calls_total'];
                @$reportCompanyArray[$company]['emails_in'] += $a['emails_in'];
                @$reportCompanyArray[$company]['emails_out'] += $a['emails_out'];
                @$reportCompanyArray[$company]['emails_total'] += $a['emails_total'];
                @$reportCompanyArray[$company]['events_total'] += $a['events_total'];
                @$reportCompanyArray[$company]['meeting_total'] += $a['meeting_total'];
                @$reportCompanyArray[$company]['skype_total'] += $a['skype_total'];
                @$reportCompanyArray[$company]['sms_total'] += $a['sms_total'];
            }

            foreach ($reportCompanyArray as $clientName => $a) {
                $a['avg'] = round($a['sum'] / $a['count'], 2);
                if ($a['events_total']) {
                    $a['events_price'] = round($a['sum'] / $a['events_total'], 2);
                } else {
                    $a['events_price'] = 0;
                }

                $reportCompanyArray[$clientName] = $a;
            }

            $this->setValue('reportArray', $reportCompanyArray);
        } else {
            $this->setValue('reportArray', $reportArray);
        }

        // -------

        // менеджеры
        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            );
        }
        $this->setValue('managerArray', $a);

        // источники заказов
        $sources = Shop::Get()->getShopService()->getSourceAll();
        $this->setValue('sourceArray', $sources->toArray());

        // юридические лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $this->setValue('contractorArray', $contractors->toArray());

        // статусы заказов
        $block = Engine::GetContentDriver()->getContent('workflow-filter-block');
        $this->setValue('block_workflow_filter', $block->render());
    }

    private function _escapeString($s) {
        $s = trim($s);
        $s = str_replace("\n", '', $s);
        $s = str_replace("\r", '', $s);
        $s = str_replace("\t", '', $s);
        $s = str_replace("'", '', $s);
        $s = str_replace("\"", '', $s);
        return $s;
    }

}