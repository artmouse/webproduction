<?php

class orders_contacts extends Engine_Class {

    public function process() {     
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            $user = $this->getUser();

            // заголовок страницы
            Engine::GetHTMLHead()->setTitle($order->makeName());

            $this->setValue('orderid', $order->getId());
            $this->setValue('orderName', $order->makeName());

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'contacts');
            $this->setValue('block_menu', $menu->render());

            $login = Shop::Get()->getSettingsService()->getSettingValue('sms-login');
            $pass = Shop::Get()->getSettingsService()->getSettingValue('sms-password');
            $sender = Shop::Get()->getSettingsService()->getSettingValue('sms-sender');
            if ($sender && $login && $pass) {
                $this->setValue('canSMS', true);
            }
            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            $this->setValue('canEdit', $canEdit);

            if ($this->getArgumentSecure('ok')) {

                // с селекта
                $clientIDArray = array();
                if ($this->getArgumentSecure('clientid')) {
                    $clientIDArray = explode(',', $this->getArgumentSecure('clientid'));
                }

                foreach ($clientIDArray as $item) {
                    $contact = new XShopOrderContacts();
                    $contact->setOrderid($order->getId());
                    $contact->setUserid($item);
                    if (!$contact->select()) {
                        $contact->insert();
                    }
                }

                // комментарии
                foreach ($this->getArguments() as $key => $item) {
                    if (strpos($key, 'comment') === 0) {
                        try {
                            $userid = str_replace('comment', '', $key);
                            $contact = new XShopOrderContacts();
                            $contact->setOrderid($order->getId());
                            $contact->setUserid($userid);
                            $contact->select();
                            $contact->setComment(trim($item));
                            $contact->update();
                        } catch (Exception $e) {
                            
                        }
                    }
                }

                $this->setValue('message', 'ok');
            }
            
            if ($this->getArgumentSecure('delete-project-users')) {
                if (preg_match_all("/(\d+)/ius", $this->getArgumentSecure('moveids'), $r)) {
                    $activeUserId = Shop::Get()->getUserService()->getUser()->getId();
                    foreach ($r[1] as $userID) {
                        try {
                            // если это не текущий пользователь
                            if ($activeUserId != $userID) {
                                $userProject = new XShopOrderContacts();
                                $userProject->setOrderid($order->getId());
                                $userProject->setUserid($userID);
                                $up = $userProject->getNext();
                                if ($up) {
                                    $up->delete();
                                }                               
                            }
                        } catch (Exception $pe) {

                        }
                    }
                }
            }
            
            $list = Engine::GetContentDriver()->getContent('contact-list');
            $list->setValue('isProjectContacts', true);
            $users = new XShopOrderContacts();
            $users->setOrderid($order->getId());
            $usersIdArray = array();
            while ($x = $users->getNext()) {
                $usersIdArray[] = $x->getUserid();
            }
            if ($usersIdArray) {
                $users = Shop::Get()->getUserService()->getUsersAll();
                $users->addWhereArray($usersIdArray, 'id');
                $list->setValue('users', $users);
                $this->setValue('block_users', $list->render());
            }
        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}