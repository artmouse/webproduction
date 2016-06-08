<?php
class calendar_block extends Engine_Class {

    public function process() {
        // сохранение настроек этапа
        if ($this->getArgumentSecure('setting-info-ok')) {
            try {
                $status = Shop::Get()->getShopService()->getStatusByID(
                    $this->getArgument('setting-status-id')
                );

                $order = Shop::Get()->getShopService()->getOrderByID($this->getArgument('setting-order-id'));
                if ($new_issue = $this->getArgumentSecure('new_issue')) {
                    $new_issue = explode("\n", $new_issue);
                    foreach ($new_issue as $issueName) {
                        if (!$issueName) {
                            continue;
                        }
                        $worlflowId = 0;
                        try {
                            // Бизнесс-процесс по умолчанию.
                            $default = Shop::Get()->getShopService()->getOrderCategoryAll();
                            $default->setDefault(1);
                            $default->setType('issue');
                            if ($default->select()) {
                                $worlflowId = $default->getId();
                            }
                            // создаем задачу
                            $issue = IssueService::Get()->addIssue(
                                $this->getUser(),
                                $issueName,
                                false,
                                $this->getArgumentSecure('manager_status'),
                                $worlflowId,
                                false,
                                false,
                                $order->getId()
                            );

                            $issue->setParentstatusid($status->getId());
                            $issue->update();
                        } catch (Exception $e) {

                        }

                    }


                }

                Shop::Get()->getShopService()->updateOrderEmployer(
                    $order,
                    $status,
                    $this->getUser(),
                    $this->getArgumentSecure('statusTerm'),
                    $this->getArgumentSecure('manager_status')
                );

            } catch (Exception $e) {

            }
            // отлавливаем удаление и изменение
            foreach ($this->getArguments() as $key => $item) {
                if (strpos($key, 'issueClosed_') === 0) {
                    $orderId = str_replace('issueClosed_', '', $key);
                    try {
                        $orderDelete = Shop::Get()->getShopService()->getOrderByID($orderId);
                        Shop::Get()->getShopService()->deleteOrder($orderDelete);
                    } catch (Exception $e) {

                    }

                }

                if (strpos($key, 'manager_') === 0) {
                    $orderId = str_replace('manager_', '', $key);
                    try {
                        $order = Shop::Get()->getShopService()->getOrderByID($orderId);
                        $order->setDateto($this->getArgumentSecure('date_to_'.$orderId));
                        $order->setManagerid($this->getArgumentSecure('manager_'.$orderId));
                        $order->update();
                    } catch (Exception $e2) {

                    }
                }
            }

        }

        $whatShowInIssue = Shop::Get()->getSettingsService()->getSettingValue('calendar-show-issue');
        $whatShowInIssue = unserialize($whatShowInIssue);

        if (!$whatShowInIssue) {
            $whatShowInIssue = array();
        }

        // Что показываем по умолчанию (Месяц или неделю)
        $weekMonth = false;
        if (!isset($_COOKIE['calendarTypeCookie'])) {
            $weekMonth = 'week';
        } else {
            if ($show = $this->getArgumentSecure('show')) {
                // May be need
                // $weekMonth = $show;
                $weekMonth = ($_COOKIE['calendarTypeCookie'] == 'js-by-month') ? 'month' :
                (($_COOKIE['calendarTypeCookie'] == 'js-by-week') ? 'week' : 'day');
            } else {
                $weekMonth = ($_COOKIE['calendarTypeCookie'] == 'js-by-month') ? 'month' :
                (($_COOKIE['calendarTypeCookie'] == 'js-by-week') ? 'week' : 'day');
            }
        }
        try {
            $weekMonth = $this->getArgument('calendarType');
            $weekMonth = ($weekMonth == 'js-by-month') ? 'month' :
                (($_COOKIE['calendarTypeCookie'] == 'js-by-week') ? 'week' : 'day');
        } catch (Exception $e) {

        }

        $this->setValue('weekMonth', $weekMonth);

        $this->setValue('dateCurrent', date('Y-m-d'));

        $m = $this->getArgumentSecure('month') ? $this->getArgumentSecure('month') : 'm';
        $y = $this->getArgumentSecure('year') ? $y = $this->getArgumentSecure('year') : 'Y';

        if (is_numeric($m) && $m < 10) {
            $m = '0'.$m;
        }

        // Даты начала, и конца месяца
        $dateMonthStart = date("{$y}-{$m}-01");
        $dateMonthEnd = date("{$y}-{$m}")."-".date('t', strtotime($dateMonthStart));

        $this->setValue('dataMonth', date("n", strtotime($dateMonthStart)));
        $this->setValue('dataYear', date("Y", strtotime($dateMonthStart)));
        $this->setValue('dataMonthName', $this->_createCurrMonthName($dateMonthStart));

        $dateMonthStartReal = $dateMonthStart;
        $dateMonthEndReal = $dateMonthEnd;

        // начало месяца должно быть с пондельника, что бы в календаре не было дыр
        while (date('w', strtotime($dateMonthStart)) != 1) {
            $dateMonthStart =
                DateTime_Object::FromString($dateMonthStart)->addDay(-1)->setFormat('Y-m-d')->__toString();
        }

        // конец месяца должено быть воскресенье, что бы в календаре не было дыр
        while (date('w', strtotime($dateMonthEnd)) != 0) {
            $dateMonthEnd = DateTime_Object::FromString($dateMonthEnd)->addDay(1)->setFormat('Y-m-d')->__toString();
        }

        $user = $this->getUser();

        // Задачи на месяц, день, alert's
        $monthArray = array();
        $weekArray = array();
        $alertArray = array();

        // Необходимо выполнить на это время
        $orders = $this->_getIssues();

        $whereArray = $orders->getWhere();
        $returnWhereArray = array();
        foreach ($whereArray as $key => $where) {
            $returnWhereArray[$key] = htmlspecialchars(json_encode($where));
        }

        $this->setValue('whereArray', $returnWhereArray);
        $this->setValue('valueArray', $orders->getValues());

        $last = new XShopOrder();
        $last->setOrder('cdate', 'DESC');
        $last->setLimitCount(25);
        $last->setType('issue');
        $last->setAuthorid($user->getId());
        $lastProject = array();
        $dublArray = array();
        while ($x = $last->getNext()) {
            try {               
                if (!in_array($x->getParentid(), $dublArray)) {
                    $idOrder = $x->getParentid();
                    $dublArray[] = $idOrder;
                    $name = Shop_ShopService::Get()->getOrderByID($idOrder)->getName();
                    $lastProject[] = array(
                        'name' => $name,
                        'id' => $idOrder,
                    );
                    if (count($dublArray) > 5) {
                        break;
                    }
                }
            } catch (Exception $ex) {
                
            }
        }
        $this->setValue('lastProject', $lastProject);
        
        $managerID = $this->getArgumentSecure('filtermanagerid');
        if (!$managerID) {
            $managerID = $user->getId();
        }
        $this->setValue('managerid', $managerID);

        // Все менеджера (Для создания задачи)
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        $a = array();
        while ($x = $managers->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(true, true, true),
                'selected' => ($x->getId() == $managerID)
            );
        }
        $this->setValue('managerArray', $a);

        // все бизнес процессы
        $wokrflowAll = Shop::Get()->getShopService()->getWorkflowsAll($user);
        $wokrflowAll->setType('issue');
        $workflowArray = array();
        while ($tmpWorkflow = $wokrflowAll->getNext()) {
            $workflowArray[] = array(
                'id' => $tmpWorkflow->getId(),
                'name' => $tmpWorkflow->getName()
            );
        }
        $this->setValue('workflowArrayIssue', $workflowArray);

        // все бизнес процессы
        $wokrflowAll = Shop::Get()->getShopService()->getWorkflowsAll($user);
        $wokrflowAll->setType('order');
        $workflowArray = array();
        while ($tmpWorkflow = $wokrflowAll->getNext()) {
            $workflowArray[] = array(
                'id' => $tmpWorkflow->getId(),
                'name' => $tmpWorkflow->getName(),
                'default' => $tmpWorkflow->getDefault()
            );
        }
        $this->setValue('workflowArrayOrder', $workflowArray);

        // Дни рождения
        if ($user->isAllowed('users') && 0) {
            $users = Shop::Get()->getUserService()->getUsersAll($user);
            $users->addWhereQuery(
                'DAYOFYEAR(`bdate`) BETWEEN DAYOFYEAR(\''.$dateMonthStart.'\') AND DAYOFYEAR(\''.$dateMonthEnd.'\')'
            );
            $users->setOrder('bdate', 'ASC');
            while ($x = $users->getNext()) {
                $d = date('Y').DateTime_Object::FromString($x->getBdate())->setFormat('-m-d')->__toString();

                try {
                    $infoArray = array(
                        'id' => $x->getId(),
                        'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_birthday').
                            ' '.$x->makeName(false),
                        'url' => $x->makeURLEdit(),
                        'type' => 'user'
                    );

                    $weekArray[date("W", strtotime($d))][$d][] = $infoArray;
                    $monthArray[$d][] = $infoArray;

                } catch (Exception $e) {

                }

                // если др еще не прошло - в уведомления ее
                if (!($d < date('Y-m-d'))) {
                    @$alertArray[$d]++;
                }
            }
        }

        /*try {
            // с каким workfkow создаются уведомления
            $workflowNotifyID = Engine::Get()->getConfigField('project-box-notify-workflowid');
        } catch (Exception $eee) {
            $workflowNotifyID = false;
        }*/

        // Выбираем заказы за выбранный месяц
        if (!Shop::Get()->getSettingsService()->getSettingValue('calendar-cdate')) {
            $dateYearStartTmp = DateTime_Object::FromString($dateMonthStart)->setFormat('Y')->__toString();
            $dateYearEndTmp = DateTime_Object::FromString($dateMonthEnd)->setFormat('Y')->__toString();

            if ($dateYearEndTmp == $dateYearStartTmp) {
                $orders->setDatetoyear($dateYearStartTmp);
            } else {
                $yearArray = array();
                for ($i = $dateYearStartTmp; $i<=$dateYearEndTmp; $i++) {
                    $yearArray[] = $i;
                }
                $orders->filterDatetoyear($yearArray);
            }

            $dateMonthStartTmp = (int) DateTime_Object::FromString($dateMonthStart)->setFormat('m')->__toString();
            $dateMonthEndTmp = (int) DateTime_Object::FromString($dateMonthEnd)->setFormat('m')->__toString();

            if ($dateMonthStartTmp == $dateMonthEndTmp) {
                $orders->setDatetomonth($dateMonthEndTmp);
            } else {
                $monthArray = array();
                while ($dateMonthStartTmp != $dateMonthEndTmp) {
                    $monthArray[] = $dateMonthStartTmp;

                    if ($dateMonthStartTmp == 12) {
                        $dateMonthStartTmp = 1;
                    } else {
                        $dateMonthStartTmp++;
                    }
                }

                $monthArray[] = $dateMonthEndTmp;

                $orders->filterDatetomonth($monthArray);
            }
        } else {
            $orders->addWhere(
                'cdate',
                DateTime_Object::FromString($dateMonthStart)->addDay(-7)->setFormat('Y-m-d')->__toString(),
                '>='
            );
            $orders->addWhere(
                'cdate',
                DateTime_Object::FromString($dateMonthEnd)->addDay(7)->setFormat('Y-m-d')->__toString().' 23:59:59',
                '<='
            );
        }

        $workflowsType = array();

        $workflowTypeObj = new XShopWorkflowType();
        $workflowTypeObj->setCalendarShow(1);
        while ($typeobj = $workflowTypeObj->getNext()) {
            $workflowsType[] = $typeobj->getType();
        }

        if ($workflowsType) {
            $orders->addWhereArray($workflowsType, 'type');
        }

        /*if (Shop::Get()->getSettingsService()->getSettingValue('calendar-show-issue-priority')) {
            $orders->setOrder('TIME(`dateto`) <> "00:00:00" DESC, dateto ASC', false);
        } else {
            $orders->setOrder('priority = 0, priority, dateto ASC', false);
        }*/
        $orders->setOrder(false, false);
        $orders->setLimit(0, 0);

        $statusIDDoneArray = array(-1);
        $tmp = Shop::Get()->getShopService()->getStatusAll();
        $tmp->filterDone(1);
        while ($x = $tmp->getNext()) {
            $statusIDDoneArray[] = $x->getId();
        }

        $userId = $this->getUser()->getId();

        // если выбран manager, меняем запрос
        $managerId = false;
        $objValues = $orders->getValues();
        if (array_key_exists('managerid', $orders->getValues())) {
            $managerId = $objValues['managerid'];
            $orders->unsetField('managerid');
            $orders->addWhereQuery('(`managerid` = "'.$managerId.'" OR `authorid` = "'.$userId.'")');
        }

        while ($x = $orders->getNext()) {
            if (Shop::Get()->getSettingsService()->getSettingValue('calendar-cdate')) {
                $d = DateTime_Object::FromString($x->getCdate())->setFormat('Y-m-d')->__toString();
            } else {
                $d = DateTime_Object::FromString($x->getDateto())->setFormat('Y-m-d')->__toString();

            }

            // запрос берет лишнее дни, отсикаем их
            if ($d < $dateMonthStart || $d > $dateMonthEnd) {
                continue;
            }

            // Задачи в этапе "Ожидает проверки" создателю
            // был выбран конкретный менеджер
            // пользователь = автор
            // но не = manager, и задача не в статусе проверки, значит они лишняя и ее пропускаем
            if ($managerId && $userId == $x->getAuthorid() && $managerId != $x->getManagerid()
                && !in_array($x->getStatusid(), $statusIDDoneArray)
            ) {
                continue;
            }

            $infoArray = $this->_makeOrderArray($x);

            // пользотваель не автор, и задача ожидает проверки, то показываем как закрытую
            if ($userId != $x->getAuthorid() && in_array($x->getStatusid(), $statusIDDoneArray)) {
                $infoArray['closed'] = '1';
            }

            if (!in_array('name', $whatShowInIssue)) {
                $infoArray['name'] = '';
                $infoArray['nameClear'] = '';
            }
            if (!in_array('project', $whatShowInIssue)) {
                $infoArray['projectName'] = '';
            }
            if (!in_array('client', $whatShowInIssue)) {
                $infoArray['clientName'] = '';
            }
            $weekArray[date("W", strtotime($d))][$d][] = $infoArray;
            $monthArray[$d][] = $infoArray;

            if (!$infoArray['closed']) {
                // задача не закрыта - в уведомления ее
                @$alertArray[$d]++;
            }
        }

        $managerID = $this->getArgumentSecure('filtermanagerid');
        try {
            $this->getArgument('filtermanagerid');
            $managerIdEmployer = $managerID;
        } catch (Exception $e2) {
            $managerIdEmployer = $this->getUser()->getId();
        }


        $statusIDDone1Array = array(-1);
        $tmp = Shop::Get()->getShopService()->getStatusAll();
        $tmp->filterDone(1);
        while ($x = $tmp->getNext()) {
            $statusIDDone1Array[] = $x->getId();
        }

        // этапы
        $employer = new XShopOrderEmployer();
        if ($managerIdEmployer) {
            $employer->setManagerid($managerIdEmployer);
        }
        $employer->addWhere('term', $dateMonthStart, '>=');
        $employer->addWhere('term', $dateMonthEnd.' 23:59:59', '<=');
        $employer->setOrder('term', 'ASC');

        $eorders = $this->_getIssues();
        $eorders->unsetField('managerid');
        $eorders->unsetField('statusid');
        $eordersIDArray = array(-1);
        while ($eorder = $eorders->getNext()) {
            $eordersIDArray[] = $eorder->getId();
        }

        $employer->addWhereArray($eordersIDArray, 'orderid');

        while ($em = $employer->getNext()) {
            try {
                $emStatus = Shop::Get()->getShopService()->getStatusByID($em->getStatusid());

                $subIssue = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
                $subIssue->setParentid($em->getOrderid());
                $subIssue->setParentstatusid($em->getStatusid());

                $allClosed = true;
                $subIssueCount = 0;
                while ($sub = $subIssue->getNext()) {
                    $subIssueCount++;
                    if ($sub->getDateclosed() == '0000-00-00 00:00:00') {
                        $allClosed = false;
                        break;
                    }
                }

                $projectName = false;
                $clientName = false;
                $projectColor = false;

                try {
                    $emOrder = Shop::Get()->getShopService()->getOrderByID($em->getOrderid());
                    if ($emOrder->isClosed()) {
                        continue;
                    }

                    if ($emOrder->getDeleted()) {
                        continue;
                    }

                    if (in_array('project', $whatShowInIssue)) {
                        try {
                            $projectName = $emOrder->getParent()->getName();
                            $projectColor = $emOrder->getParent()->makeColor();
                        } catch (ServiceUtils_Exception $see) {

                        }
                    }


                    if (in_array('client', $whatShowInIssue)) {
                        try {
                            $clientName = $emOrder->getClient()->makeName('lfmcompany');
                        } catch (ServiceUtils_Exception $see) {

                        }
                    }
                } catch (Exception $e2) {
                    $emOrder = false;
                }

                $dateTo = $em->getTerm();

                $d2 = DateTime_Object::FromString($dateTo)->setFormat('Y-m-d')->__toString();


                $time = DateTime_Formatter::TimeISO8601($dateTo);

                if ($time == '00:00') {
                    $time = false;
                }


                $nameClear = false;
                try{
                    if ($emOrder) {
                        $nameClear = $emOrder->getName();
                        if (!$nameClear) {
                            $nameClear = $emOrder->makeName();
                        }
                    }

                } catch (Exception $ee) {

                }

                $employerArray = array(
                    'employerId' => $em->getId(),
                    'statusName' => $emStatus->makeName(),
                    'nameClear' => $nameClear,
                    'statusId' => $emStatus->getId(),
                    'id' => $em->getOrderid(),
                    'name' => $emOrder ? $emOrder->makeName():$em->getId(),
                    'closed' => $emOrder ? $emOrder->isClosed():false,
                    'url' => $emOrder ? $emOrder->makeURLEdit():false,
                    'time' => $time,
                    'projectName' => $projectName,
                    'clientName' => $clientName,
                    'iColor' => $projectColor,
                    'colour' => $emStatus->getColour(),
                    'allClosed' => $subIssueCount ? $allClosed:false,
                    'fireIssue' => Shop::Get()->getShopService()->isFireOrderStatus(
                        Shop::Get()->getShopService()->getOrderByID($em->getOrderid()),
                        $emStatus
                    ),
                );


                if (!in_array('name', $whatShowInIssue)) {
                    $employerArray['name'] = false;
                    $employerArray['nameClear'] = '';
                }

                $weekArray[date("W", strtotime($d2))][$d2][] = $employerArray;
                $monthArray[$d2][] = $employerArray;

            } catch (Exception $e2) {

            }

        }

        foreach ($monthArray as $key => $date) {
            if (is_array($date)) {
                usort($date, array($this, '_sortClosedPriority'));
                $monthArray[$key] = $date;
            }
        }

        foreach ($weekArray as $key=>$indexWeek) {
            foreach ($indexWeek as $keyDate => $date) {
                if (is_array($date)) {
                    usort($date, array($this, '_sortClosedPriority'));
                    $indexWeek[$keyDate] = $date;
                }

            }
            $weekArray[$key] = $indexWeek;
        }

        $this->setValue('calendarMonthArray', $monthArray);
        $this->setValue('calendarWeekArray', $weekArray);
        $this->setValue('calendarAlertArray', $alertArray);

        $monthDays = array();
        $monthDaysClear = array();
        $weekDays = array();
        $weekArray = array();
        $from = DateTime_Object::FromString($dateMonthStart)->setFormat('Y-m-d');
        $otherMonth = true;
        while ($from->__toString() <= $dateMonthEnd) {
            $date = $from->__toString();

            if ($otherMonth && DateTime_Object::FromString($date)->setFormat('d')->__toString() == 1) {
                $otherMonth = false;
            } elseif (!$otherMonth && DateTime_Object::FromString($date)->setFormat('d')->__toString() == 1) {
                $otherMonth = true;
            }

            if (!$otherMonth) {
                $monthDaysClear[] = array(
                    'date' => $date,
                    'day' => DateTime_Object::FromString($date)->setFormat('d')->__toString(),
                    'dayClear' => DateTime_Object::FromString($date)->setFormat('j')->__toString(),
                    'dayNameFull' => $this->_getFullDayNameByDate($date),
                    'dayName' => $this->_getDayNameByDate($date),
                    'otherMonth' => $otherMonth
                );
            }


            $monthDays[] = array(
                'date' => $date,
                'day' => DateTime_Object::FromString($date)->setFormat('d')->__toString(),
                'dayClear' => DateTime_Object::FromString($date)->setFormat('j')->__toString(),
                'dayNameFull' => $this->_getFullDayNameByDate($date),
                'dayName' => $this->_getDayNameByDate($date),
                'otherMonth' => $otherMonth
            );
            $weekDays[date("W", strtotime($date))][] = array(
                'date' => $date,
                'day' => DateTime_Object::FromString($date)->setFormat('d')->__toString(),
                'dayClear' => DateTime_Object::FromString($date)->setFormat('j')->__toString(),
                'dayNameFull' => $this->_getFullDayNameByDate($date),
                'dayName' => $this->_getDayNameByDate($date),
                'otherMonth' => $otherMonth

            );
            $weekArray[] = date("W", strtotime($date));

            $from->addDay(+1);
        }

        $currentWeek = $weekArray[0];
        $currentDay = 0;

        if (in_array(date('W'), $weekArray) && !$this->getArgumentSecure('year')) {
            $currentWeek = date('W');
            $currentDay = date('d') - 1;
        }

        if ($this->getArgumentSecure('lastWeek')) {
            $currentWeek = $weekArray[count($weekArray) - 1];
            $currentDay = DateTime_Differ::DiffDay($dateMonthEndReal, $dateMonthStartReal);
        }

        $this->setValue('calendarMonthDateArray', $monthDays);
        $this->setValue('calendarMonthDateClearArray', $monthDaysClear);
        $this->setValue('calendarWeekDateArray', $weekDays);
        $this->setValue('calendarCurrentWeek', $currentWeek);

        $date = DateTime_Object::FromString($dateMonthStartReal)->setFormat('Y-m-')->__toString().($currentDay + 1);

        $this->setValue(
            'calendarCurrentDay',
            array(
                'key' => $currentDay,
                'date' => $date,
                'day' => DateTime_Object::FromString($date)->setFormat('d')->__toString(),
                'dayClear' => DateTime_Object::FromString($date)->setFormat('j')->__toString(),
                'dayNameFull' => $this->_getFullDayNameByDate($date),
                'dayName' => $this->_getDayNameByDate($date)
            )
        );

        $this->setValue('calendarMonth', $this->_createCurrMonthName($dateMonthStartReal));

        $this->setValue(
            'dynamic_workflow_type_in_menu',
            !Engine::Get()->getConfigFieldSecure('static-shop-menu')
        );

        // сколько дней нужно пропустить в начале месяца?
        $date = DateTime_Object::FromString($dateMonthStart);
        $skipDay = $date->setFormat('N')->__toString() - 1;
        $this->setValue('skipDay', $skipDay);

        // бизнес-процесс для создания новых задач
        $workflow = new ShopOrderCategory();
        $workflow->setDefault(1);
        $workflow->setType('issue');
        if ($w = $workflow->getNext()) {
            $this->setValue('workflowID', $w->getId());
        }
    }

    private function _getDayNameByDate($date) {
        $dayNumber = date("w", strtotime($date));
        $daysNameArray = array(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_vs'),
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_pn'),
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_vt'),
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_sr'),
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_cht'),
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_pt'),
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_sb')
        );

        return $daysNameArray[$dayNumber];
    }

    private function _getFullDayNameByDate($date) {
        $dayNumber = date("w", strtotime($date));
        $daysNameArray = array(
            'Воскресенье',
            'Понедельник',
            'Вторник',
            'Среда',
            'Четверг',
            'Пятница',
            'Суббота'
        );

        return $daysNameArray[$dayNumber];
    }

    private function _createCurrMonthName($date) {
        $monthRuNamesArray = array(
        '',
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_yanvar'),
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_fevral'),
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_mart'),
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_aprel'),
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_may'),
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_iyun'),
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_iyul'),
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_avgust'),
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_sentyabr'),
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_oktyabr'),
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_noyabr'),
        Shop::Get()->getTranslateService()->getTranslateSecure('translate_dekabr'),
        );
        $monthNumber = date('n', strtotime($date));

        return array("month" => $monthRuNamesArray[$monthNumber], "year" => date("Y", strtotime($date)));

    }

    /**
     * Получить задачи
     *
     * @return ShopOrder
     */
    private function _getIssues() {
        return $this->getValue('issue');
    }

    /**
     * Получить массив с информацией о задаче
     *
     * @param ShopOrder $order
     *
     * @return array
     */
    private function _makeOrderArray(ShopOrder $order) {
        if (Shop::Get()->getSettingsService()->getSettingValue('calendar-cdate')) {
            $time = DateTime_Formatter::TimeISO8601($order->getCdate());
        } else {
            $time = DateTime_Formatter::TimeISO8601($order->getDateto());
        }

        if ($time == '00:00') {
            $time = false;
        }

        try {
            $projectName = $order->getParent()->getName();
            $projectColor = $order->getParent()->makeColor();
        } catch (ServiceUtils_Exception $se) {
            $projectName = false;
            $projectColor = false;
        }

        try {
            $clientName = $order->getClient()->makeName('lfmcompany');
        } catch (ServiceUtils_Exception $see) {
            $clientName = false;
        }

        $nameClear = false;
        try {
            if ($order) {
                $nameClear = $order->getName();
                if (!$nameClear) {
                    $nameClear = $order->makeName();
                }
            }

        } catch (Exception $ee) {

        }

        try {
            $done = $order->getStatus()->getDone();
        } catch (Exception $e) {
            $done = false;
        }

        $infoArray = array(
            'employerId' => $order->getManagerid(),
            'statusid' => $order->getStatusid(),
            'nameClear' => $nameClear,
            'name' => $order->makeName(),
            'url' => $order->makeURLEdit(),
            'closed' => $order->isClosed(),
            'closedDate' => $order->getDateclosed(),
            'done' => $done,
            'id' => $order->getId(),
            'time' => $time,
            'dateto' => $order->getDateto(),
            'cdate' => $order->getCdate(),
            'isProject' => $order->getParentid() == 0,
            'isSortable' => $order->getType() == 'issue',
            'description' => nl2br(htmlspecialchars($order->getComments())),
            'projectName' => $projectName,
            'clientName' => $clientName,
            'iColor' => $projectColor,
            'prior' => $order->getPriority(),
            'new' => ($order->getType() == 'issue' && !$order->isClosed() && !$order->getPriority() && !$done),
            'fireIssue' => Shop::Get()->getShopService()->isFireOrder($order),
        );

        return $infoArray;
    }

    /**
     * Выполнить сортировку.
     * Closed опускается вниз.
     * Priority 0 опускается вниз.
     * Все остальные задачи по приоритету от 1 до N.
     *
     * @param array $a
     * @param array $b
     *
     * @return int
     */
    private function _sortClosedPriority($a, $b) {

        if ($a['closed'] && $b['closed']) {
            return DateTime_Differ::DiffMinute($a['closedDate'], $b['closedDate']) > 0;
        }

        if ($a['closed']) {
            return 1;
        }

        if ($b['closed']) {
            return -1;
        }

        if (Shop::Get()->getSettingsService()->getSettingValue('calendar-show-issue-priority')) {
            if (!$a['time'] && !$b['time']) {
                if (!$a['prior']) {
                    return 1;
                }

                if (!$b['prior']) {
                    return -1;
                }

                return $a['prior'] > $b['prior'];
            }

            if (!$a['time']) {
                return 1;
            }

            if (!$b['time']) {
                return -1;
            }

            if (Shop::Get()->getSettingsService()->getSettingValue('calendar-cdate')) {
                return DateTime_Differ::DiffMinute($a['cdate'], $b['cdate']) > 0;
            } else {
                return DateTime_Differ::DiffMinute($a['dateto'], $b['dateto']) > 0;
            }
        } else {
            if (!$a['prior']) {
                return 1;
            }

            if (!$b['prior']) {
                return -1;
            }

            return $a['prior'] > $b['prior'];
        }

        return $a['prior'] > $b['prior'];
    }

}