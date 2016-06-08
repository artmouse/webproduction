<?php
class admin_report_designer extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();

        // все типы строк
        $rowAllArray = ReportService::Get()->getRowArray();
        $this->setValue('rowArray', $rowAllArray);

        // все колонки
        $columnAllArray = ReportService::Get()->getColumnArray();
        $this->setValue('columnArray', $columnAllArray);

        // получаем выбранные пользователем тип строк и колонки
        $row = $this->getControlValue('row');
        $columnArray = $this->getArgumentSecure('column', 'array');

        try {
            // получаем выбранный отчет
            $report = ReportService::Get()->getReportByID($this->getArgumentSecure('id'));

            if ($columnArray && $row && (explode(';', $report->getColumns()) != $columnArray || $report->getRow() != $row)) {
                // если юзер выбрал другие строку/колонку, это новый отчет
                throw new ServiceUtils_Exception();
            }

            if ($this->getControlValue('save')) {
                // сохранить отчет
                try {
                    ReportService::Get()->editReport(
                    $report,
                    $this->getControlValue('name')
                    );

                } catch (ServiceUtils_Exception $se) {
                    $this->setValue('message', 'error');
                }
            }

            if ($this->getControlValue('delete')) {
                // удалить отчет
                try {
                    ReportService::Get()->deleteReport(
                    $report
                    );
                } catch (ServiceUtils_Exception $se) {
                }

            } else {
                $row = $report->getRow();
                $columnArray = explode(';', $report->getColumns());

                $this->setValue('reportName', $report->makeName());
                $this->setValue('reportID', $report->getId());

                $this->setControlValue('row', $row);
                $this->setControlValue('name', $report->makeName());

                Engine::GetHTMLHead()->setTitle($report->makeName());
            }
        } catch (Exception $e) {

            if ($this->getControlValue('save')) {
                // сохранить отчет
                try {
                    $report = ReportService::Get()->addReport(
                    $this->getControlValue('name'),
                    $row,
                    $columnArray
                    );

                    header('location: '.Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-report-designer', $report->getId()));
                } catch (ServiceUtils_Exception $se) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorArray', $se->getErrorsArray());
                }
            }
        }

        // передаем выбранные колонки назад
        $this->setValue('columnSelectedArray', $columnArray);

        // даты
        $dateFrom = $this->getControlValue('datefrom');
        $dateTo = $this->getControlValue('dateto');

        if ($dateFrom) {
            $dateFrom = DateTime_Corrector::CorrectDateTime($dateFrom);
        }

        if ($dateTo) {
            $dateTo = DateTime_Corrector::CorrectDateTime($dateTo);
        }

        // если заданы тип строк и колонки - строим отчет
        if ($row && $columnArray) {
            try {
                if (!isset($rowAllArray[$row])) {
                    throw new ServiceUtils_Exception();
                }

                // передаем название выбранного типа строк
                $this->setValue('rowCurrentName', $rowAllArray[$row]);

                // передаем названия выбранных колонок
                $columnCurrentArray = array();
                foreach ($columnArray as $k => $columnKey) {
                    if (!isset($columnAllArray[$columnKey])) {
                        unset($columnArray[$k]);
                        continue;
                    }
                    $columnCurrentArray[$columnKey] = $columnAllArray[$columnKey];
                }
                $this->setValue('columnCurrentArray', $columnCurrentArray);

                if (!$columnArray) {
                    throw new ServiceUtils_Exception();
                }

                // получить все объекты, по которым строится отчет (строки)
                $objects = $this->_getReportObjects($row);

                // названия строк
                $rowResultArray = array();

                // формируем массив ID всех объектов, по которым строится отчет
                $xIDArray = array();
                while ($x = $objects->getNext()) {
                    $xIDArray[] = $x->getId();

                    $rowResultArray[$x->getId()] = str_replace('\'', '', $x->makeName());
                }

                if (!$xIDArray) {
                    throw new ServiceUtils_Exception();
                }

                $this->setValue('rowResultArray', $rowResultArray);

                // массив для данных по колонкам
                $columnResultArray = array();

                // смотрим колонки, которые выбрал юзер, и добавляем данные по ним в массив-результат
                foreach ($columnArray as $column) {
                    if (in_array($column, array('order-count', 'order-sum-total', 'order-sum-avg', 'issue-count'))) {
                        // если текущая колонка относится к заказам/задачам

                        $columnResultArray[$column] = $this->_makeOrderColumn($row, $column, $xIDArray, $dateFrom, $dateTo);

                    } elseif (in_array($column, array('event-count', 'event-email-count', 'event-call-count', 'event-meeting-count',
                    'event-email-in-count', 'event-call-in-count', 'event-email-out-count', 'event-call-out-count'))) {
                        // если текущая колонка относится к событиям

                        $columnResultArray[$column] = $this->_makeEventColumn($row, $column, $xIDArray, $dateFrom, $dateTo);

                    } elseif (in_array($column, array('payment-count', 'payment-sum-total', 'payment-sum-avg'))) {
                        // если текущая колонка относится к платежам

                        $columnResultArray[$column] = $this->_makePaymentColumn($row, $column, $xIDArray, $dateFrom, $dateTo);

                    } elseif (in_array($column, array('probation-count', 'probation-sum'))) {
                        // если текущая колонка относится к ожидаемым платежам

                        $columnResultArray[$column] = $this->_makeProbationColumn($row, $column, $xIDArray, $dateFrom, $dateTo);

                    } elseif (in_array($column, array('balance', 'balance-plus', 'balance-minus'))) {
                        // если текущая колонка относится к балансу

                        $columnResultArray[$column] = $this->_makeBalanceColumn($row, $column, $xIDArray, $dateFrom, $dateTo);
                    }

                }

                $this->setValue('columnResultArray', $columnResultArray);

                $columnTypeArray = array(
                'order-count' => 'count',
                'order-sum-total' => 'sum',
                'order-sum-avg' => 'sum',
                'issue-count' => 'count',
                'event-count' => 'count',
                'event-email-count' => 'count',
                'event-email-in-count' => 'count',
                'event-email-out-count' => 'count',
                'event-call-count' => 'count',
                'event-call-in-count' => 'count',
                'event-call-out-count' => 'count',
                'event-meeting-count' => 'count',
                'payment-count' => 'count',
                'payment-sum-total' => 'sum',
                'payment-sum-avg' => 'sum',
                'probation-count' => 'count',
                'probation-sum' => 'sum',
                'balance' => 'sum',
                'balance-plus' => 'sum',
                'balance-minus' => 'sum'
                );

                $this->setValue('columnTypeArray', $columnTypeArray);

            } catch (ServiceUtils_Exception $e) {

            }
        }
    }

    /**
     * Получить все объекты, по которым строится отчет (строки)
     *
     * @param string $row
     * @return SQLObject
     */
    private function _getReportObjects($row) {
        $cuser = $this->getUser();

        // объекты для join-ов
        $xorder = new ShopOrder();
        $xuser = new User();

        // находим объекты-строки
        if ($row == 'contact-all') {
            // контакты

            $x = Shop::Get()->getUserService()->getUsersAll($cuser);

        } elseif ($row == 'contact-client') {
            // контакты-клиенты

            $x = Shop::Get()->getUserService()->getUsersAll($cuser);
            $x->leftJoinTable($xorder->getTablename(), $x->getTablename().'.`id` = '.$xorder->getTablename().'.`userid`');
            $x->addWhereQuery($xorder->getTablename().'.`outcoming` = 0');

        } elseif ($row == 'contact-supplier') {
            // контакты- поставщики

            $x = Shop::Get()->getUserService()->getUsersAll($cuser);
            $x->leftJoinTable($xorder->getTablename(), $x->getTablename().'.`id` = '.$xorder->getTablename().'.`userid`');
            $x->addWhereQuery($xorder->getTablename().'.`outcoming` = 1');

        } elseif ($row == 'contact-employer') {
            // контакты-сотрудники

            $x = Shop::Get()->getUserService()->getUsersAll($cuser);
            $x->setEmployer(1);

        } elseif ($row == 'contact-mycompany') {
            // контакты-мои компании

            $x = Shop::Get()->getUserService()->getUsersAll($cuser);
            $x->setEmployer(1);
            $x->setTypesex('company');
            $x->addWhere('company', '', '<>');

        } elseif ($row == 'order-source') {
            // источники заказов

            $x = Shop::Get()->getShopService()->getSourceAll();
            $x->leftJoinTable($xorder->getTablename(), $x->getTablename().'.`id` = '.$xorder->getTablename().'.`sourceid`');
            $x->addWhereQuery($xorder->getTablename().'.`sourceid` IS NOT NULL');
            $x->setGroupByQuery('id');

        } elseif ($row == 'contact-source') {
            // источники контактов

            $x = Shop::Get()->getShopService()->getSourceAll();
            $x->leftJoinTable($xuser->getTablename(), $x->getTablename().'.`id` = '.$xuser->getTablename().'.`sourceid`');
            $x->addWhereQuery($xuser->getTablename().'.`sourceid` IS NOT NULL');
            $x->setGroupByQuery('id');

        } elseif ($row == 'order-workflow') {
            // бизнес-процессы

            $x = Shop::Get()->getShopService()->getWorkflowsAll();

        } elseif ($row == 'order-status') {
            // статусы

            $x = Shop::Get()->getShopService()->getStatusAll();

        }

        return $x;
    }

    /**
     * Получить данные по колонке, относящейся к заказам/задачам
     *
     * @param string $row
     * @param string $column
     * @param array $xIDArray
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    private function _makeOrderColumn($row, $column, $xIDArray, $dateFrom, $dateTo) {
        $cuser = $this->getUser();

        // определяем поле, по которому нужно сгруппировать заказы/задачи
        if ($row == 'contact-all') {
            $rowKey = 'userid';
        } elseif ($row == 'contact-client') {
            $rowKey = 'userid';
        } elseif ($row == 'contact-supplier') {
            $rowKey = 'userid';
        } elseif ($row == 'contact-employer') {
            $rowKey = 'managerid';
        } elseif ($row == 'contact-mycompany') {
            $rowKey = 'contractorid';
        } elseif ($row == 'order-source') {
            $rowKey = 'sourceid';
        } elseif ($row == 'contact-source') {
            $rowKey = $xuser->getTablename().'.sourceid';
        } elseif ($row == 'order-workflow') {
            $rowKey = 'categoryid';
        } elseif ($row == 'order-status') {
            $rowKey = 'statusid';
        } else {
            return ;
        }

        $xuser = new User();

        if (in_array($column, array('order-count', 'order-sum-total', 'order-sum-avg'))) {
            // смотрим заказы

            $orders = Shop::Get()->getShopService()->getOrdersAll($cuser);

            if ($dateFrom) {
                $orders->addWhere('cdate', $dateFrom, '>=');
            }

            if ($dateTo) {
                $orders->addWhere('cdate', $dateTo, '<=');
            }

            if ($column == 'order-count') {
                $orders->addFieldQuery('COUNT(*) AS column_value');
            } elseif ($column == 'order-sum-total') {
                $orders->addFieldQuery('SUM(`sumbase`) AS column_value');
            } elseif ($column == 'order-sum-avg') {
                $orders->addFieldQuery('AVG(`sumbase`) AS column_value');
            }

            if ($row == 'contact-source') {
                $orders->leftJoinTable($xuser->getTablename(), $orders->getTablename().'.`userid` = '.$xuser->getTablename().'.`id`');
            }

            $orders->addFieldQuery($rowKey.' AS row_key');
            $orders->addWhereQuery($rowKey.' IN ('.implode(',', $xIDArray).')');
            $orders->setGroupByQuery($rowKey);

            $a = array();
            while ($order = $orders->getNext()) {
                $a[$order->getField('row_key')] = $order->getField('column_value');
            }

            return $a;

        } elseif ($column == 'issue-count') {
            // смотрим задачи

            $issues = IssueService::Get()->getIssuesAll($cuser);

            if ($dateFrom) {
                $issues->addWhere('cdate', $dateFrom, '>=');
            }

            if ($dateTo) {
                $issues->addWhere('cdate', $dateTo, '<=');
            }

            if ($row == 'contact-source') {
                $issues->leftJoinTable($xuser->getTablename(), $issues->getTablename().'.`userid` = '.$xuser->getTablename().'.`id`');
            }

            $issues->addFieldQuery('COUNT(*) AS column_value');
            $issues->addFieldQuery($rowKey.' AS row_key');
            $issues->addWhereQuery($rowKey.' IN ('.implode(',', $xIDArray).')');
            $issues->setGroupByQuery($rowKey);

            $a = array();
            while ($issue = $issues->getNext()) {
                $a[$issue->getField('row_key')] = $issue->getField('column_value');
            }

            return $a;
        }
    }

    /**
     * Получить данные по колонке, относящейся к событиям
     *
     * @param string $row
     * @param string $column
     * @param array $xIDArray
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    private function _makeEventColumn($row, $column, $xIDArray, $dateFrom, $dateTo) {
        $xuser = new User();

        if (in_array($column, array('event-count', 'event-email-count', 'event-call-count', 'event-meeting-count'))) {
            // если текущая колонка относится к событиям любого направления

            $events1 = EventService::Get()->getEventsAll();

            if ($dateFrom) {
                $events1->addWhere('cdate', $dateFrom, '>=');
            }

            if ($dateTo) {
                $events1->addWhere('cdate', $dateTo, '<=');
            }

            $events1->addFieldQuery('COUNT(*) AS column_value');
            if ($column == 'event-email-count') {
                $events1->setType('email');
            } elseif ($column == 'event-call-count') {
                $events1->setType('call');
            } elseif ($column == 'event-meeting-count') {
                $events1->setType('meeting');
            }

            // определяем поле, по которому нужно сгруппировать события
            if (in_array($row, array('contact-all', 'contact-client', 'contact-supplier', 'contact-employer', 'contact-mycompany'))) {
                // по юзеру from или юзеру to

                $a = array();

                $events = clone $events1;
                $events->addWhereQuery('fromuserid IN ('.implode(',', $xIDArray).')');
                $events->addFieldQuery('fromuserid AS row_key');
                $events->setGroupByQuery('fromuserid');

                while ($event = $events->getNext()) {
                    if (isset($a[$event->getField('row_key')])) {
                        $a[$event->getField('row_key')] += $event->getField('column_value');
                    } else {
                        $a[$event->getField('row_key')] = $event->getField('column_value');
                    }
                }

                $events = clone $events1;
                $events->addWhereQuery('touserid IN ('.implode(',', $xIDArray).')');
                $events->addFieldQuery('touserid AS row_key');
                $events->setGroupByQuery('touserid');

                while ($event = $events->getNext()) {
                    if (isset($a[$event->getField('row_key')])) {
                        $a[$event->getField('row_key')] += $event->getField('column_value');
                    } else {
                        $a[$event->getField('row_key')] = $event->getField('column_value');
                    }
                }

                return $a;

            } elseif ($row == 'contact-source') {
                // по источнику юзера from или источнику юзера to

                $a = array();

                $events = clone $events1;
                $events->leftJoinTable($xuser->getTablename(), $events->getTablename().'.`fromuserid` = '.$xuser->getTablename().'.`id`');
                $events->addWhereQuery($xuser->getTablename().'.`sourceid` IN ('.implode(',', $xIDArray).')');
                $events->addFieldQuery($xuser->getTablename().'.`sourceid` AS row_key');
                $events->setGroupByQuery($xuser->getTablename().'.`sourceid`');

                while ($event = $events->getNext()) {
                    $a[$event->getField('row_key')] = $event->getField('column_value');
                }

                $events = clone $events1;
                $events->leftJoinTable($xuser->getTablename(), $events->getTablename().'.`touserid` = '.$xuser->getTablename().'.`id`');
                $events->addWhereQuery($xuser->getTablename().'.`sourceid` IN ('.implode(',', $xIDArray).')');
                $events->addFieldQuery($xuser->getTablename().'.`sourceid` AS row_key');
                $events->setGroupByQuery($xuser->getTablename().'.`sourceid`');

                while ($event = $events->getNext()) {
                    $a[$event->getField('row_key')] = $event->getField('column_value');
                }

                return $a;

            }

        } elseif (in_array($column, array('event-email-in-count', 'event-call-in-count'))) {
            // если текущая колонка относится к входящим событиям

            $events1 = EventService::Get()->getEventsAll();

            if ($dateFrom) {
                $events1->addWhere('cdate', $dateFrom, '>=');
            }

            if ($dateTo) {
                $events1->addWhere('cdate', $dateTo, '<=');
            }

            $events1->addFieldQuery('COUNT(*) AS column_value');
            if ($column == 'event-email-in-count') {
                $events1->setType('email');
            } elseif ($column == 'event-call-in-count') {
                $events1->setType('call');
            }

            // определяем поле, по которому нужно сгруппировать события
            if (in_array($row, array('contact-all', 'contact-client', 'contact-supplier', 'contact-employer', 'contact-mycompany'))) {
                // по юзеру from

                $a = array();

                $events = clone $events1;
                $events->addWhereQuery('fromuserid IN ('.implode(',', $xIDArray).')');
                $events->addFieldQuery('fromuserid AS row_key');
                $events->setGroupByQuery('fromuserid');

                while ($event = $events->getNext()) {
                    $a[$event->getField('row_key')] = $event->getField('column_value');
                }

                return $a;

            } elseif ($row == 'contact-source') {
                // по источнику юзера from

                $a = array();

                $events = clone $events1;
                $events->leftJoinTable($xuser->getTablename(), $events->getTablename().'.`fromuserid` = '.$xuser->getTablename().'.`id`');
                $events->addWhereQuery($xuser->getTablename().'.`sourceid` IN ('.implode(',', $xIDArray).')');
                $events->addFieldQuery($xuser->getTablename().'.`sourceid` AS row_key');
                $events->setGroupByQuery($xuser->getTablename().'.`sourceid`');

                while ($event = $events->getNext()) {
                    $a[$event->getField('row_key')] = $event->getField('column_value');
                }

                return $a;

            }
        } elseif (in_array($column, array('event-email-out-count', 'event-call-out-count'))) {
            // если текущая колонка относится к исходящим событиям

            $events1 = EventService::Get()->getEventsAll();

            if ($dateFrom) {
                $events1->addWhere('cdate', $dateFrom, '>=');
            }

            if ($dateTo) {
                $events1->addWhere('cdate', $dateTo, '<=');
            }

            $events1->addFieldQuery('COUNT(*) AS column_value');
            if ($column == 'event-email-out-count') {
                $events1->setType('email');
            } elseif ($column == 'event-call-out-count') {
                $events1->setType('call');
            }

            // определяем поле, по которому нужно сгруппировать события
            if (in_array($row, array('contact-all', 'contact-client', 'contact-supplier', 'contact-employer', 'contact-mycompany'))) {
                // по юзеру to

                $a = array();

                $events = clone $events1;
                $events->addWhereQuery('touserid IN ('.implode(',', $xIDArray).')');
                $events->addFieldQuery('touserid AS row_key');
                $events->setGroupByQuery('touserid');

                while ($event = $events->getNext()) {
                    $a[$event->getField('row_key')] = $event->getField('column_value');
                }

                return $a;

            } elseif ($row == 'contact-source') {
                // по источнику юзера to

                $a = array();

                $events = clone $events1;
                $events->leftJoinTable($xuser->getTablename(), $events->getTablename().'.`touserid` = '.$xuser->getTablename().'.`id`');
                $events->addWhereQuery($xuser->getTablename().'.`sourceid` IN ('.implode(',', $xIDArray).')');
                $events->addFieldQuery($xuser->getTablename().'.`sourceid` AS row_key');
                $events->setGroupByQuery($xuser->getTablename().'.`sourceid`');

                while ($event = $events->getNext()) {
                    $a[$event->getField('row_key')] = $event->getField('column_value');
                }

                return $a;

            }

        }
    }

    /**
     * Получить данные по колонке, относящейся к платежам
     *
     * @param string $row
     * @param string $column
     * @param array $xIDArray
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    private function _makePaymentColumn($row, $column, $xIDArray, $dateFrom, $dateTo) {
        $xuser = new User();
        $xorder = new ShopOrder();

        $payments = PaymentService::Get()->getPaymentsAll();

        if ($dateFrom) {
            $payments->addWhere('cdate', $dateFrom, '>=');
        }

        if ($dateTo) {
            $payments->addWhere('cdate', $dateTo, '<=');
        }

        if ($column == 'payment-count') {
            $payments->addFieldQuery('COUNT(*) AS column_value');
        } elseif ($column == 'payment-sum-total') {
            $payments->addFieldQuery('SUM(`amountbase`) AS column_value');
        } elseif ($column == 'payment-sum-avg') {
            $payments->addFieldQuery('AVG(`amountbase`) AS column_value');
        }

        // определяем поле, по которому нужно сгруппировать платежи
        if (in_array($row, array('contact-all', 'contact-client', 'contact-supplier', 'contact-employer', 'contact-mycompany'))) {
            // по юзеру

            $payments->addWhereQuery('clientid IN ('.implode(',', $xIDArray).')');
            $payments->addFieldQuery('clientid AS row_key');
            $payments->setGroupByQuery('clientid');

            $a = array();
            while ($payment = $payments->getNext()) {
                $a[$payment->getField('row_key')] = $payment->getField('column_value');
            }

            return $a;

        } elseif ($row == 'contact-source') {
            // по источнику юзера

            $payments->leftJoinTable($xuser->getTablename(), $payments->getTablename().'.`clientid` = '.$xuser->getTablename().'.`id`');
            $payments->addWhereQuery($xuser->getTablename().'.`sourceid` IN ('.implode(',', $xIDArray).')');
            $payments->addFieldQuery($xuser->getTablename().'.`sourceid` AS row_key');
            $payments->setGroupByQuery($xuser->getTablename().'.`sourceid`');

            $a = array();
            while ($payment = $payments->getNext()) {
                $a[$payment->getField('row_key')] = $payment->getField('column_value');
            }

            return $a;

        } elseif (in_array($row, array('order-source', 'order-workflow', 'order-status'))) {
            // по источнику/бизнес-процессу/статусу заказа

            if ($row == 'order-source') {
                $rowKey = 'sourceid';
            } elseif ($row == 'order-workflow') {
                $rowKey = 'categoryid';
            } elseif ($row == 'order-status') {
                $rowKey = 'statusid';
            }

            $payments->leftJoinTable($xorder->getTablename(), $payments->getTablename().'.`orderid` = '.$xorder->getTablename().'.`id`');
            $payments->addWhereQuery($xorder->getTablename().'.`'.$rowKey.'` IN ('.implode(',', $xIDArray).')');
            $payments->addFieldQuery($xorder->getTablename().'.`'.$rowKey.'` AS row_key');
            $payments->setGroupByQuery($xorder->getTablename().'.`'.$rowKey.'`');

            $a = array();
            while ($payment = $payments->getNext()) {
                $a[$payment->getField('row_key')] = $payment->getField('column_value');
            }

            return $a;
        }

    }

    /**
     * Получить данные по колонке, относящейся к ожидаемым платежам
     *
     * @param string $row
     * @param string $column
     * @param array $xIDArray
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    private function _makeProbationColumn($row, $column, $xIDArray, $dateFrom, $dateTo) {
        $xorder = new ShopOrder();
        $xuser = new User();

        $probations = FinanceService::Get()->getProbationsAll();

        if ($dateFrom) {
            $probations->addWhere('cdate', $dateFrom, '>=');
        }

        if ($dateTo) {
            $probations->addWhere('cdate', $dateTo, '<=');
        }

        if ($column == 'probation-count') {
            $probations->addFieldQuery('COUNT(*) AS column_value');
        } elseif ($column == 'probation-sum') {
            $probations->addFieldQuery('SUM(`amountbase`) AS column_value');
        }

        // определяем поле, по которому нужно сгруппировать платежи
        if (in_array($row, array('contact-all', 'contact-client', 'contact-supplier', 'contact-employer', 'contact-mycompany'))) {
            // по юзеру

            $probations->leftJoinTable($xorder->getTablename(), $probations->getTablename().'.`orderid` = '.$xorder->getTablename().'.`id`');
            $probations->addWhereQuery($xorder->getTablename().'.`userid` IN ('.implode(',', $xIDArray).')');
            $probations->addFieldQuery($xorder->getTablename().'.`userid` AS row_key');
            $probations->setGroupByQuery($xorder->getTablename().'.`userid`');

            $a = array();
            while ($probation = $probations->getNext()) {
                $a[$probation->getField('row_key')] = $probation->getField('column_value');
            }

            return $a;

        } elseif ($row == 'order-source') {
            // по источнику заказа

            $probations->leftJoinTable($xorder->getTablename(), $probations->getTablename().'.`orderid` = '.$xorder->getTablename().'.`id`');
            $probations->addWhereQuery($xorder->getTablename().'.`sourceid` IN ('.implode(',', $xIDArray).')');
            $probations->addFieldQuery($xorder->getTablename().'.`sourceid` AS row_key');
            $probations->setGroupByQuery($xorder->getTablename().'.`sourceid`');

            $a = array();
            while ($probation = $probations->getNext()) {
                $a[$probation->getField('row_key')] = $probation->getField('column_value');
            }

            return $a;

        } elseif ($row == 'contact-source') {
            // по источнику контакта

            $probations->leftJoinTable($xorder->getTablename(), $probations->getTablename().'.`orderid` = '.$xorder->getTablename().'.`id`');
            $probations->leftJoinTable($xuser->getTablename(), $xorder->getTablename().'.`userid` = '.$xuser->getTablename().'.`id`');
            $probations->addWhereQuery($xuser->getTablename().'.`sourceid` IN ('.implode(',', $xIDArray).')');
            $probations->addFieldQuery($xuser->getTablename().'.`sourceid` AS row_key');
            $probations->setGroupByQuery($xuser->getTablename().'.`sourceid`');

            $a = array();
            while ($probation = $probations->getNext()) {
                $a[$probation->getField('row_key')] = $probation->getField('column_value');
            }

            return $a;

        } elseif ($row == 'order-workflow') {
            // по бизнес-процессу

            $probations->leftJoinTable($xorder->getTablename(), $probations->getTablename().'.`orderid` = '.$xorder->getTablename().'.`id`');
            $probations->addWhereQuery($xorder->getTablename().'.`categoryid` IN ('.implode(',', $xIDArray).')');
            $probations->addFieldQuery($xorder->getTablename().'.`categoryid` AS row_key');
            $probations->setGroupByQuery($xorder->getTablename().'.`categoryid`');

            $a = array();
            while ($probation = $probations->getNext()) {
                $a[$probation->getField('row_key')] = $probation->getField('column_value');
            }

            return $a;

        } elseif ($row == 'order-status') {
            // по статусу

            $probations->leftJoinTable($xorder->getTablename(), $probations->getTablename().'.`orderid` = '.$xorder->getTablename().'.`id`');
            $probations->addWhereQuery($xorder->getTablename().'.`statusid` IN ('.implode(',', $xIDArray).')');
            $probations->addFieldQuery($xorder->getTablename().'.`statusid` AS row_key');
            $probations->setGroupByQuery($xorder->getTablename().'.`statusid`');

            $a = array();
            while ($probation = $probations->getNext()) {
                $a[$probation->getField('row_key')] = $probation->getField('column_value');
            }

            return $a;
        }
    }

    /**
     * Получить данные по колонке, относящейся к балансу
     *
     * @param string $row
     * @param string $column
     * @param array $xIDArray
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    private function _makeBalanceColumn($row, $column, $xIDArray, $dateFrom, $dateTo) {
        $cuser = $this->getUser();

        // определяем поле, по которому нужно считать баланс
        if (in_array($row, array('contact-all', 'contact-client', 'contact-supplier', 'contact-employer', 'contact-mycompany'))) {
            // по юзеру

            if ($column == 'balance') {
                $users = Shop::Get()->getUserService()->getUsersAll();
                $users->addWhereArray($xIDArray, 'id');

                $a = array();
                while ($user = $users->getNext()) {
                    $a[$user->getId()] = $user->makeSumBalance();
                }

                return $a;

            } elseif (in_array($column, array('balance-plus', 'balance-minus'))) {
                $orders = Shop::Get()->getShopService()->getOrdersAll($cuser);
                $orders->addWhereArray($xIDArray, 'userid');

                $a = array();
                while ($order = $orders->getNext()) {
                    $balance = $order->makeSumBalance();

                    if (isset($a[$order->getUserid()])) {
                        $a[$order->getUserid()] += $balance;
                    } else {
                        $a[$order->getUserid()] = $balance;
                    }
                }

                foreach ($a as $k => $v) {
                    if (($column == 'balance-plus' && $v <= 0) || ($column == 'balance-minus' && $v >= 0)) {
                        unset($a[$k]);
                    }
                }

                return $a;

            }

        } elseif (in_array($row, array('order-source', 'order-workflow', 'order-status'))) {
            // по источнику/бизнес-процессу/статусу заказа

            if ($row == 'order-source') {
                $rowKey = 'sourceid';
            } elseif ($row == 'order-workflow') {
                $rowKey = 'categoryid';
            } elseif ($row == 'order-status') {
                $rowKey = 'statusid';
            }

            $orders = Shop::Get()->getShopService()->getOrdersAll($cuser);
            $orders->addWhereArray($xIDArray, $rowKey);

            $a = array();
            while ($order = $orders->getNext()) {
                $balance = $order->makeSumBalance();

                if (isset($a[$order->getField($rowKey)])) {
                    $a[$order->getField($rowKey)] += $balance;
                } else {
                    $a[$order->getField($rowKey)] = $balance;
                }
            }

            foreach ($a as $k => $v) {
                if (($column == 'balance-plus' && $v <= 0) || ($column == 'balance-minus' && $v >= 0)) {
                    unset($a[$k]);
                }
            }

            return $a;

        } elseif ($row == 'contact-source') {
            // по источнику контакта

            $users = Shop::Get()->getUserService()->getUsersAll();
            $users->addWhereArray($xIDArray, 'sourceid');

            $a = array();
            while ($user = $users->getNext()) {
                $balance = $user->makeSumBalance();

                if (isset($a[$user->getSourceid()])) {
                    $a[$user->getSourceid()] += $balance;
                } else {
                    $a[$user->getSourceid()] = $balance;
                }
            }

            foreach ($a as $k => $v) {
                if (($column == 'balance-plus' && $v <= 0) || ($column == 'balance-minus' && $v >= 0)) {
                    unset($a[$k]);
                }
            }

            return $a;

        }
    }
}