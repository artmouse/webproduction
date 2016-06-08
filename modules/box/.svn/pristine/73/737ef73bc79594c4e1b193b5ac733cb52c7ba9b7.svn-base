<?php
class issue_list extends Engine_Class {

    /**
     * Получить задачи
     *
     * @return ShopOrder
     */
    private function _getIssues() {
        return $this->getValue('issues');
    }

    /**
     * Datasource
     *
     * @return Datasource_Issue
     */
    private function _getDatasource() {
        if ($this->_datasource === null) {
            $this->_datasource = $this->getValue('datasource');
            if (!$this->_datasource) {
                $this->_datasource = Forms_DataSourceManager::Get()->getDataSource(
                    'Datasource_IssueCustom'
                );
                $this->_datasource->setType($this->getValue('type'));
                //$this->_datasource = new Datasource_IssueCustom($this->getValue('type'));
            }
        }
        return $this->_datasource;
    }

    public function process() {
        // массовое удаление
        if ($this->getControlValue('delete')) {
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                $activeUser = Shop::Get()->getUserService()->getUser();
                foreach ($r[1] as $issueID) {
                    try {
                        $issue = Shop::Get()->getShopService()->getOrderByID($issueID);

                        try {
                            CommentsAPI::Get()->addComment(
                                'shop-history-issue-del'.$activeUser->getId(),
                                Shop::Get()->getTranslateService()->getTranslateSecure(
                                    'translate_udalena_zadacha_'
                                ).$issue->getId().' '.$issue->makeName(),
                                $activeUser->getId()
                            );
                        } catch (Exception $e) {

                        }

                        Shop::Get()->getShopService()->deleteOrder($issue, $this->getUser());
                    } catch (Exception $pe) {

                    }
                }
            }
        }

        // массовое изменение
        if ($this->getControlValue('change')) {
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                $category = null;
                $manager = null;
                $status = null;
                $dueDate = null;
                $action = null;

                if ( $this->getControlValue('manager') ) {
                    try {
                        $manager = Shop::Get()->getUserService()->getUserByID(
                            $this->getControlValue('manager')
                        );
                    } catch ( Exception $e ) {

                    }
                }

                if ( $this->getArgumentSecure('status') ) {
                    $status = $this->getArgumentSecure('status');
                }

                if ( $this->getArgumentSecure('dueDate') ) {
                    $dueDate = $this->getArgumentSecure('dueDate');
                }
                if ( $this->getArgumentSecure('action') ) {
                    $action = $this->getArgumentSecure('action');
                }

                foreach ($r[1] as $issueID) {
                    try {
                        SQLObject::TransactionStart();
                        $issue = Shop::Get()->getShopService()->getOrderByID($issueID);

                        // обновляем менеджера заказа
                        if ( $manager != null ) {
                            Shop::Get()->getShopService()->updateOrderManager($issue, $this->getUser(), $manager);
                        }

                        // обновляем статус
                        if ( $status != null ) {
                            Shop::Get()->getShopService()->updateOrderStatusAndCategory(
                                $this->getUser(),
                                $issue,
                                $status
                            );
                        }

                        if ($dueDate) {
                            if ($dueDate < $issue->getCdate()) {
                                throw new Exception("errordate");
                            }
                            $issue->setDateto($dueDate);
                            $issue->update();
                        }

                        try{
                            if ($action == 'closed') {

                                Shop::Get()->getShopService()->updateOrderStatus(
                                    $this->getUser(),
                                    $issue,
                                    $issue->getCategory()->getStatusClosed()->getId()
                                );

                            } elseif ($action == 'open') {

                                Shop::Get()->getShopService()->updateOrderStatus(
                                    $this->getUser(),
                                    $issue,
                                    $issue->getCategory()->getStatusDefault()->getId()
                                );

                            }

                        } catch (Exception $e) {

                        }


                        SQLObject::TransactionCommit();

                    } catch (Exception $pe) {
                        if ($pe->getMessage() == 'errordate') {
                            $this->setValue('message', 'errordate');
                        }
                        SQLObject::TransactionRollback();
                    }
                }
            }
        }

        if ($this->getControlValue('add_comments')) {
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                foreach ($r[1] as $issueID) {
                    try {
                        $issue = Shop::Get()->getShopService()->getOrderByID($issueID);
                        $comments = trim($this->getControlValue('postcomments'));
                        Shop::Get()->getShopService()->addOrderComment($issue, $this->getUser(), $comments);
                    } catch (Exception $e) {

                    }
                }
            }
        }
        $customOrderNumber = Engine::Get()->getConfigFieldSecure('project-box-custom-order-number');
        $this->setValue('customOrderNumber', $customOrderNumber);

        $this->setValue('isBox', Engine::Get()->getConfigFieldSecure('project-box'));

        $datasource = $this->_getDatasource(); // ссылка на $this->_datasource

        $issues = $this->_getIssues();
        if ($issues) {
            $datasource->setSQLObject($issues);
        }

        $clientIDArray = $this->getArgumentSecure('filterclientid', 'array');

        foreach ($clientIDArray as $clId) {
            try{
                $user = Shop::Get()->getUserService()->getUserByID($clId);
                if ($user->getTypesex() == 'company') {
                    $allUsers = Shop::Get()->getUserService()->getUsersAll();
                    $allUsers->setCompany($user->getCompany());
                    $allUsers->addWhereQuery('(`id` IN (SELECT `userid` FROM `shoporder`))');
                    while ($x = $allUsers->getNext()) {
                        $clientIDArray[] = $x->getId();
                    }
                }
            } catch (Exception $e) {

            }
        }
        $clientIDArray = array_unique($clientIDArray);

        $datasource->getSQLObject()->addWhereArray($clientIDArray, 'userid');

        if (!$this->getArgumentSecure('filtershowclosed')) {
            $datasource->getSQLObject()->setDateclosed('0000-00-00 00:00:00');
        }

        if ($this->getArgumentSecure('filtershownotissue')) {
            $datasource->getSQLObject()->addWhereQuery(
                "id NOT IN (SELECT parentid FROM shoporder WHERE (dateclosed = '0000-00-00 00:00:00' AND parentid > 0))"
            );
        }

        $filterManagerID = $this->getArgumentSecure('filtermanagerid');
        if ($filterManagerID) {
            $datasource->getSQLObject()->setManagerid($filterManagerID);
        }

        $filterAuthorID = $this->getArgumentSecure('filterauthorid');
        if ($filterAuthorID) {
            $datasource->getSQLObject()->setAuthorid($filterAuthorID);
        }

        $filterNumber = $this->getArgumentSecure('filternumber');
        if ($filterNumber) {
            $datasource->getSQLObject()->addWhere('number', '%'.$filterNumber.'%', 'LIKE');
        }

        $filterName = $this->getArgumentSecure('filtername');
        if ($filterName) {
            $datasource->getSQLObject()->addWhere('name', '%'.str_replace(' ', '%', $filterName).'%', 'LIKE');
        }

        $filterID = $this->getArgumentSecure('filterid');
        if ($filterID) {
            $datasource->getSQLObject()->addWhere('id', '%'.$filterID.'%', 'LIKE');
        }

        $filterAddress = $this->getArgumentSecure('filteraddress');
        if ($filterAddress) {
            $datasource->getSQLObject()->addWhere('clientaddress', '%'.$filterAddress.'%', 'LIKE');
        }

        $filterComments = $this->getArgumentSecure('filtercomments');
        if ($filterComments) {
            $datasource->getSQLObject()->addWhere('comments', '%'.$filterComments.'%', 'LIKE');
        }

        $filterCdateFrom = $this->getArgumentSecure('filtercdatefrom', 'date');
        if ($filterCdateFrom) {
            $datasource->getSQLObject()->addWhere('cdate', $filterCdateFrom, '>=');
        }

        $filterCdateTo = $this->getArgumentSecure('filtercdateto', 'date');
        if ($filterCdateTo) {
            $datasource->getSQLObject()->addWhere('cdate', $filterCdateTo.' 23:59:59', '<=');
        }

        $filterDateToFrom = $this->getArgumentSecure('filterdatetofrom', 'date');
        if ($filterDateToFrom) {
            $datasource->getSQLObject()->addWhere('dateto', $filterDateToFrom, '>=');
        }

        $filterDateToTo = $this->getArgumentSecure('filterdatetoto', 'date');
        if ($filterDateToTo) {
            $datasource->getSQLObject()->addWhere('dateto', $filterDateToTo.' 23:59:59', '<=');
        }

        // поиск по серийному номеру
        $filterProductSerial = $this->getControlValue('filterproductserial');
        if ($filterProductSerial) {
            $filterProductSerial = ConnectionManager::Get()->getConnectionDatabase()->escapeString(
                $filterProductSerial
            );
            $query = "id IN (SELECT orderid FROM shoporderproduct WHERE serial LIKE '%".$filterProductSerial."%')";
            $datasource->getSQLObject()->addWhereQuery($query);
        }

        // поиск по названию товара
        $filterProductName = $this->getControlValue('filterproductname');
        if ($filterProductName) {
            $filterProductName = ConnectionManager::Get()->getConnectionDatabase()->escapeString($filterProductName);
            $query = "id IN (SELECT orderid FROM shoporderproduct
            WHERE productname LIKE '%".str_replace(' ', '%', $filterProductName)."%')";
            $datasource->getSQLObject()->addWhereQuery($query);
        }

        // поиск по номеру товара
        $filterProductID = $this->getControlValue('filterproductid');
        if ($filterProductID) {
            $filterProductID = ConnectionManager::Get()->getConnectionDatabase()->escapeString($filterProductID);
            $query = "id IN (SELECT orderid FROM shoporderproduct WHERE productid LIKE '%".$filterProductID."%')";
            $datasource->getSQLObject()->addWhereQuery($query);
        }

        // поиск по исполнителю
        $filterEmployer = $this->getControlValue('filteremployer');
        if ($filterEmployer) {
            $filterEmployer = ConnectionManager::Get()->getConnectionDatabase()->escapeString($filterEmployer);
            $query = "id IN (SELECT orderid FROM shoporderemployer WHERE managerid = '".$filterEmployer."')";
            $datasource->getSQLObject()->addWhereQuery($query);
        }

        // поиск по роли
        $filterRole = $this->getControlValue('filterrole');
        if ($filterRole) {
            $filterRole = ConnectionManager::Get()->getConnectionDatabase()->escapeString($filterRole);
            $query = "id IN (SELECT orderid FROM shoporderemployer WHERE role LIKE '%".$filterRole."%')";
            $datasource->getSQLObject()->addWhereQuery($query);
        }

        // получаем данные для фильтров
        // данные надо получить до фильтрации
        $issueFilter = clone $datasource->getSQLObject();

        $filterWorkflowIDArray = $this->getArgumentSecure('workflowid', 'array');
        if ($filterWorkflowIDArray) {
            $datasource->getSQLObject()->addWhereArray($filterWorkflowIDArray, 'categoryid');
        }

        $filterStatusIDArray = $this->getArgumentSecure('statusid', 'array');
        if ($filterStatusIDArray) {
            $datasource->getSQLObject()->addWhereArray($filterStatusIDArray, 'statusid');
        }
        
        //поиск по юрлицу
        $contractorsid = $this->getArgumentSecure('contractorsid');
        if ($contractorsid) {
            $datasource->getSQLObject()->setContractorid($contractorsid);
        }
        
        if ($this->getArgumentSecure('filtershowdeleted')) {
            $datasource->getSQLObject()->setDeleted($this->getArgumentSecure('filtershowdeleted'));
        }

        $table = new Shop_ContentTable($datasource);

        // заменяем для разукраски строк
        $table->setRow(new Shop_ContentTableRowOrders());

        $this->setValue('table', $table->render());
        $this->setValue('dataCount', $datasource->getSQLObject()->getCount());

        // получаем id всех отсортированных пользователей
        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $q = $connection->query('SET group_concat_max_len = 9999999;');
        $sql = "SELECT GROUP_CONCAT(`id` SEPARATOR ';') as `id` FROM `users`
            WHERE `users`.`id` IN (SELECT `userid` FROM `shoporder`
            WHERE (" . $datasource->getSQLObject()->makeWhereString()."))";
        $q = $connection->query($sql);
        $r = $connection->fetch($q);
        if ($r) {
            $this->setValue('arrUserId', $r['id']);
        }

        $login = Shop::Get()->getSettingsService()->getSettingValue('sms-login');
        $pass = Shop::Get()->getSettingsService()->getSettingValue('sms-password');
        $sender = Shop::Get()->getSettingsService()->getSettingValue('sms-sender');
        if ($sender && $login && $pass) {
            $this->setValue('canSMS', true);
        }

        $mode = $this->getArgumentSecure('mode');
        if ($mode) {
            $this->_showIssueMode($mode);
        }

        // Выбранные из клиентов
        $clientArray = array();
        foreach ($clientIDArray as $clientID) {
            try {
                $client = Shop::Get()->getUserService()->getUserByID($clientID);

                $clientArray[] = array(
                'id' => $clientID,
                'text' =>  $client->getTypesex() ==
                    'company' ? Shop::Get()->getTranslateService()->getTranslateSecure(
                        'translate_kompaniya_'
                    ).$client->getCompany():$client->makeName()
                );
            } catch (ServiceUtils_Exception $pe) {

            }
        }
        $this->setValue('filterClientArray', $clientArray);

        // категории
        $categories = Shop::Get()->getShopService()->getWorkflowsActive(
            $this->getUser()
        );
        $categoryArray = array();
        while ($x = $categories->getNext()) {
            $categoryArray[] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'hidden' => $x->getHidden(),
            );
        }
        $this->setValue('categoryArray', $categoryArray);

        // статусы
        $statusesArray = array();
        $statuses = Shop::Get()->getShopService()->getStatusAll();
        $statuses->setCategoryid(0);
        while ($x = $statuses->getNext()) {
            if ($this->getUser()->isDenied('orders-category-'.$x->getCategoryid().'-view')) {
                continue;
            }

            $statusesArray[] = array(
            'id' => $x->getId(),
            'name' => $x->getName()
            );
        }

        $statusesCategoryArray = array();

        $statuses = Shop::Get()->getShopService()->getStatusAll();
        $statuses->addWhereQuery("categoryid IN (SELECT id FROM shopordercategory WHERE (hidden='0'))");
        while ($x = $statuses->getNext()) {
            try{
                if ($this->getUser()->isDenied('orders-category-'.$x->getCategoryid().'-view')) {
                    continue;
                }
                $statusesCategoryArray[$x->getCategory()->getName()][] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
                );
            } catch (Exception $e) {

            }

        }

        $this->setValue('statusArray', $statusesArray);
        $this->setValue('statusCategoryArray', $statusesCategoryArray);

        // менеджеры
        $managers = Shop::Get()->getUserService()->getUsersManagers($this->getUser());
        $a = array();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, 'lfm'),
            );
        }
        $this->setValue('managerArray', $a);
        
        // юридические лица
        $contractors = Shop::Get()->getShopService()->getContractorsAll();
        $c = array();
        while ($x = $contractors->getNext()) {
            $c[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );
        }
        $this->setValue('contractorsArray', $c);
        
        // статусы заказов
        $block = Engine::GetContentDriver()->getContent('workflow-filter-block');
        $block->setValue('issueFilter', $issueFilter);
        $this->setValue('block_workflow_filter', $block->render());

        // дополнительные способы отображения от модулей
        $this->setValue('moduleViewModeArray', Shop_ModuleLoader::Get()->getOrderViewModeArray());
    }

    /**
     * Отображение задач в виде заданном @param $mode
     */
    private function _showIssueMode($mode) {
        // дополнительные способы отображения от модулей
        $moduleModeArray = Shop_ModuleLoader::Get()->getOrderViewModeArray();
        foreach ($moduleModeArray as $moduleMode) {
            if ($mode == $moduleMode['modeName']) {
                $this->_setShowIssueBlock($moduleMode['contentID']);
                break;
            }
        }

    }

    /**
     * Показать блок
     *
     * @param $contentid
     * @param $blockid
     */
    private function _setShowIssueBlock($contentid, $blockid = 'block_show_custom') {
        $datasource = $this->_getDatasource();
        $issues = clone $datasource->getSQLObject();
        $block = Engine::GetContentDriver()->getContent($contentid);
        $block->setValue('issue', $issues);
        $this->setValue($blockid, $block->render());
    }

    /**
     * Текущий источник данных
     *
     * @var Datasource_IssueCustom
     */
    private $_datasource = null;

}