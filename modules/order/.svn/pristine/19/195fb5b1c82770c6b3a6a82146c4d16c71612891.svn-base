<?php
class report_managercompare extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom');
        $dateTo = $this->getArgumentSecure('dateto');

        if (!$dateFrom) {
            $dateFrom = DateTime_Object::Now()->addMonth(-1)->setFormat('Y-m-d')->__toString();

            $this->setControlValue('datefrom', $dateFrom);
        } else {
            $dateFrom = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d')->__toString();
        }
        if (!$dateTo) {
            $dateTo = DateTime_Object::Now()->setFormat('Y-m-d')->__toString();

            $this->setControlValue('dateto', $dateTo);
        } else {
            $dateTo = DateTime_Object::FromString($dateTo)->setFormat('Y-m-d')->__toString();
        }

        $sourceID = $this->getArgumentSecure('sourceid', 'int');
        $managerID = $this->getArgumentSecure('managerid', 'int');
        $authorID = $this->getArgumentSecure('authorid', 'int');
        $contractorID = $this->getArgumentSecure('contractorid', 'int');
        $arrayGroupId = $this->getArgumentSecure('groupsid', 'array');
        
        $workflowIDArray = $this->getArgumentSecure('workflowid', 'array');
        $statusIDArray = $this->getArgumentSecure('statusid', 'array');

        // строим массив статусов, которые покажем в шапке
        $statusArray = array();
        foreach ($statusIDArray as $statusID) {
            try {
                $statusArray[$statusID] = Shop::Get()->getShopService()->getStatusByID($statusID)->makeName();
            } catch (Exception $statusEx) {

            }
        }
        $this->setValue('statusArray', $statusArray);

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

        $reportArray = array();

        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $this->setValue('currency', $currencySystem->getSymbol());
                           
        while ($order = $orders->getNext()) {
            try {
                if ($arrayGroupId) {
                    $group = new XShopUser2Group();
                    $group->setUserid($order->getUserid());
                    $group->addWhereArray($arrayGroupId, 'groupid');
                    if (!$group->getNext()) {
                        continue;
                    }
                }
                $sum = $order->getSumbase();

                if (empty($reportArray[$order->getManagerid()])) {
                    $reportArray[$order->getManagerid()] = array(
                    'name' => $this->_escapeString($order->getManager()->makeName(true, 'lfm')),
                    'url' => $order->getManager()->makeURLEdit(),
                    'id' => $order->getManager()->getId(),
                    'count' => 1,
                    'sum' => $sum,
                    );
                } else {
                    $reportArray[$order->getManagerid()]['count'] ++;
                    $reportArray[$order->getManagerid()]['sum'] += $sum;
                }
            } catch (Exception $e) {

            }
        }

        // считаем другие показатели
        foreach ($reportArray as $managerID => $a) {
            $a['avg'] = round($a['sum'] / $a['count'], 2);

            try {
                $manager = Shop::Get()->getUserService()->getUserByID($managerID);
            } catch (Exception $e) {
                continue;
            }

            // количество входящих звонков
            $events = $manager->getEvents(false, 'from');
            $events->setType('call');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['calls_out'] = $events->getCount();

            // количество исходящих звонков
            $events = $manager->getEvents(false, 'to');
            $events->setType('call');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['calls_in'] = $events->getCount();

            $a['calls_total'] = $a['calls_in'] + $a['calls_out'];

            // количество входящих email
            $events = $manager->getEvents(false, 'from');
            $events->setType('email');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['emails_in'] = $events->getCount();

            // количество исходящих email
            $events = $manager->getEvents(false, 'to');
            $events->setType('email');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['emails_out'] = $events->getCount();

            $a['emails_total'] = $a['emails_in'] + $a['emails_out'];

            // количество meeting
            $events = $manager->getEvents();
            $events->setType('meeting');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['meeting_total'] = $events->getCount();

            // количество skype
            $events = $manager->getEvents();
            $events->setType('skype');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['skype_total'] = $events->getCount();

            // количество sms
            $events = $manager->getEvents();
            $events->setType('sms');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['sms_total'] = $events->getCount();

            // количество viber
            $events = $manager->getEvents();
            $events->setType('viber');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['viber_total'] = $events->getCount();

            // количество whatsapp
            $events = $manager->getEvents();
            $events->setType('whatsapp');
            $events->addWhere('cdate', $dateFrom, '>=');
            $events->addWhere('cdate', $dateTo, '<=');
            $a['whatsapp_total'] = $events->getCount();

            $a['events_total'] = $a['calls_total'] + $a['emails_total'];
            $a['events_total'] += $a['meeting_total'];
            $a['events_total'] += $a['skype_total'];
            $a['events_total'] += $a['sms_total'];
            $a['events_total'] += $a['viber_total'];
            $a['events_total'] += $a['whatsapp_total'];

            // считаем количество заказов, которые менеджер перевел в это statusID
            foreach ($statusIDArray as $statusID) {
                $tmp = new XShopOrderChange();
                $tmp->setUserid($managerID);
                $tmp->setKey('statusid');
                $tmp->setValue($statusID);
                $tmp->addWhere('cdate', $dateFrom, '>=');
                $tmp->addWhere('cdate', $dateTo, '<=');
                $cnt = $tmp->getCount();

                $a['statusArray'][$statusID] = $cnt;
                $a['events_total'] += $cnt;
            }

            if ($a['events_total']) {
                $a['events_price'] = round($a['sum'] / $a['events_total'], 2);
            } else {
                $a['events_price'] = 0;
            }


            $reportArray[$managerID] = $a;
        }

        $this->setValue('reportArray', $reportArray);

        // -------

        // менеджеры
        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, 'lfm'),
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
        
        $groups = Shop::Get()->getUserService()->getUserGroupsAll();
        $groupArray = array();
        while ($gr = $groups->getNext()) {
            $groupArray[] = array (
                'id' => $gr->getId(),
                'name' => $gr->getName(),
                'selected' => in_array($gr->getId(), $arrayGroupId)
            ); 
        }
        $this->setValue('groupArray', $groupArray);
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