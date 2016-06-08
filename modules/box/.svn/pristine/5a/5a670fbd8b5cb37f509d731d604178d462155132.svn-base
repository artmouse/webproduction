<?php
class box_block_client_info_full extends Engine_Class {

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    private function _getOrder() {
        return $this->getValue('order');
    }

    public function process() {

        // получаем заказ
        $order = $this->_getOrder();
        $user = $this->getUser();
        $process = $this->getValue('process');

        // режим box?
        $isBox = Engine::Get()->getConfigFieldSecure('project-box');
        $this->setValue('box', $isBox);

        $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
        $this->setValue('canEdit', $canEdit);

        // когда нажата кнопка Сохранить
        if (!$process && $canEdit && $this->getControlValue('ok')) {

            // обновляем информацию о клиенте
            try{
                $order->setClientname($this->getArgument('clientname'));
            } catch (Exception $eclientname) {

            }

            try {
                $order->setClientaddress($this->getArgument('clientaddress'));
            } catch (Exception $eclientaddress) {

            }

            try {
                $order->setClientphone($this->getArgument('clientphone'));
            } catch (Exception $eclientphone) {

            }

            try {
                $order->setClientemail($this->getArgument('clientemail'));
            } catch (Exception $eclientname) {

            }

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

                }
            } catch (Exception $echangeuser) {

            }


            if ($this->getArgumentSecure('updateUserInfo') && $user->isAllowed('users')) {
                try {
                    $ou = $order->getClient();

                    Shop::Get()->getUserService()->updateUserProfile(
                        $ou,
                        $order->getClientemail(),
                        false,
                        $order->getClientname(),
                        $order->getClientphone(),
                        $order->getClientaddress(),
                        $ou->getBdate(),
                        $ou->getPhones(),
                        $ou->getEmails(),
                        $ou->getUrls(),
                        $ou->getTime(),
                        $ou->getParentid()
                    );
                } catch (ServiceUtils_Exception $use) {
                    try {
                        $ou = Shop::Get()->getUserService()->addClient(
                            $order->getClientname(),
                            false,
                            false,
                            false,
                            false,
                            false,
                            $order->getClientemail(),
                            $order->getClientphone(),
                            $order->getClientaddress()
                        );

                        $order->setUserid($ou->getId());
                    } catch (ServiceUtils_Exception $use2) {

                    }
                }
            }

            // обновляем заказ
            $order->update();

            try {
                Shop::Get()->getShopService()->updateUserInfoByOrder($order->getClient(), $order);

            } catch (Exception $euserInfo) {

            }
        }

        $this->setControlValue('direction', $order->getOutcoming());

        // клиент
        try {
            $u = $order->getClient();
            $this->setValue('orderClientCompany', $u->getTypesex() == 'company' ? true : false);
            $this->setValue('clientID', $u->getId());
            $this->setValue('clientName', $u->makeName());
            $this->setValue('clientURL', $u->makeURLEdit());
        } catch (Exception $e) {

        }

        $this->setControlValue('clientname', $order->getClientname());
        $this->setControlValue('clientemail', $order->getClientemail());
        $this->setControlValue('clientphone', $order->getClientphone());
        $this->setControlValue('clientaddress', $order->getClientaddress());



    }

}