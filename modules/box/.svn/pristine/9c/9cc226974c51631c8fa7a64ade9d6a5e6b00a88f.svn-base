<?php
class issue_add extends Engine_Class {

    public function process() {

        PackageLoader::Get()->registerJSFile('/_js/jsPlumb.js');
        $type = $this->getArgumentSecure('type');
        $this->setValue('type', $type);
        $this->setValue('typeName', Shop::Get()->getShopService()->getTypeName($type));

        $user = $this->getUser();

        if ($user->isDenied($type)) {
            // вычисляем путь к шаблону
            $templateName = Engine::Get()->getConfigFieldSecure('shop-template');
            $templatePath = PackageLoader::Get()->getProjectPath().'/templates/'.$templateName.'/';

            $this->setField('filehtml', $templatePath.'/error/error_deny.html');
            $this->setField('filephp', false);
            return;
        }

        if ($this->getArgumentSecure('id')) {

            Engine::Get()->getRequest()->setContentNotFound();
            return;
        }

        try {


            if ($this->getArgumentSecure('ok')
                || $this->getArgumentSecure('oknext')
            ) {
                try {
                    SQLObject::TransactionStart();

                    // собираем описание
                    $content = '';

                    if ($this->getControlValue('content')) {
                        $content .= $this->getControlValue('content')."\n";
                        $content .= "\n";
                    }

                    if ($this->getControlValue('result')) {
                        $content .= "Результат:\n";
                        $content .= $this->getControlValue('result')."\n";
                        $content .= "\n";
                    }

                    if ($this->getControlValue('resource')) {
                        $content .= "Доступные ресурсы:\n";
                        $content .= $this->getControlValue('resource')."\n";
                        $content .= "\n";
                    }

                    $parentid = false;
                    if (preg_match('/^#?([\d]+)/iusD', trim($this->getControlValue('parentid')), $r)) {
                        $parentid = $r[1];
                    }

                    // автоматически ставим менеджером себя, если менеджера нет
                    $managerId = $this->getControlValue('managerid');
                    if (!$managerId) {
                        $managerId = $this->getUser()->getId();
                    }

                    // создаем задачу
                    $issue = IssueService::Get()->addIssue(
                        $this->getUser(),
                        $this->getControlValue('issue_name'),
                        $content,
                        $managerId,
                        $this->getControlValue('workflowid'),
                        $this->getControlValue('dateto'),
                        $this->getControlValue('clientid'),
                        $parentid
                    );

                    // устанавливаем валюту от бизнес-процесса
                    try {
                        if ($this->getControlValue('workflowid')) {
                            $workflow = Shop::Get()->getShopService()->getOrderCategoryByID(
                                $this->getControlValue('workflowid')
                            );

                            if ($workflow->getCurrencyid()) {
                                $issue->setCurrencyid($workflow->getCurrencyid());
                                $issue->update();
                            }
                        }
                    } catch (Exception $e) {

                    }

                    // устанавливаем статус
                    if ($this->getArgumentSecure('statusIdDefaultIssue')) {
                        try{
                            Shop::Get()->getShopService()->updateOrderStatus(
                                $this->getUser(), $issue, $this->getArgumentSecure('statusIdDefaultIssue')
                            );
                        } catch (Exception $e) {

                        }
                    }

                    $cdate = $this->getArgumentSecure('datefrom', 'datetime');
                    if ($cdate) {
                        $issue->setCdate($cdate);
                        $issue->update();
                    }

                    $estimateTime = $this->getArgumentSecure('estimatetime', 'float');
                    if ($estimateTime) {
                        $issue->setEstimate($estimateTime);
                        $issue->update();
                    }

                    $estimateMoney = $this->getArgumentSecure('estimatemoney', 'float');
                    if ($estimateMoney) {
                        $issue->setMoney($estimateMoney);
                        $issue->update();
                    }

                    $issue->update();

                    // назначаем исполнителей
                    $workflow = $issue->getCategory();
                    $status = $workflow->getStatuses();
                    while ($s = $status->getNext()) {
                        $statusID = $s->getId();
                        $employerID = $this->getArgumentSecure('manager_status_'.$statusID);
                        $term = $this->getArgumentSecure('status_term_'.$statusID);
                        if (!$term && $s->getTerm()) {
                            if ($s->getTermperiod()=='hour') {
                                $term = DateTime_Object::Now()->addHour($s->getTerm())->__toString();
                            } elseif ($s->getTermperiod()=='day') {
                                $term = DateTime_Object::Now()->addDay($s->getTerm())->__toString();
                            } elseif ($s->getTermperiod()=='week') {
                                $term = DateTime_Object::Now()->addDay($s->getTerm()*7)->__toString();
                            } elseif ($s->getTermperiod()=='month') {
                                $term = DateTime_Object::Now()->addMonth($s->getTerm())->__toString();
                            }

                        }

                        if ($statusID && ($employerID || $term)) {
                            $oes = new XShopOrderEmployer();
                            $oes->setOrderid($issue->getId());
                            $oes->setManagerid($employerID);
                            $oes->setStatusid($statusID);
                            $oes->setTerm($term);
                            $oes->insert();
                        }
                    }

                    // записываем письмо как комментарий к задаче
                    $eventID = $this->getArgumentSecure('eventid');
                    if ($eventID) {
                        $event = EventService::Get()->getEventByID($eventID);

                        try {
                            $contactFrom = $event->getFromContact();
                        } catch (Exception $e) {
                            $contactFrom = $this->getUser();
                        }

                        $fileIDArray = array();
                        $files = $event->getAttachmentFiles();
                        while ($file = $files->getNext()) {
                            // копируем файл
                            $fileCopy = Shop::Get()->getFileService()->copyFile(
                                $file,
                                $contactFrom
                            );
                            $fileIDArray[] = $fileCopy->getId();
                        }

                        if ($event->getType() == 'call') {
                            // по полю from определяем юзера
                            try {
                                $tmp = $event->getFromContact();

                                $nameFrom = $tmp->makeName(false);
                            } catch (Exception $e) {
                                $nameFrom = false;
                            }

                            // по полю to определяем юзера
                            try {
                                $tmp = $event->getToContact();

                                $nameTo = $tmp->makeName(false);
                            } catch (Exception $e) {
                                $nameTo = false;
                            }

                            if ($nameFrom) {
                                $content = $nameFrom.' Позвонил ';
                            } else {
                                $content = $event->getFrom().' Позвонил ';
                            }

                            if ($nameTo) {
                                $content.= $nameTo;
                            } else {
                                $content.= $event->getTo();
                            }

                            $content.= "\n".$event->getFrom().' → '.$event->getTo();
                            $content.= "\nСтатус: ".$event->getStatus();
                            $content.= "\nКанал: ".$event->getChannel();
                            $content.= "\n".$event->getCdate();
                            $content.= "\n\n".Engine_URLParser::Get()->getHost().$event->makeURL();

                            Shop::Get()->getShopService()->addOrderComment(
                                $issue,
                                $contactFrom,
                                $content
                            );

                        } else {
                            Shop::Get()->getShopService()->addOrderEmail(
                                $issue,
                                $contactFrom,
                                $event->getSubject()."\n\n".$event->getContent(),
                                $event->getAttachmentFileIDArray()
                            );
                        }
                    }

                    SQLObject::TransactionCommit();

                    $this->setValue('message', 'ok');
                    $this->setValue('messageIssueInfo', array('id' => $issue->getId(), 'url' => $issue->makeURLEdit()));

                    if ($this->getArgumentSecure('ok')) {
                        $this->setValue('urlredirect', $issue->makeURLEdit());
                    } else {
                        $this->setValue('clearFields', true);
                    }
                } catch (Exception $ge) {
                    SQLObject::TransactionRollback();

                    $this->setValue('message', 'error');
                }
            }

            try {
                $eventID = $this->getArgument('eventid');
                $events = EventService::Get()->getEventsAll();
                $events->setId($eventID);

                $block = Engine::GetContentDriver()->getContent('event-list-block');
                $block->setValue('events', $events);
                $block->setValue('showhidden', true);
                $block->setValue('noFilter', true);
                $this->setValue('block_event', $block->render());
            } catch (Exception $eventEx) {

            }

            // менеджеры
            $user = $this->getUser();
            $this->setValue('userId', $user->getId());
            $managers = Shop::Get()->getUserService()->getUsersManagers($user);
            $a = array();
            if ( $this->getControlValue('managerid') ) {
                $selectedManagerId = $this->getControlValue('managerid');
            } else {
                $selectedManagerId = $user->getId();
            }

            while ($x = $managers->getNext()) {
                $selected = false;
                if ($selectedManagerId == $x->getId()) {
                    $selected = true;
                }
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'selected' => $selected
                );
            }
            $this->setValue('managerArray', $a);

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
            
            // список источников
            $source = Shop::Get()->getShopService()->getSourceAll();
            $a = array();
            while ($x = $source->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                );
            }
            $this->setValue('sourceArray', $a);

            // бизнес-процессы
            $workflows = Shop::Get()->getShopService()->getWorkflowsActive($this->getUser());
            $workflows->setType($type);
            $a = array();
            while ($x = $workflows->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                );
            }
            $this->setValue('workflowArray', $a);

            $dedaultUserId = $this->getArgumentSecure('clientid');
            if ($dedaultUserId) {
                try {
                    $defaultUser = Shop::Get()->getUserService()->getUserByID($dedaultUserId);
                    $this->setControlValue('clientname', $defaultUser->makeName(false));
                    $this->setControlValue('clientid', $defaultUser->getId());
                } catch (Exception $ue) {

                }
            }

        } catch (Exception $ge) {

            LogService::Get()->add();
            Engine::Get()->getRequest()->setContentServerError();
            return;

        }
    }

}