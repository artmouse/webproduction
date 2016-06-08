<?php
class action_block_sub_workflow extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = json_decode($this->getValue('data'));
        $this->setValue('subworkflowId', $data->id);
        $this->setValue('subName', $data->name);
        $this->setValue('subDate', $data->date);
        $this->setValue('subDescription', $data->description);
        // список workflow
        $status = $this->_getStatus();

        $workflow = Shop::Get()->getShopService()->getOrderCategoryAll();
        if ($status->getDefault()) {
            $workflow->addWhere('id', $status->getCategoryid(), '<>');
        }
        $a = array();
        while ($x = $workflow->getNext()) {
            $a[$x->getId()] = $x->makeName();
        }
        $this->setValue('workflowArray', $a);
    }

    public function processData() {
        $index = $this->getValue('index');

        $subWorkflowName = $this->getArgument($index.'_subName');
        $subWorkflowID = $this->getArgument($index.'_subworkflowId');
        $subWorkflowDate = $this->getArgument($index.'_subDate');
        $subWorkflowDescription = $this->getArgument($index.'_subDescription');

        // для новой таблицы
        $blockDataArray = array(
            'id' => $subWorkflowID,
            'name' => $subWorkflowName,
            'date' => $subWorkflowDate,
            'description' => $subWorkflowDescription,
        );


        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($blockDataArray)
        );
    }

    public function processStatus(Events_Event $event) {
        $this->processCount++;

        if ($this->processCount > 100) {
            throw new ServiceUtils_Exception('process_recursion_add_issue');
        }

        $order = $this->_getOrder($event);
        $user = $this->_getUser($event);
        $status = $this->_getStatus();

        $statusSub = json_decode($this->getValue('data'));

        $subWorkflowID = $statusSub->id;
        $subWorkflowName = $statusSub->name;
        $subWorkflowDate = $statusSub->date;
        $subWorkflowDescription = $statusSub->description;

        if (!$subWorkflowID) {
            return;
        }

        $subWorkflow = Shop::Get()->getShopService()->getOrderCategoryByID($subWorkflowID);

        $subIssue = new ShopOrder();
        $subIssue->setName($subWorkflowName);
        $subIssue->setParentid($order->getId());
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
            $employer->setOrderid($order->getId());
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
                $subWorkflowManagerID = $order->getManagerid();
            }

            // имя новой задачи
            $name = $subWorkflowName;
            if (!$name) {
                $name = $subWorkflow->getIssuename();
            }
            if (!$name) {
                $name = $subWorkflow->getName();
            }
            $name = str_replace('[IssueName]', $order->getName(), $name);

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
                $order->getUserid(),
                $order->getId()
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

    }

    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

    /**
     * Обертка
     *
     * @param Shop_Event_Order $event
     *
     * @return ShopOrder
     */
    private function _getOrder($event) {
        return $event->getOrder();
    }

    /**
     * Обертка
     *
     * @param Shop_Event_Order $event
     *
     * @return User
     */
    private function _getUser($event) {
        return $event->getUser();
    }

    public $processCount = 0;

}