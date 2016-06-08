<?php
/**
 * IssueService
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * 
 * @copyright WebProduction
 *
 * @package OneBox
 */
class IssueService extends ServiceUtils_AbstractService {

    /**
     * Получить все задачи, заказы и проекты
     *
     * @return ShopOrder
     */
    public function getIssuesAll($user = false) {
        $orders = Shop::Get()->getShopService()->getOrdersAll($user, false, 'issue');
        $orders->unsetField('issue'); // @todo
        $orders->setOrder('id', 'DESC');
        $orders->setType('issue');

        return $orders;
    }

    /**
     * Получить только проекты
     *
     * @param User $user
     *
     * @return ShopOrder
     */
    public function getProjectsAll($user = false) {
        $orders = Shop::Get()->getShopService()->getOrdersAll($user, false, 'project');
        $orders->unsetField('issue'); // @todo
        $orders->setType('project');
        $orders->setOrder('id', 'DESC');
        return $orders;
    }

    /**
     * Разрешено ли пользователю просматривать задачу
     *
     * @param ShopOrder $order
     * @param User $user
     *
     * @return bool
     */
    public function isIssueViewAllowed(ShopOrder $order, User $user) {
        return Shop::Get()->getShopService()->isOrderViewAllowed($order, $user);
    }

    /**
     * Разрешено ли пользователю управлять заказом
     *
     * @param ShopOrder $order
     * @param User $user
     *
     * @return bool
     */
    public function isIssueChangeAllowed(ShopOrder $order, User $user) {
        return Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
    }

    /**
     * Обновить родительскую задачу
     *
     * @param User $cuser
     * @param ShopOrder $order
     * @param int $parentID
     */
    public function updateIssueParent(User $cuser, ShopOrder $order, $parentID) {
        try {
            SQLObject::TransactionStart();

            if (!Shop::Get()->getShopService()->isOrderChangeAllowed($order, $cuser)) {
                throw new ServiceUtils_Exception('permission');
            }

            if ($parentID) {
                $parent = $this->getIssueByID($parentID);

                $tmp = $parent;
                while ($tmp->getParentid()) {
                    if ($tmp->getParentid() == $order->getId()) {
                        throw new ServiceUtils_Exception('parent-child');
                    }

                    $tmp = $this->getIssueByID($tmp->getParentid());
                }
            }

            $order->setParentid($parentID);
            $order->update();

            SQLObject::TransactionCommit();

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Создать подзадачи по указанному статусу
     *
     * @param User $user
     * @param ShopOrder $issue
     * @param ShopOrderStatus $status
     */
    public function createSubIssues(User $user, ShopOrder $issue, ShopOrderStatus $status) {
        $sub = new XShopOrderStatusSubWorkflow();
        $sub->setStatusid($status->getId());
        $sub->setOrder('sort', 'ASC');
        while ($statusSub = $sub->getNext()) {
            try {
                $subWorkflowID = $statusSub->getSubworkflowid();
                $subWorkflowName = $statusSub->getSubworkflowname();
                $subWorkflowDate = $statusSub->getSubworkflowdate();
                $subWorkflowDescription = $statusSub->getSubworkflowdescription();

                $subWorkflow = Shop::Get()->getShopService()->getOrderCategoryByID($subWorkflowID);

                $subIssue = new ShopOrder();
                $subIssue->setName($subWorkflowName);
                $subIssue->setParentid($issue->getId());
                $subIssue->setCategoryid($subWorkflow->getId());
                //$subIssue->setPriority($statusSub->getSort());
                if ($subIssue->select()) {
                    // задача найдена - обновляем ее на старт
                    Shop::Get()->getShopService()->updateOrderStatus(
                        $user,
                        $subIssue,
                        $subWorkflow->getStatusDefault()->getId()
                    );

                    // $comment .= "Подзадача #{$subIssue->getId()}
                    // переведена в состояние {$subIssue->getStatus()->getName()}\n";
                } else {
                    // определяем кто ответственный за этап
                    // по умолчанию - никто
                    $subWorkflowManagerID = false;

                    // может кто-то из сотрудников?
                    $employer = new XShopOrderEmployer();
                    $employer->setOrderid($issue->getId());
                    $employer->setStatusid($status->getId());
                    if ($employer->select()) {
                        $subWorkflowManagerID = $employer->getManagerid();
                    }

                    // может задан по умолчанию?
                    if (!$subWorkflowManagerID) {
                        $subWorkflowManagerID = $subWorkflow->getManagerid();
                    }

                    // тогда менеджер заказа
                    if (!$subWorkflowManagerID) {
                        $subWorkflowManagerID = $issue->getManagerid();
                    }

                    // имя новой задачи
                    $name = $subWorkflowName;
                    if (!$name) {
                        $name = $subWorkflow->getIssuename();
                    }
                    if (!$name) {
                        $name = $subWorkflow->getName();
                    }
                    $name = str_replace('[IssueName]', $issue->getName(), $name);

                    if ($subWorkflowDate) {
                        $dateto = DateTime_Object::Now()->addDay(+$subWorkflowDate)->setFormat('Y-m-d')->__toString();
                    } else {
                        $dateto = DateTime_Object::Now()->addDay(
                            +$subWorkflow->getTerm()
                        )->setFormat('Y-m-d')->__toString();
                    }

                    // задача не найдена, создаем ее
                    $subIssue = IssueService::Get()->addIssue(
                        $user,
                        $name,
                        $subWorkflowDescription, // content
                        $subWorkflowManagerID,
                        $subWorkflow->getId(),
                        $dateto, // dateto
                        $issue->getUserid(),
                        $issue->getId()
                    );

                    // ставим приоритет
                    // находим максимальный приоритет на этот день
                    $tmp = new XShopOrder();
                    $tmp->addWhere('priority', 0, '>');
                    $tmp->addWhere('dateto', $dateto.' 00:00:00', '>=');
                    $tmp->addWhere('dateto', $dateto.' 23:59:59', '<=');
                    $tmp->setManagerid($subWorkflowManagerID);
                    $tmp->setOrder('priority', 'DESC');
                    $tmp->setLimitCount(1);
                    $xtmp = $tmp->getNext();
                    if ($xtmp) {
                        // и если получилось найти - то ставим приоритет +1
                        $subIssue->setPriority($xtmp->getPriority() + 1);
                        $subIssue->update();
                    } else {
                        // найти не получилось - просто 1
                        $subIssue->setPriority(1);
                        $subIssue->update();
                    }
                }
            } catch (Exception $subEx) {

            }
        }

    }

    /**
     * Получить задачу по ID
     *
     * @param int $id
     *
     * @return ShopOrder
     *
     * @deprecated
     *
     * @see getOrderByID()
     */
    public function getIssueByID($id) {
        return $this->getObjectByID($id, 'ShopOrder');
    }

    /**
     * Определить бизнес-процесс по умолчанию для задачи
     * с заданным именем.
     *
     * Особенность в том, что на основании имени по ключевым словам
     * можно понять, что это вообще за процесс.
     *
     * @param string $issueName
     *
     * @return ShopOrderCategory
     */
    public function getIssueWorkflowDefault($issueName = false) {
        // попытка определить Workflow на основании имени
        if ($issueName) {
            // получаем все workflow с ключевыми словами
            $workflows = Shop::Get()->getShopService()->getWorkflowsAll();
            $workflows->addWhere('keywords', '', '!=');
            $workflows->setType('issue');
            $workflows->setHidden(0);

            while ($w = $workflows->getNext()) {
                try {
                    $tmp = explode("\n", $w->getKeywords());
                    foreach ($tmp as $keyword) {
                        $keyword = trim($keyword);
                        if (!$keyword) {
                            continue;
                        }

                        if (preg_match("/^{$keyword}$/ius", $issueName)) {
                            return $w;
                        }

                        if (preg_match("/\s+{$keyword}$/ius", $issueName)) {
                            return $w;
                        }

                        if (preg_match("/^{$keyword}\s+/ius", $issueName)) {
                            return $w;
                        }

                        if (preg_match("/\s+{$keyword}\s+/ius", $issueName)) {
                            return $w;
                        }
                    }
                } catch (Exception $similarEx) {

                }
            }
        }

        // по умолчанию для задач
        $workflow = Shop::Get()->getShopService()->getWorkflowsAll();
        $workflow->setDefault(1);
        $workflow->setType('issue');
        if ($workflow->select()) {
            return $workflow;
        }

        // не получилось
        throw new ServiceUtils_Exception('workflow');
    }

    /**
     * Создать новую задачу
     *
     * @return ShopOrder
     */
    public function addIssue(User $user, $name, $content, $managerID, $categoryID = false, $dateto = false,
    $clientID = false, $parentID = false, $priority = false) {
        $name = trim($name);
        $content = trim($content);

        try {
            SQLObject::TransactionStart();

            // если не задан бизнес-процесс
            if ($categoryID) {
                $workflow = Shop::Get()->getShopService()->getOrderCategoryByID($categoryID);
            } else {
                $workflow = $this->getIssueWorkflowDefault($name);
            }

            try {
                $statusDefault = $workflow->getStatusDefault();
            } catch (Exception $e) {
                $statusDefault = false;
            }

            // проверка на имя
            if (!$name) {
                throw new ServiceUtils_Exception('name');
            }

            // оформление заказа
            $order = new ShopOrder();
            $order->setCdate(date('Y-m-d H:i:s'));
            $order->setCategoryid($workflow->getId());
            $order->setIssue(($workflow->getType() == 'issue' || $workflow->getType() == 'project'));
            $order->setType($workflow->getType());
            $order->setOutcoming($workflow->getOutcoming());

            $order->setComments($content);

            // поиск активного юридического лица
            try {
                $contractor = Shop::Get()->getShopService()->getContractorDefault();
                $order->setContractorid($contractor->getId());
            } catch (Exception $e) {

            }

            // дата до которой нужно выполнить заказ
            if (Checker::CheckDate($dateto)) {
                $dateto = DateTime_Formatter::DateTimeISO9075($dateto);
                $order->setDateto($dateto);
            } elseif ($workflow->getTerm() >= 0) {
                $order->setDateto(DateTime_Object::Now()->addDay((int) $workflow->getTerm())->__toString());
            }

            // кто автор заказа
            $order->setAuthorid($user->getId());

            // кто менеджер заказа
            $order->setManagerid($managerID);

            // если есть привязка к родительской задаче
            if ($parentID) {
                $order->setParentid($parentID);

                try {
                    $parentIssue = $this->getIssueByID($parentID);
                    $order->setParentstatusid($parentIssue->getStatusid());
                } catch (Exception $e) {

                }
            }

            if ($name) {
                $order->setName($name);
            }

            try {
                $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
                $order->setCurrencyid($currency->getId());
            } catch (Exception $e) {

            }

            if ($priority) {
                $order->setPriority($priority);
            } else {
                $order->setPriority(0);
            }

            $order->setUuserid($user->getId());
            $order->insert();

            // Если клеинт не задан, то пытаемся найти клиента, по родительской задаче.
            try {
                if (!$clientID) {
                    $parentOrder = $order->getParent();
                    $clientID = $parentOrder->getUserid();
                }
            } catch (Exception $e) {

            }

            if ($clientID) {
                $order->setUserid($clientID);

                // записываем данные клиента в заказ
                try {
                    $client = Shop::Get()->getUserService()->getUserByID($clientID);
                    $order->setClientname($client->makeName(false));
                    $order->setClientemail($client->getEmail());
                    $order->setClientphone($client->getPhone());
                    $order->setClientaddress($client->getAddress());
                } catch (Exception $clientEx) {

                }
            }

            // проставляем номер
            $order->setNumber($order->getId());
            $order->update();

            // парсим комментарий на предмет юзеров
            // и добавляем их в наблюдатели
            if (preg_match_all("/\[(?:.+?)\#(\d+)\]/ius", $content, $r)) {
                foreach ($r[1] as $userID) {
                    try {
                        $wUser = Shop::Get()->getUserService()->getUserByID($userID);
                        Shop::Get()->getShopService()->addOrderEmployer($order, $wUser);
                    } catch (Exception $watcherEx) {

                    }
                }
            }

            // вставляем историю
            $change = new XShopOrderChange();
            $change->setUserid($user->getId());
            $change->setOrderid($order->getId());
            $change->setCdate($order->getCdate());
            $change->setKey('statusid');
            $change->setValue($order->getStatusid());
            $change->insert();

            if ($statusDefault) {
                Shop::Get()->getShopService()->updateOrderStatus(
                    $user,
                    $order,
                    $statusDefault->getId()
                );
            }

            // генерируем событие
            $event = Events::Get()->generateEvent('shopOrderAddAfter');
            $event->setOrder($order);
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();

            return $order;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Закрыть задачу.
     * Метод находит закрывающий статус и переключает задачу в нее.
     *
     * @param ShopOrder $issue
     *
     * @return bool
     */
    function closeIssue(ShopOrder $issue, User $user = null) {
        if ($issue->isClosed()) {
            return false;
        }

        $statusClosed = $issue->getWorkflow()->getStatusClosed();

        if (!$user) {
            $user = Shop::Get()->getUserService()->getUser();
        }

        Shop::Get()->getShopService()->updateOrderStatus(
            $user,
            $issue,
            $statusClosed->getId()
        );

        return true;
    }

    /**
     * Открыть задачу.
     * Метод находит первый статус и переключает задачу в нее.
     *
     * @param ShopOrder $issue
     *
     * @return bool
     */
    function openIssue(ShopOrder $issue, User $user = null) {
        if (!$issue->isClosed()) {
            return false;
        }

        $statusDefault = $issue->getWorkflow()->getStatusDefault();

        if (!$user) {
            $user = Shop::Get()->getUserService()->getUser();
        }

        Shop::Get()->getShopService()->updateOrderStatus(
            $user,
            $issue,
            $statusDefault->getId()
        );

        return true;
    }

    /**
     * Обновить json файл для mind
     *
     * @param ShopProject $project
     *
     * @return string
     */
    public function updateIssueMindJson(ShopOrder $issues) {
        $issueArray = array();
        while ($issue = $issues->getNext()) {
            try {
                $parentIssue = $issue->getParent();

                $issueArray[0][] = array(
                    'issueid' => $parentIssue->getId(),
                    'name' => $parentIssue->getId()
                );

                $issueArray[$issue->getParentid()][] = array(
                    'issueid' => $issue->getId(),
                    'name' => $issue->getId()//mb_substr($issue->getName(), 0, 10)
                );
            } catch (ServiceUtils_Exception $se) {

            }
        }

        $nodeID = 1;
        $children = $this->_makeIssueTree(0, 0, $issueArray, $nodeID);

        $a = array(
            'nodeid' => 1,
            'name' => 'start',
            'children' => $children['data']
        );

        $json = json_encode($a);
        $filename = MEDIA_PATH.'/tmp/mind.json';
        file_put_contents($filename, $json);

        return $json;
    }

    /**
     * Проверка задач в которых не было связи с клиентом, больше установленного срока
     * Если связи не было - пишем уведомление в задачу
     */
    public function checkIssueNoCommunication() {
        // Получить этапы в которых есть проверка времени связи
        $allStatus = new ShopOrderStatus;
        $allStatus->addWhereQuery(
            "`no_communication` != 0 OR `no_communication_call` != 0 OR `no_communication_email` != 0"
        );

        while ($status = $allStatus->getNext()) {

            $noComm = (int) $status->getNo_communication();
            $noCommCall = (int) $status->getNo_communication_call();
            $noCommEmail = (int) $status->getNo_communication_email();
            $termNoComm = DateTime_Object::Now()->addHour(-$noComm)->__toString();
            $termNoCommCall = DateTime_Object::Now()->addHour(-$noCommCall)->__toString();
            $termNoCommEmail = DateTime_Object::Now()->addHour(-$noCommEmail)->__toString();

            // получить задачи с контролируемым этапом
            $issues = $this->getIssuesAll();
            $issues->filterDateclosed('0000-00-00 00:00:00');
            $issues->filterStatusid($status->getId());

            while ($issue = $issues->getNext()) {
                $cdate = $issue->getCdate();
                try {
                    $client = Shop::Get()->getUserService()->getUserByID($issue->getUserid());
                } catch (Exception $e) {
                    continue;
                }
                // не было связи с клиентом
                if ($noComm && $termNoComm > $cdate) {
                    try {
                        $this->checkClientCommunication($client, $termNoComm);
                    } catch (Exception $e) {
                        $comment = "Не было связи с клиентом - более $noComm часов";
                        try {
                            $notifyTerm = DateTime_Object::Now()->addDay(-$noComm)->__toString();
                            Shop::Get()->getShopService()->addOrderNotify($issue, false, $comment, $notifyTerm);
                        } catch (Exception $e) {

                        }
                    }
                }

                // не было связи по телефону
                if ($noCommCall && $termNoCommCall > $cdate) {
                    try {
                        $this->checkClientCommunication($client, $termNoCommCall, 'call');
                    } catch (Exception $e) {
                        $comment = "Не было связи с клиентом, через звонки - более $noCommCall часов";
                        try {
                            $notifyTerm = DateTime_Object::Now()->addDay(-$noCommCall)->__toString();
                            Shop::Get()->getShopService()->addOrderNotify($issue, false, $comment, $notifyTerm);
                        } catch (Exception $e) {

                        }
                    }
                }

                // не было связи по email
                if ($noCommEmail && $termNoCommEmail > $cdate) {
                    try {
                        $this->checkClientCommunication($client, $termNoCommEmail, 'email');
                    } catch (Exception $e) {
                        $comment = "Не было связи с клиентом, через email - более $noCommEmail часов";
                        try {
                            $notifyTerm = DateTime_Object::Now()->addDay(-$noCommEmail)->__toString();
                            Shop::Get()->getShopService()->addOrderNotify($issue, false, $comment, $notifyTerm);
                        } catch (Exception $e) {

                        }
                    }
                }
            }
        }

    }

    /**
     * Проверка всех задач на "сколько задача висела в этом статусе".
     * Если срок превышен - пишем уведомление в задачу.
     */
    public function checkIssueTerms() {
        // получаем все задачи
        $issue = $this->getIssuesAll();
        $issue->setDateclosed('0000-00-00 00:00:00');
        while ($x = $issue->getNext()) {
            // для каждой задачи делаем проверку срока
            $tmp = new XShopOrderChange();
            $tmp->setOrderid($x->getId());
            $tmp->setOrder('id', 'DESC');
            $tmp->setLimitCount(1);
            $tmp->setKey('statusid');
            $tmp->setValue($x->getStatusid());
            if ($xtmp = $tmp->getNext()) {
                try {
                    $employer = new XShopOrderEmployer();
                    $employer->setOrderid($x->getId());
                    $employer->setStatusid($x->getStatus()->getId());
                    $employer = $employer->getNext();

                    $statusDate = false;
                    if ($employer && $employer->getTerm() != '0000-00-00 00:00:00') {
                        $statusDate = $employer->getTerm();
                    } elseif ($x->getStatus()->getTerm()) {
                        $statusDate = DateTime_Object::FromString($xtmp->getCdate());

                        $term = $x->getStatus()->getTerm();
                        $period = $x->getStatus()->getTermperiod();

                        if ($period == 'hour') {
                            $statusDate->addHour($term);
                        } elseif ($period == 'day') {
                            $statusDate->addDay($term);
                        } elseif ($period == 'week') {
                            $statusDate->addDay($term * 7);
                        } elseif ($period == 'month') {
                            $statusDate->addMonth($term);
                        } elseif ($period == 'year') {
                            $statusDate->addYear($term);
                        } else {
                            // иначе дни
                            $statusDate->addDay($term);
                        }

                        $statusDate = $statusDate->__toString();
                    }

                    if ($statusDate && ($statusDate <= date('Y-m-d H:i:s'))) {
                        $comment = 'Задача слишком долго находится в состоянии '.$x->getStatus()->getName().'. ';
                        if ($employer && $employer->getTerm() != '0000-00-00 00:00:00') {
                            $comment .= 'Крайний срок этого этапа был определен на '.$employer->getTerm().'.';
                        } else {
                            $comment .= 'Допустимое время: '.$term.' '.$period.'. ';
                            $comment .= 'Крайний срок этого этапа был определен на '.$xtmp->getCdate().'.';
                        }

                        $term = DateTime_Object::Now()->addDay(-1)->__toString();
                        Shop::Get()->getShopService()->addOrderNotify($x, false, $comment, $term);
                    }

                    // автоматический переход на следующий этап
                    if ($statusDate && ($statusDate <= date('Y-m-d H:i:s')) && $x->getStatus()->getAutonextstatusid()) {
                        try {
                            if ($x->getManagerid()) {
                                $user = $x->getManager();
                            } else {
                                $user = $x->getAuthor();
                            }

                            Shop::Get()->getShopService()->updateOrderStatus(
                                $user,
                                $x,
                                $x->getStatus()->getAutonextstatusid()
                            );
                        } catch (ServiceUtils_Exception $nse) {

                        }
                    }
                } catch (Exception $statusEx) {
                    print $statusEx;
                }
            }
        }
    }

    /**
     * Автоматически переносить не сделанные задачи на следующий день.
     * Метод запускается каждый час, проверяет задачи которые якобы надо
     * перенести со вчера на сегодня и делает это.
     *
     * Задачи без приоритета - переносятся без приоритета.
     */
    public function autoTransferIssues() {
        $date = DateTime_Object::Now()->setFormat('Y-m-d 00:00:00');
        $dateNow = DateTime_Object::Now()->setFormat('Y-m-d');

        $orderStatus = Shop::Get()->getShopService()->getStatusAll();
        $orderStatus->addWhere('nextdate', '', '<>');
        while ($status = $orderStatus->getNext()) {
            $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
            $orders->setStatusid($status->getId());
            $orders->addWhere('dateto', $dateNow, '<');
            $orders->addWhere('dateto', '0000-00-00 00:00:00', '!=');
            $orders->setDateclosed('0000-00-00 00:00:00');

            if ($status->getNextdate() == 'start') {
                $orders->setOrder('priority', 'DESC');
            } else {
                $orders->setOrder('priority');
            }

            while ($order = $orders->getNext()) {
                try {
                    $this->updateIssueDateto(
                        $order,
                        false, // user
                        $date,
                        false, // priority
                        $order->getPriority() ? $status->getNextdate() : false,
                        true
                    );
                } catch (Exception $ex) {

                }
            }
        }
    }

    /**
     * Автоматически создать задачи-клоны
     */
    public function autoCreateClone() {
        $dateNow = DateTime_Object::Now()->setFormat('Y-m-d');

        $statusAll = Shop::Get()->getShopService()->getStatusAll();
        $statusAll->setAutorepeat(1);
        while ($status = $statusAll->getNext()) {
            $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
            $orders->setStatusid($status->getId());
            $orders->addWhere('dateto', $dateNow, '<');
            $orders->addWhere('dateto', '0000-00-00 00:00:00', '!=');
            while ($order = $orders->getNext()) {
                try {

                    // проверка на уже созданую задачу
                    $newOrder = Shop::Get()->getShopService()->getOrdersAll(false, true);
                    $newOrder->setPrevid($order->getId());
                    if ($newOrder->select()) {
                        continue;
                    }

                    // dateto=now + (oldcdate - olddateto)
                    $dateTo = DateTime_Object::Now()->addDay(
                        DateTime_Differ::DiffDay(
                            $order->getDateto(),
                            DateTime_Object::FromString($order->getCdate())->setFormat('Y-m-d')
                        )
                    )->setFormat('Y-m-d');

                    $newOrder = Shop::Get()->getShopService()->cloneOrder($order);
                    $newOrder->setNumber($newOrder->getId());
                    $newOrder->setPrevid($order->getId());
                    $newOrder->setDateto($dateTo);
                    $newOrder->update();

                } catch (Exception $ex) {

                }
            }
        }
    }

    /**
     * Изменить дату и время выполнения задачи.
     * Приоритет как правило нужно менять из-за авто-переноса задач,
     * чтобы не сбивались планы на следующий день.
     *
     * @param ShopOrder $issue
     * @param User $user
     * @param string $dateto
     * @param int $priority
     * @param String $sort соритровка (start, end)
     */
    public function updateIssueDateto(
        ShopOrder $issue, $user, $dateto, $priority = false, $sort = false, $noComment = false
    ) {
        try {
            SQLObject::TransactionStart();

            if (!$issue->getPriority()) {
                // приоритет 0 - не распределенная задача, ей приоритет не меняем
                Shop::Get()->getShopService()->updateOrderDateto($issue, $user, $dateto, $noComment);
            } else {
                $sortPriority = false;
                if (!$priority && $sort == 'start') {
                    $sortPriority = ($this->getStartPriorityFromDay($dateto) - 1);
                } elseif (!$priority && $sort == 'end') {
                    $sortPriority = ($this->getEndPriorityFromDay($dateto) + 1);
                }

                Shop::Get()->getShopService()->updateOrderDateto($issue, $user, $dateto, $noComment);

                if ($priority) {
                    $issue->setPriority($priority);
                    $issue->update();
                } elseif ($sortPriority) {
                    $issue->setPriority($sortPriority);
                    $issue->update();
                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Возвращает Минимальный приоритет по задачам в заданный день
     *
     * @param $dateto
     *
     * @return int
     */
    public function getStartPriorityFromDay($dateto) {
        $dateto = DateTime_Object::FromString($dateto)->setFormat("Y-m-d")->__toString();
        $issues = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $issues->addWhereQuery("DATE_FORMAT(`dateto`, '%Y-%m-%d') = '$dateto'");
        $priority = 0;
        $count = 0;
        while ($x = $issues->getNext()) {
            if (!$count) {
                $priority = $x->getPriority();
            } elseif ($priority > $x->getPriority()) {
                $priority = $x->getPriority();
            }
            $count++;
        }

        return $priority;
    }

    /**
     * Возвращает Максимальный приоритет по задачам в заданный день
     *
     * @param $dateto
     *
     * @return int
     */
    public function getEndPriorityFromDay($dateto) {
        $dateto = DateTime_Object::FromString($dateto)->setFormat("Y-m-d")->__toString();
        $issues = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $issues->addWhereQuery("DATE_FORMAT(`dateto`, '%Y-%m-%d') = '$dateto'");
        $priority = 0;
        $count = 0;
        while ($x = $issues->getNext()) {
            if (!$count) {
                $priority = $x->getPriority();
            } elseif ($priority < $x->getPriority()) {
                $priority = $x->getPriority();
            }
            $count++;
        }

        return $priority;
    }

    private function _makeIssueTree($parentID, $level, $issueArray, $nodeID) {
        $a = array();

        if (empty($issueArray[$parentID])) {
            $result = array();
            $result['data'] = $a;
            $result['nodeid'] = $nodeID;
            return $result;
        }

        foreach ($issueArray[$parentID] as $x) {
            $nodeID++;
            $x['nodeid'] = $nodeID;

            $result = $this->_makeIssueTree($x['issueid'], $level + 1, $issueArray, $nodeID);
            $childs = $result['data'];
            $nodeID = $result['nodeid'];

            $b = array();
            foreach ($childs as $y) {
                $b[] = $y;
            }

            $x['children'] = $b;

            $a[] = $x;
        }

        $result = array();
        $result['data'] = $a;
        $result['nodeid'] = $nodeID;
        return $result;
    }

    /**
     * Проверить была ли связь с клиентом
     * от указанного периода, с указанным типом
     *
     * @param User $user клиент
     * @param string $date
     * @param string $type
     *
     * @return ShopEvent
     */
    public function checkClientCommunication(User $user, $date, $type = false) {
        $event = new ShopEvent();
        $event->addWhereQuery('(`touserid`= '.$user->getId().' OR `fromuserid` = '.$user->getId().')');

        $event->addWhere('cdate', $date, '>');
        if ($type) {
            $event->filterType($type);
        }

        if ($x = $event->getNext()) {
            return $x;
        } else {
            throw new ServiceUtils_Exception();
        }
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return IssueService
     */
    public static function Get() {
        if (!self::$_Instance) {
            $classname = self::$_Classname;
            if ($classname) {
                self::$_Instance = new $classname();
            } else {
                self::$_Instance = new self();
            }
        }
        return self::$_Instance;
    }

    /**
     * Задать класс сервиса.
     * override-метод.
     *
     * @param string $classname
     */
    public static function Set($classname) {
        self::$_Classname = $classname;
        self::$_Instance = null;
    }

    /**
     * Подменяемый объект сервиса
     *
     * @var IssueService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}