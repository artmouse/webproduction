<?php
class dashboard_index extends Engine_Class {

    public function process() {
        // если box отключен - то редирект на заказы
        $box = Engine::Get()->getConfigFieldSecure('project-box');
        if (!$box) {
            if (Shop_ModuleLoader::Get()->isImported('order')) {
                header('Location: /admin/shop/orders/');
                exit();
            } else {
                header('Location: /admin/shop/products/list-table/');
                exit();
            }
        }

        $groupBy = $this->getArgumentSecure('groupby');
        if (!$groupBy) {
            $groupBy = 'hour';
        }

        if ($this->getArgumentSecure('ok')) {
            $datefrom = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateFrom'));
            $dateto = DateTime_Corrector::CorrectDate($this->getControlValue('dateTo')).' 23:59:59';
        } else {
            $dateto = DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now());
            $datefrom = DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now()->addMonth(-6)->setFormat('Y-m-01'));

            $this->setControlValue('dateFrom', $datefrom);
            $this->setControlValue('dateTo', $dateto);
        }

        $cuser = $this->getUser();

        // загружаем всех сотрудников (для кеша)
        $employers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $employers->getNext()) {
            false;
        }

        // загружаем все статусы (для кеша)
        $statuses = Shop::Get()->getShopService()->getStatusAll();
        while ($x = $statuses->getNext()) {
            false;
        }

        // Календарь
        $issues = IssueService::Get()->getIssuesAll($cuser);
        $issues->unsetField('type');
        $list = Engine::GetContentDriver()->getContent('issue-list');
        try {
            $this->getArgument('filtershowclosed');
        } catch (Exception $e) {
            Engine::GetURLParser()->setArgument('filtershowclosed', true);
        }
        try {
            $this->getArgument('mode');
        } catch (Exception $e) {
            Engine::GetURLParser()->setArgument('mode', 'calendar');
        }
        try {
            $this->getArgument('filtermanagerid');
        } catch (Exception $e) {
            Engine::GetURLParser()->setArgument('filtermanagerid', $cuser->getId());
        }
        $list->setValue('issues', $issues);
        $this->setValue('block_issue', $list->render());

        // список моих сотрудников в подчинении
        // получаем мои роли
        $roleArray = $cuser->getRoleArray();

        // получаем подроли по каждой роли
        // но только на один уровень вниз
        $subRoleArray = array();
        foreach ($roleArray as $roleName) {
            try {
                $role = RoleService::Get()->getRoleByName($roleName);

                $tmp = RoleService::Get()->getRoleAll();
                $tmp->setParentid($role->getId());
                while ($x = $tmp->getNext()) {
                    $subRoleArray[$x->getId()] = $x;
                }
            } catch (Exception $e) {

            }
        }

        $employerArray = array();

        // себя в начало
        $employerArray[$cuser->getId()] = array(
        'id' => $cuser->getId(),
        'image' => $cuser->makeImageThumb(50, 50),
        'name' => $cuser->makeName(true, 'lfm'),
        'me' => 1,
        'roleArray' => $cuser->getRoleArray(),
        );

        // на каждую под-роль находим сотрудников
        foreach ($subRoleArray as $role) {
            try {
                $employers = RoleService::Get()->getUsersByRole($role->getName());
                $employers->setEmployer(1);
                $employers->addWhere('level', 2, '>=');
                $employers->addWhere('id', $cuser->getId(), '!=');
                while ($x = $employers->getNext()) {
                    if (!isset($employerArray[$x->getId()])) {
                        $employerArray[$x->getId()] = array(
                            'id' => $x->getId(),
                            'image' => $x->makeImageThumb(50, 50),
                            'name' => $x->makeName(true, 'lfm'),
                            'roleArray' => array(),
                        );
                    }

                    $employerArray[$x->getId()]['roleArray'][] = $role->getName();
                }
            } catch (Exception $e) {

            }
        }

        foreach ($employerArray as $userID => $x) {
            // сколько задач на сегодня
            $issues = IssueService::Get()->getIssuesAll($cuser);
            $issues->setManagerid($userID);
            $issues->addWhere('dateto', date('Y-m-d').' 00:00:00', '>=');
            $issues->addWhere('dateto', date('Y-m-d').' 23:59:59', '<=');
            $todayAll = $issues->getCount();

            // сколько выполнено
            $issues = IssueService::Get()->getIssuesAll($cuser);
            $issues->setManagerid($userID);
            $issues->addWhere('dateto', date('Y-m-d').' 00:00:00', '>=');
            $issues->addWhere('dateto', date('Y-m-d').' 23:59:59', '<=');
            $issues->addWhere('dateclosed', '0000-00-00 00:00:00', '!=');
            $todayDone = $issues->getCount();

            // сколько нераспределенных открытых задач вообще
            $issues = IssueService::Get()->getIssuesAll($cuser);
            $issues->setManagerid($userID);
            $issues->setPriority(0);
            $issues->setDateclosed('0000-00-00 00:00:00');
            $noPriority = $issues->getCount();

            $url = Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('filtermanagerid' => $userID));

            $employerArray[$userID]['selected'] = $userID == $this->getArgumentSecure('filtermanagerid');
            $employerArray[$userID]['url'] = $url;
            $employerArray[$userID]['todayAll'] = $todayAll;
            $employerArray[$userID]['todayDone'] = $todayDone;
            $employerArray[$userID]['noPriority'] = $noPriority;
        }

        usort($employerArray, array($this, '_sortName'));
        $this->setValue('myEmployeeArray', $employerArray);

        // when choosing manager in calendar set his name on browser title
        if ($this->getArgumentSecure('filtermanagerid')) {
            $empID = $this->getArgumentSecure('filtermanagerid');
            $employer = Shop::Get()->getUserService()->getUserByID($empID);
            Engine_HTMLHead::Get()->setTitle($employer->makeName());
        }

    }

    private function _sortName($a, $b) {
        if (!empty($a['me'])) {
            return -1;
        }
        if (!empty($b['me'])) {
            return 1;
        }
        return $a['name'] > $b['name'];
    }

}