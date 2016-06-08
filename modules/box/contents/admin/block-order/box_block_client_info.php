<?php
class box_block_client_info extends Engine_Class {

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    private function _getOrder() {
        return $this->getValue('order');
    }

    public function process() {
        try {
            // получаем заказ
            $order = $this->_getOrder();
            $user = $this->getUser();
            $process = $this->getValue('process');

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            $this->setValue('canEdit', $canEdit);

            if (!$process && $canEdit && $this->getArgumentSecure('ok')) {
                try{
                    $newUserID = $this->getArgument('changeuser');

                    try {
                        $newUser = Shop::Get()->getUserService()->getUserByID($newUserID);

                        Shop::Get()->getShopService()->updateOrderUser($order, $user, $newUser);

                        Engine::GetURLParser()->setArgument('clientname', $newUser->makeName(false));
                        Engine::GetURLParser()->setArgument('clientaddress', $newUser->getAddress());
                        Engine::GetURLParser()->setArgument('clientphone', $newUser->getPhone());
                        Engine::GetURLParser()->setArgument('clientemail', $newUser->getEmail());
                    } catch (Exception $e) {
                        Shop::Get()->getShopService()->updateOrderUser($order, $user, false);
                    }

                } catch (Exception $euser) {
                    // обновляем информацию о клиенте
                    try{
                        $order->setClientname($this->getArgument('clientname'));
                    } catch (Exception $eclientname) {

                    }

                    try{
                        $order->setClientaddress($this->getArgument('clientaddress'));
                    } catch (Exception $eclientaddress) {

                    }

                    try{
                        $order->setClientphone($this->getArgument('clientphone'));
                    } catch (Exception $eclientphone) {

                    }

                    try{
                        $order->setClientemail($this->getArgument('clientemail'));
                    } catch (Exception $eclientemail) {

                    }
                    
                }


                // обновляем менеджера заказа
                try{
                    $managerId = $this->getArgument('manager');
                    try {
                        $manager = Shop::Get()->getUserService()->getUserByID(
                            $managerId
                        );

                        Shop::Get()->getShopService()->updateOrderManager($order, $this->getUser(), $manager);
                    } catch (Exception $e) {
                        // убираем менеджера заказа
                        Shop::Get()->getShopService()->updateOrderManager($order, $this->getUser(), 0);
                    }
                } catch (Exception $emanager) {

                }


                // смена менеджера со стороны клиента
                try {
                    $newClientManagerID = $this->getArgument('changeclientmanager');
                    $newClientManager = Shop::Get()->getUserService()->getUserByID($newClientManagerID);

                    $order->setClientmanagerid($newClientManager->getId());
                } catch (Exception $echangeclientmanager) {

                }

                $order->update();

                try {
                    Shop::Get()->getShopService()->updateUserInfoByOrder($order->getClient(), $order);

                } catch (Exception $euserInfo) {

                }
            }

            if (Engine::Get()->getConfigFieldSecure('oneclick-enable')) {
                $this->setValue('oneclickEnable', true);
            }

            // клиент
            try {
                $client = $order->getClient();
                $this->setValue('orderClientCompany', $client->getTypesex() == 'company' ? true : false);
                $this->setValue('clientID', $client->getId());
                $this->setValue('clientName', $client->makeName());
                $this->setValue('clientURL', $client->makeURLEdit());


                // дополнительные поля контактов
                $groups = $client->getGroups();
                $groupIDArray = array(0);
                while ($x = $groups->getNext()) {
                    $groupIDArray[] = $x->getId();
                }

                $contactType = 'company';
                if ($client->getTypesex() == 'man' || $client->getTypesex() == 'woman' || !$client->getTypesex()) {
                    $contactType = 'person';
                }

                $contactTypeArray = array(
                    '',
                    'all',
                    $contactType
                );

                $userField = new XShopContactField();
                $userField->setShowinorder(1);
                $userField->setHidden(0);
                $userField->setGroupByQuery('idkey');
                $userField->addWhereArray($groupIDArray, 'groupid');
                $userField->addWhereArray($contactTypeArray, 'typecontact');
                $userField->filterType('system', '!=');

                $userFieldArray = array();
                while ($u = $userField->getNext()) {

                    $userCustom = new XShopCustomField();
                    $userCustom->setObjecttype(get_class($client));
                    $userCustom->setObjectid($client->getId());
                    $userCustom->setKey($u->getIdkey());
                    $userCustom = $userCustom->getNext();
                    if ($userCustom && $userCustom->getValue()) {
                        $userFieldArray[] = array(
                            'name' => $u->getName(),
                            'key' => $u->getIdkey(),
                            'value' => $userCustom->getValue()
                        );
                    }

                }
                $this->setValue('customFieldArray', $userFieldArray);
            } catch (Exception $e) {

            }

            // менеджер на стороне клиента
            try {
                $u = Shop::Get()->getUserService()->getUserByID($order->getClientmanagerid());
                $this->setValue('clientManagerID', $u->getId());
                $this->setValue('clientManagerName', $u->makeName(true, 'lfm'));
                $this->setValue('clientManagerURL', $u->makeURLEdit());
            } catch (Exception $e) {

            }

            // кто менеджер заказа
            try {
                $u = $order->getManager();
                $this->setValue('managerID', $u->getId());
                $this->setValue('managerName', $u->makeName(true, 'lfm'));
                $this->setValue('managerURL', $u->makeURLEdit());
            } catch (Exception $e) {

            }

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

            $this->setControlValue('clientname', $order->getClientname());
            $this->setControlValue('clientemail', $order->getClientemail());
            $this->setControlValue('clientphone', $order->getClientphone());
            $this->setControlValue('clientaddress', htmlspecialchars($order->getClientaddress()));

            $this->setValue('sum', $order->makeSum());
            $this->setValue('orderCurrency', $order->getCurrency()->getSymbol());
            // если подключен модуль Финансы
            // добавляем счета
            if (Shop_ModuleLoader::Get()->isImported('finance')) {
                $this->setValue('finance', true);

                // сколько оплачено и баланс
                $paymentSum = $order->makeSumPaid();
                $this->setValue('paymentSum', $paymentSum);

                $paymentBalance = $order->makeSumBalance();
                $this->setValue('paymentBalance', $paymentBalance);
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}