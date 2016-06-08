<?php
class orders_employer extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            $user = $this->getUser();

            $this->setValue('orderid', $order->getId());
            $this->setValue('orderName', $order->makeName());

            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure(
                    'translate_ispolniteli_zakaza_'
                ).$order->makeName()
            );

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'employer');
            $this->setValue('block_menu', $menu->render());

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            $this->setValue('canEdit', $canEdit);

            // сохранение
            if ($this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    // удаляем все записи
                    $oes = new XShopOrderEmployer();
                    $oes->setOrderid($order->getId());
                    while ($x = $oes->getNext()) {
                        $x->delete();
                    }

                    // вставляем новые
                    $args = $this->getArguments();
                    foreach ($args as $key => $value) {
                        if (preg_match("/^manager(\d+)$/ius", $key, $r)) {
                            $index = $r[1];

                            if (!$this->getArgumentSecure('manager'.$index) && 
                                !$this->getArgumentSecure('status'.$index)) {
                                continue;
                            }

                            $oes = new XShopOrderEmployer();
                            $oes->setOrderid($order->getId());
                            $oes->setManagerid($this->getArgumentSecure('manager'.$index, 'int'));
                            $oes->setSum($this->getArgumentSecure('sum'.$index, 'float'));
                            $oes->setPercent($this->getArgumentSecure('percent'.$index, 'float'));
                            $oes->setRole($this->getArgumentSecure('role'.$index));
                            $oes->setStatusid($this->getArgumentSecure('status'.$index, 'int'));
                            $oes->setTerm($this->getArgumentSecure('term'.$index));
                            $oes->insert();
                        }
                    }

                    SQLObject::TransactionCommit();

                    $this->setValue('message', 'ok');
                } catch (Exception $e) {
                    SQLObject::TransactionRollback();

                    $this->setValue('message', 'error');
                }
            }

            $oes = new XShopOrderEmployer();
            $oes->setOrderid($order->getId());
            $a = array();
            $totalAll = 0;
            while ($x = $oes->getNext()) {
                $total = 0;
                $total += $x->getSum();
                $total += round($x->getPercent()/100*$order->getSum(), 2);
                $total = round($total, 2);

                $totalAll += $total;

                $a[] = array(
                'managerid' => $x->getManagerid(),
                'role' => htmlspecialchars($x->getRole()),
                'sum' => $x->getSum(),
                'percent' => $x->getPercent(),
                'total' => $total,
                'statusid' => $x->getStatusid(),
                'term' => $x->getTerm() != '0000-00-00 00:00:00' ? $x->getTerm():false
                );
            }

            for ($j = 0; $j < 10; $j++) {
                $a[] = array();
            }

            $this->setValue('employerArray', $a);

            // список менеджеров
            $users = Shop::Get()->getUserService()->getUsersManagers();
            $a = array();
            while ($x = $users->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                );
            }
            $this->setValue('managerArray', $a);

            $this->setValue('sum', $order->getSum());
            $this->setValue('sumWithoutTax', number_format($order->makeSumWithoutTax(), 2));
            $this->setValue('employerSum', $totalAll);
            $this->setValue('currency', $order->getCurrency()->getSymbol());

            // этапы заказа
            try {
                $status = $order->getCategory()->getStatuses();
                $a = array();
                while ($x = $status->getNext()) {
                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    );
                }
                $this->setValue('statusArray', $a);
            } catch (Exception $e) {

            }
            
            // выводим все роли деревом            
            $role = array();
            $roleAraay = RoleService::Get()->makeRoleListArray(); 
            foreach ($roleAraay as $x) {
                $role[] = array(
                    'name' => $x['name'],
                    'level' => $x['level']
                );
            }
            $this->setValue('roleArray', $role);
            
            

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}