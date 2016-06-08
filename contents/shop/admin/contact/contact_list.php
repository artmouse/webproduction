<?php
class contact_list extends Engine_Class {

    /**
     * Получить пользователей
     *
     * @return Users
     */
    private function _getUsers() {
        return $this->getValue('users');
    }

    /**
     * Datasource
     *
     * @return Datasource_Users
     */
    private function _getDatasource() {
        if ($this->_datasource === null) {
            $this->_datasource = $this->getValue('datasource');
            if (!$this->_datasource) {
                $this->_datasource = new Datasource_Users();
            }
        }
        return $this->_datasource;
    }
    
    public function process() {
        // включить box-пункты или нет
        $this->setValue('box', Engine::Get()->getConfigFieldSecure('project-box'));

        $canUserAdd = $this->getUser()->isAllowed('users-add');
        $this->setValue('canUserAdd', $canUserAdd);

        $groupID = $this->getArgumentSecure('groupid');
        try {
            $group = Shop::Get()->getUserService()->getUserGroupByID($groupID);
            $this->setValue('groupName', $group->getName());
            $this->setValue('groupDescription', $group->getDescription());
        } catch (Exception $e) {

        }

        $isOrder = Shop_ModuleLoader::Get()->isImported('order');
        $this->setValue('isOrderImported', $isOrder);

        if ($this->getControlValue('change')) {
            try {
                SQLObject::TransactionStart();

                $subscribeStatus = $this->getControlValue('changesubscibe');
                $level = $this->getControlValue('level');
                $managerID = $this->getControlValue('manager');

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $userID) {
                        $user = Shop::Get()->getUserService()->getUserByID($userID);
                        if ($subscribeStatus != '-1') {
                            $user->setDistribution($subscribeStatus);
                        }
                        if ($level != '-1') {
                            $user->setLevel($level);
                        }
                        if ($managerID != '-1') {
                            $user->setManagerid($managerID);
                        }
                        $user->update();
                    }
                }

                SQLObject::TransactionCommit();
            } catch (Exceprion $e) {
                SQLObject::TransactionRollback();
            }

            // добавление пользователей в группу
            $groupID = $this->getControlValue('addgroup');
            if ($groupID) {
                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $userID) {
                        try {
                            $user = Shop::Get()->getUserService()->getUserByID($userID);

                            Shop::Get()->getUserService()->addUserToGroup(
                                $user,
                                Shop::Get()->getUserService()->getUserGroupByID($groupID)
                            );
                        } catch (Exception $pe) {

                        }
                    }
                }
            }

            // убрать пользователей из группы
            $groupID = $this->getControlValue('removegroup');
            if ($groupID) {
                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $userID) {
                        try {
                            $user = Shop::Get()->getUserService()->getUserByID($userID);

                            Shop::Get()->getUserService()->removeUserFromGroup(
                                $user,
                                Shop::Get()->getUserService()->getUserGroupByID($groupID)
                            );
                        } catch (Exception $pe) {

                        }
                    }
                }
            }

            // Добавить контакты в задачу
            if ($isOrder && $this->getArgumentSecure('orderId')) {
                try {
                    $issueId = $this->getArgumentSecure('orderId');
                    if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                        foreach ($r[1] as $userID) {
                            $contacts = new XShopOrderContacts();
                            $contacts->setOrderid($issueId);
                            $contacts->setUserid($userID);
                            if (!$contacts->select()) {
                                $contacts->insert();
                            }
                        }
                    }

                } catch (Exception $e) {

                }

            }

            // обьединить
            if ($this->getControlValue('join')) {

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    try {
                        Shop::Get()->getUserService()->mergeUsers($r[1]);
                    } catch (Exception $pe) {

                    }
                }
            }

        }
        
        //Массовая рассылка по выбранным контактам
        if ($this->getArgumentSecure('sendSelected')) {
            $str = '';
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                foreach ($r[1] as $id) {
                    if ($id == end($r[1])) {
                            $str .= 'user[]=' . $id;
                    } else {
                            $str .= 'user[]=' . $id . '&';
                    }                 
                }
            }
            header("Location: /admin/shop/users/mailing/?" . $str);
        }   
        
        // Добавить контакты в задачу - массово
        if ($isOrder && $this->getArgumentSecure('addTooOrderMass')) {
            try {
                $issueId = $this->getArgumentSecure('massAddOrderId');
                if (preg_match_all("/(\d+)/ius", $this->getControlValue('arrUserId'), $r)) {
                    foreach ($r[1] as $userID) {
                        $contacts = new XShopOrderContacts();
                        $contacts->setOrderid($issueId);
                        $contacts->setUserid($userID);
                        if (!$contacts->select()) {
                            $contacts->insert();
                        }
                    }
                }

            } catch (Exception $e) {

            }

        }

        // массовая рассылка
        if ($this->getControlValue('send')) {
            $arrUserId = array();
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                foreach ($r[1] as $userID) {
                    try {
                        $arrUserId[] = $userID;
                    } catch (Exception $pe) {

                    }
                }
            }
            $str = '';
            foreach ($arrUserId as $id) {
                if ($id == end($arrUserId)) {
                    $str .= 'user[]='.$id;
                } else {
                    $str .= 'user[]='.$id.'&';
                }
            }

            header("Location: /admin/shop/users/mailing/?".$str);
        }

        // массовое удаление
        if ($this->getControlValue('delete')) {

            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                $activeUserId = Shop::Get()->getUserService()->getUser()->getId();
                foreach ($r[1] as $userID) {
                    try {
                        // если это не текущий пользователь
                        if ($activeUserId != $userID) {
                            $user = Shop::Get()->getUserService()->getUserByID($userID);
                            $user->delete();
                        }
                        try {
                            $userDo = Shop::Get()->getUserService()->getUser();

                            CommentsAPI::Get()->addComment(
                                'shop-history-user-del'.$user->getId(),
                                Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_deleted').
                                ' #'.$user->getId().' '.$user->makeName(),
                                $userDo->getId()
                            );
                        } catch (Exception $e) {

                        }
                    } catch (Exception $pe) {

                    }
                }
            }
        }

        // объединить клиентов
        if ($this->getControlValue('join')) {

            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                try {
                    Shop::Get()->getUserService()->mergeUsers($r[1]);
                } catch (Exception $pe) {

                }
            }
        }

        $users = $this->_getUsers();

        $datasource = $this->_getDatasource();

        if ($groupID) {
            // проверяем есть ли у группы родители
            $a = array($groupID);
            $tmp = Shop::Get()->getUserService()->makeUserGroupTree($groupID);
            foreach ($tmp as $x) {
                $a[] = $x->getId();
            }

            $u2g = new XShopUser2Group();

            $users->innerJoinTable($u2g->getTablename(), $u2g->getTablename().'.userid='.$users->getTablename().'.id');
            $users->addWhereQuery($u2g->getTablename().'.groupid IN ('.implode(',', $a).')');
            $users->setGroupByQuery($users->getTablename().'.id');
        } 
        if ($groupID === '0') {
            $u2g = new XShopUser2Group();
            $users->addWhereQuery("`users`.`id` NOT IN (SELECT `userid` FROM ".$u2g->getTablename().")");
        }
        $datasource->setSQLObject($users);

        $filterCompany = $this->getArgumentSecure('company', 'string');
        if ($filterCompany) {
            $datasource->getSQLObject()->setCompany($filterCompany);
        }

        $filterNamelast = $this->getControlValue('filternamelast');
        if ($filterNamelast) {
            $filterNamelast = str_replace(' ', '%', $filterNamelast);
            $filterNamelast = "%{$filterNamelast}%";
            $datasource->getSQLObject()->addWhere(
                $datasource->getSQLObject()->getTablename().'.`namelast`',
                $filterNamelast,
                'LIKE'
            );
        }

        $filterName = $this->getControlValue('filtername');
        if ($filterName) {
            $filterName = str_replace(' ', '%', $filterName);
            $filterName = "%{$filterName}%";
            $datasource->getSQLObject()->addWhere(
                $datasource->getSQLObject()->getTablename().'.`name`',
                $filterName,
                'LIKE'
            );
        }

        $filterNamemiddle = $this->getControlValue('filternamemiddle');
        if ($filterNamemiddle) {
            $filterNamemiddle = str_replace(' ', '%', $filterNamemiddle);
            $filterNamemiddle = "%{$filterNamemiddle}%";
            $datasource->getSQLObject()->addWhere(
                $datasource->getSQLObject()->getTablename().'.`namemiddle`',
                $filterNamemiddle,
                'LIKE'
            );
        }

        $filterCompany = $this->getControlValue('filtercompany');
        if ($filterCompany) {
            $filterCompany = str_replace(' ', "%' AND `company` LIKE '%", $filterCompany);
            $filterCompany = "'%{$filterCompany}%'";
            $datasource->getSQLObject()->addWhereQuery(
                $datasource->getSQLObject()->getTablename().'.`company` LIKE '.$filterCompany
            );
        }

        $filterEmail = $this->getControlValue('filteremail');
        if ($filterEmail) {
            $filterEmail = str_replace(' ', '%', $filterEmail);
            $filterEmail = "%{$filterEmail}%";
            $datasource->getSQLObject()->addWhereQuery(
                '('.$datasource->getSQLObject()->getTablename().'.`email` LIKE \''.$filterEmail.'\' OR '.
                $datasource->getSQLObject()->getTablename().'.`emails` LIKE \''.$filterEmail.'\')'
            );
        }

        $filterPhone = $this->getArgumentSecure('filterphone');
        if ($filterPhone) {
            $filterPhone = preg_replace("/([^0-9])/ius", '', $filterPhone);
            //$phoneNumberArray = str_split($filterPhone);
            //$filterPhone = implode('%', $phoneNumberArray);
            $filterPhone = "%{$filterPhone}%";

            $datasource->getSQLObject()->addWhereQuery(
                '('.$datasource->getSQLObject()->getTablename().'.`phone` LIKE \''.$filterPhone.'\' OR '.
                $datasource->getSQLObject()->getTablename().'.`phones` LIKE \''.$filterPhone.'\')'
            );

        }
        
        $filterAddress = $this->getControlValue('filteraddress');
        if ($filterAddress) {
            $filterAddress = str_replace(' ', '%', $filterAddress);
            $filterAddress = "%{$filterAddress}%";
            $datasource->getSQLObject()->addWhere(
                $datasource->getSQLObject()->getTablename().'.`address`',
                $filterAddress,
                'LIKE'
            );
        }

        $filterLogin = $this->getControlValue('filterlogin');
        if ($filterLogin) {
            $filterLogin = str_replace(' ', '%', $filterLogin);
            $filterLogin = "%{$filterLogin}%";
            $datasource->getSQLObject()->addWhere(
                $datasource->getSQLObject()->getTablename().'.`login`',
                $filterLogin,
                'LIKE'
            );
        }

        $filterTags = $this->getControlValue('filtertags');
        if ($filterTags) {
            $filterTags = str_replace(' ', '%', $filterTags);
            $filterTags = "%{$filterTags}%";
            $datasource->getSQLObject()->addWhere(
                $datasource->getSQLObject()->getTablename().'.`tags`',
                $filterTags,
                'LIKE'
            );
        }

        $filterContractorid = $this->getArgumentSecure('filtercontractorid');
        if ($filterContractorid) {
            $datasource->getSQLObject()->setContractorid($filterContractorid);
        }

        $filterManagerid = $this->getArgumentSecure('filtermanagerid');
        if ($filterManagerid) {
            $datasource->getSQLObject()->setManagerid($filterManagerid);
        }

        $filterCreatorid = $this->getArgumentSecure('filtercreatorid');
        if ($filterCreatorid) {
            $datasource->getSQLObject()->setAuthorid($filterCreatorid);
        }
        
        //фильтр по невходящим контактам
        $workflowTypeArray = array();
        $workflowType = new XShopWorkflowType();
        while ($x = $workflowType->getNext()) {
            $workflowTypeArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );
        }
        $this->setValue('workflowTypeArray', $workflowTypeArray);
        
        if ($this->getArgumentSecure('notordertype')) {
            $type = new XShopWorkflowType($this->getArgumentSecure('notordertype'));
            $orderUser = new ShopOrder();
            $datasource->getSQLObject()->addWhereQuery(
                "`users`.`id` NOT IN (SELECT `userid` FROM ".$orderUser->getTablename()
                ." WHERE ".$orderUser->getTablename().".`type`='".$type->getType()."' GROUP BY userid)"
            );
        }
        
        $filterSourceid = $this->getArgumentSecure('filtersourceid');
        if ($filterSourceid) {
            $datasource->getSQLObject()->setSourceid($filterSourceid);
        }
        
        $filterDiscountid = $this->getArgumentSecure('filterdiscountid');
        if ($filterDiscountid) {
            $datasource->getSQLObject()->setDiscountid($filterDiscountid);
        }

        $filterLevel = $this->getArgumentSecure('filterlevel');
        if ($filterLevel) {
            $datasource->getSQLObject()->setLevel($filterLevel);
        }

        $filterPost = $this->getControlValue('filterpost');
        if ($filterPost) {
            $filterPost = "%{$filterPost}%";
            $datasource->getSQLObject()->addWhereQuery(
                '('.$datasource->getSQLObject()->getTablename().'.`post` LIKE \''.$filterPost.'\')'
            );
        }

        $typesex = $this->getArgumentSecure('filtertypesex');
        if ($typesex) {
            $this->setValue('typesexValue', $typesex);

            if ($typesex == 'contact') {
                $datasource->getSQLObject()->addWhereArray(array('man','woman'), 'typesex', '=');
            } elseif ($typesex == 'no_data') {
                $datasource->getSQLObject()->setTypesex('');
            } elseif ($typesex == 'employer') {
                $datasource->getSQLObject()->setEmployer(1);
            } else {
                $datasource->getSQLObject()->setTypesex($typesex);
            }
        }

        if ($this->getArgumentSecure('filter_show_employer')) {
            $datasource->getSQLObject()->addWhere('employer', '1', '=');
            $this->setControlValue('filter_show_employer', $this->getArgumentSecure('filter_show_employer'));
        }

        $filterCdateFrom = $this->getArgumentSecure('filtercdatefrom');
        if ($filterCdateFrom) {
            $datasource->getSQLObject()->addWhere(
                $datasource->getSQLObject()->getTablename().'.`cdate`',
                $filterCdateFrom,
                '>='
            );
        }

        $filterCdateTo = $this->getArgumentSecure('filtercdateto');
        if ($filterCdateTo) {
            $datasource->getSQLObject()->addWhere(
                $datasource->getSQLObject()->getTablename().'.`cdate`',
                $filterCdateTo,
                '<='
            );
        }

        $filterAdateFrom = $this->getArgumentSecure('filteradatefrom');
        if ($filterAdateFrom) {
            $datasource->getSQLObject()->addWhere(
                $datasource->getSQLObject()->getTablename().'.`activitydate`',
                $filterAdateFrom,
                '>='
            );
        }

        $filterAdateTo = $this->getArgumentSecure('filteradateto');
        if ($filterAdateTo) {
            $datasource->getSQLObject()->addWhere(
                $datasource->getSQLObject()->getTablename().'.`activitydate`',
                $filterAdateTo,
                '<='
            );
        }

        // фильтрация по доп полям
        $fields = new ShopContactField();
        $fields->setFilterable(1);
        while ($x = $fields->getNext()) {
            try {
                $value = $this->getArgument('filtercustom'.$x->getIdkey());
                if (!$value) {
                    continue;
                }

                $tmp = new XShopCustomField();
                $tmp->setObjecttype('User');
                $tmp->setKey($x->getIdkey());
                if ($x->getType() == 'string' || $x->getType() == 'text') {
                    $tmp->filterValue('%'.$value.'%', 'LIKE');
                } elseif ($x->getType() == 'date') {
                    $tmp->filterValue(DateTime_Formatter::DateISO9075($value));
                } elseif ($x->getType() == 'datetime') {
                    $tmp->filterValue(DateTime_Formatter::DateTimeISO9075($value));
                } elseif ($x->getType() == 'check') {
                    $tmp->filterValue(1);
                } elseif ($x->getType() == 'bool') {
                    $tmp->filterValue(1);
                }

                $a = array(-1);
                while ($xtmp = $tmp->getNext()) {
                    $a[] = $xtmp->getObjectid();
                }

                $datasource->getSQLObject()->addWhereArray(
                    $a,
                    $datasource->getSQLObject()->getTablename().'.`id`'
                );
            } catch (Exception $filterEx) {

            }
        }
        
        $mode = $this->getControlValue('mode');
        if ($mode) {
            $this->_setShowUsersMode($mode);
        } else {
            $ok = false;
            $table = new Shop_ContentTable($datasource);
            $table->render();
                
            // дополнительные способы отображения от модулей
            $moduleModeArray = Shop_ModuleLoader::Get()->getUserViewModeArray();
            foreach ($moduleModeArray as $moduleMode) {
                if ($mode == $moduleMode['modeName']) {
                    $block = Engine::GetContentDriver()->getContent($moduleMode['contentID']);
                    $block->setValue('users', $datasource->getSQLObject());
                    $this->setValue('table', $block->render());
                    $ok = true;
                }
            }

            if (!$ok) {
                $block = Engine::GetContentDriver()->getContent('shop-user-tile');
                $block->setValue('users', $datasource->getSQLObject());
                $this->setValue('table', $block->render());
            }
        }

        $this->setValue('userFilterCount', $datasource->getSQLObject()->getCount());

        // получаем id всех отсортированных пользователей
        $connection = ConnectionManager::Get()->getConnectionDatabase();

        $x = clone $datasource->getSQLObject();
        $x->setLimit(0, 0);
        $sql = $x->__toString();
        $sql = mb_substr($sql, mb_strpos($sql, 'FROM'));
        $sql = "SELECT `users`.`id` ".$sql;
        $q = $connection->query($sql);
        $userIDArray = array();
        while ($r = $connection->fetch($q)) {
            $userIDArray[] = $r['id'];
        }
        $this->setValue('arrUserId', implode(';', $userIDArray));

        // дерево групп
        $this->setValue('groupArray', $this->_makeGroupArray($datasource->getSQLObject()));
        $this->setValue('newGroupArray', $this->_makeGroupArray2($datasource->getSQLObject()));

        if ($this->getArgumentSecure('groupid') == 0) {
            $this->setValue('notGroup', true);
        }     
        $this->setValue('groupid', $groupID);

        $this->setValue('levelArray', $this->_makeLevelArray());
        $this->setValue('managerArray', $this->_makeManagerArray());
        $this->setValue('creatorArray', $this->_makeManagerArray());

        // юридические лица
        $contractors = Shop::Get()->getShopService()->getContractorsAll();
        $this->setValue('contractorsArray', $contractors->toArray());

        // источники
        $sources = Shop::Get()->getShopService()->getSourceAll();
        $this->setValue('sourceArray', $sources->toArray());
        
        $discount = Shop::Get()->getShopService()->getDiscountAll();
        $this->setValue('discountArray', $discount->toArray());

        // список всех компаний с учетом фильтра

        if ($filterCompany) {
            $datasource->getSQLObject()->unsetField('company');
        }

        $login = Shop::Get()->getSettingsService()->getSettingValue('sms-login');
        $pass = Shop::Get()->getSettingsService()->getSettingValue('sms-password');
        $sender = Shop::Get()->getSettingsService()->getSettingValue('sms-sender');
        if ($sender && $login && $pass) {
            $this->setValue('canSMS', true);
        }

        try {
            // дополнительные способы отображения от модулей
            $this->setValue('moduleViewModeArray', Shop_ModuleLoader::Get()->getUserViewModeArray());
        } catch (Exception $e) {

        }

        // дополнительные фильтра
        $a = array();
        $fields = new ShopContactField();
        $fields->filterFilterable(1);
        $fields->filterType('system', '!=');
        while ($x = $fields->getNext()) {
            $a[$x->getIdkey()] = array(
            'name' => $x->makeName(),
            'key' => $x->getIdkey(),
            'type' => $x->getType(),
            'value' => $this->getControlValue('filtercustom'.$x->getIdkey()),
            );
        }
        $this->setValue('filterCustomArray', $a);
    }

    /**
     * Способ отображения
     *
     * @param $contentid
     * @param $blockid
     */
    private function _setShowUsersMode($mode) {
        $datasource = $this->_getDatasource();
        $block = Engine::GetContentDriver()->getContent($mode);
        $block->setValue('datasource', $datasource);
        $this->setValue('table', $block->render());                
    }
    
    
    private function _makeManagerArray() {
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        $managersInfo = array();
        while ($x = $managers->getNext()) {
            $a = array();
            $a['id'] = $x->getId();
            $a['name'] = $x->makeName();
            $managersInfo[] = $a;
        }
        return $managersInfo;
    }

    private function _makeLevelArray() {
        $levelArr = array();
        for ($i = 0;$i < 4; $i++) {
            $b = array();
            $b['id'] = $i;
            if ($i == 0) {
                $b['name'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_blocked_big');
            }
            if ($i == 1) {
                $b['name'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_access_user');
            }
            if ($i == 2) {
                $b['name'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_access_manager');
            }
            if ($i == 3) {
                $b['name'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_administrator_big');
            }
            $levelArr[] = $b;
        }
        return $levelArr;
    }

    private function _makeGroupArray(SQLObject $sqlobject) {
        $sqlobject = clone $sqlobject;
        $sqlobject->setOrder(false, false);

        $u2g = new XShopUser2Group();

        $group = Shop::Get()->getUserService()->makeUserGroupTree();
        $a = array();
        foreach ($group as $x) {          
            if ($x->getLogicclass()) {
                continue;
            }        
            $treeArray = array($x->getId());
            $tmp = Shop::Get()->getUserService()->makeUserGroupTree($x->getId());
            foreach ($tmp as $xtmp) {
                $treeArray[] = $xtmp->getId();
            }
            $sqlobject2 = clone $sqlobject;
            $sqlobject2->innerJoinTable(
                $u2g->getTablename(),
                $u2g->getTablename().".userid=".$sqlobject2->getTablename().".id"
            );
            $sqlobject2->addWhereQuery($u2g->getTablename().".groupid IN (".implode(',', $treeArray).")");
            $sqlobject2->setGroupByQuery($sqlobject2->getTablename().'.id');
            $count = $sqlobject2->getCount();

            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'selected' => $x->getId() == $this->getArgumentSecure('groupid'),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('groupid' => $x->getId())),
                'parentid' => $x->getParentid(),
                'count' => $count,
                'level' => $x->getField('level'),
            );
        }
        return $a;
    }

    private function _makeGroupArray2(SQLObject $sqlobject) {
        $sqlobject = clone $sqlobject;
        $sqlobject->setOrder(false, false);

        $u2g = new XShopUser2Group();

        $group = Shop::Get()->getUserService()->makeUserGroupTree();
        $a = array();
        foreach ($group as $x) {
            $treeArray = array($x->getId());
            $tmp = Shop::Get()->getUserService()->makeUserGroupTree($x->getId());
            foreach ($tmp as $xtmp) {
                $treeArray[] = $xtmp->getId();
            }

            $sqlobject2 = clone $sqlobject;
            $sqlobject2->innerJoinTable(
                $u2g->getTablename(),
                $u2g->getTablename().".userid=".$sqlobject2->getTablename().".id"
            );
            $sqlobject2->addWhereQuery($u2g->getTablename().".groupid IN (".implode(',', $treeArray).")");
            $sqlobject2->setGroupByQuery($sqlobject2->getTablename().'.id');
            $count = $sqlobject2->getCount();

            $a[$x->getParentid()][] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'selected' => $x->getId() == $this->getArgumentSecure('groupid'),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('groupid' => $x->getId())),
                'parentid' => $x->getParentid(),
                'count' => $count,
                'level' => $x->getField('level'),
            );
        }
        return $a;
    }

    private $_datasource = null;
}