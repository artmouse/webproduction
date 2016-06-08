<?php
class project_add extends Engine_Class {

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

        try {
            $documentsArray = array();

            if ($this->getArgumentSecure('ok')
            || $this->getArgumentSecure('oknext')
            ) {
                try {
                    SQLObject::TransactionStart();

                    $parentid = false;
                    if (preg_match('/^#?([\d]+)/iusD', trim($this->getControlValue('parentid')), $r)) {
                        $parentid = $r[1];
                    }

                    // создаем задачу
                    $issue = IssueService::Get()->addIssue(
                        $this->getUser(),
                        $this->getControlValue('name'),
                        $this->getControlValue('content'),
                        $this->getControlValue('managerid'),
                        $this->getControlValue('workflowid'),
                        $this->getControlValue('dateto'),
                        $this->getControlValue('clientid'),
                        $parentid
                    );

                    // устанавливаем валюту от бизнес-процесса
                    try{
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
                        try {
                            Shop::Get()->getShopService()->updateOrderStatus(
                                $this->getUser(),
                                $issue,
                                $this->getArgumentSecure('statusIdDefaultIssue')
                            );
                        } catch (Exception $e) {

                        }
                    }

                    // Устанавливаем источник.
                    if ($sourceId = $this->getArgument('source')) {
                        $issue->setSourceid($sourceId);
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

        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }
}