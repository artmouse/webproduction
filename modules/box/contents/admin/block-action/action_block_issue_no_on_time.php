<?php
class action_block_issue_no_on_time extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));

        $this->setValue('time', $data['time']);
        $this->setValue('manager', $data['manager']);
        $this->setValue('workflow', $data['workflow']);

        $text = $data['text'];
        if (!$text) {
            $text = "Крайний срок задачи #[orderid] был определен [dateto].".''.
            "Просьба принять соответствующие действия для выполнения задачи!";
        }
        $this->setValue('text', $text);

        $name = $data['name'];
        if (!$name) {
            $name = "Просрочка задачи [orderid]";
        }
        $this->setValue('name', $name);


        $managers = Shop::Get()->getUserService()->getUsersManagers();

        $managerArray = array();
        while ($x = $managers->getNext()) {
            $managerArray[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(false, 'lfm')
            );
        }
        $this->setValue('managerArray', $managerArray);

        $workflows = WorkflowService::Get()->getWorkflowsAll();

        $workflowArray = array();
        while ($x = $workflows->getNext()) {
            $workflowArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );
        }
        $this->setValue('workflowArray', $workflowArray);
    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'manager' => $this->getArgumentSecure($index.'_manager'),
            'workflow' => $this->getArgumentSecure($index.'_workflow'),
            'time' => $this->getArgumentSecure($index.'_time'),
            'text' => $this->getArgumentSecure($index.'_text'),
            'name' => $this->getArgumentSecure($index.'_name'),
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }

    public function processCronHour(Events_Event $event) {
        $event;

        $status = $this->_getStatus();

        $data = (Array) json_decode($this->getValue('data'));

        $hour = (int) $data['time'];
        $workflow = (int) $data['workflow'];
        $manager = (int) $data['manager'];
        $text = $data['text'];
        $name = $data['name'];

        if (!$hour || !$workflow || !$manager) {
            return;
        }

        $now = DateTime_Object::Now();

        // получить задачи с контролируемым этапом
        $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $orders->filterDateclosed('0000-00-00 00:00:00');
        $orders->filterStatusid($status->getId());
        $orders->addWhere('dateto', '0000-00-00 00:00:00', '<>');
        $orders->addWhere('dateto', $now->addHour($hour*(-1))->__toString(), '<');
        $orders->addWhere('dateto', $now->addHour($hour*(-50))->__toString(), '>');

        while ($order = $orders->getNext()) {
            try {
                $tmpOrders = Shop::Get()->getShopService()->getOrdersAll(false, true);
                $tmpOrders->setLinkkey('subissue-no-on-time-'.$order->getId());
                if ($tmpOrders->getNext()) {
                    continue;
                }

                $name = str_replace('[orderid]', $order->getId(), $name);
                $name = str_replace('[dateto]', $order->getDateto(), $name);
                $name = str_replace(
                    '[hour]',
                    DateTime_Differ::DiffHour($now, DateTime_Object::FromString($order->getDateto())),
                    $name
                );

                $text = str_replace('[orderid]', $order->getId(), $text);
                $text = str_replace('[dateto]', $order->getDateto(), $text);
                $text = str_replace(
                    '[hour]',
                    DateTime_Differ::DiffHour($now, DateTime_Object::FromString($order->getDateto())),
                    $text
                );


                // задача не найдена, создаем ее
                $newOrder = Shop::Get()->getShopService()->addOrder(
                    Shop::Get()->getUserService()->getUserByID($manager),
                    $name,
                    $text,
                    $manager,
                    $workflow,
                    false,
                    $order->getManagerid(),
                    $order->getId()
                );

                $newOrder->setLinkkey('subissue-no-on-time-'.$order->getId());
                $newOrder->update();

            } catch (Exception $emanager) {

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

}