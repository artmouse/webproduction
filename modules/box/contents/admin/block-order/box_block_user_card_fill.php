<?php
class box_block_user_card_fill extends Engine_Class {

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

        try {
            $client = $order->getClient();
        } catch (Exception $eclient) {
            $client = false;
        }

        $process = $this->getValue('process');

        $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
        $this->setValue('canEdit', $canEdit);

        // когда нажата кнопка Сохранить
        if (!$process && $canEdit && $this->getControlValue('ok')) {

            $order->setClientname($this->getControlValue('clientNameFill'));
            $order->setClientemail($this->getControlValue('clientEmailFill'));
            $order->setClientphone($this->getControlValue('clientPhoneFill'));
            $order->setClientaddress($this->getControlValue('clientAddressFill'));

            // обновляем заказ
            $order->update();

            // обновляем данные клиента
            if ($client) {
                $clientUpdate = false;
                if (!$client->getName() && $client->getTypesex() != 'company'
                    && $this->getControlValue('clientNameFill')
                ) {
                    $clientUpdate = true;
                    $client->setName($this->getControlValue('clientNameFill'));
                }

                if (!$client->getEmail() && $this->getControlValue('clientEmailFill')) {
                    $clientUpdate = true;
                    $client->setEmail($this->getControlValue('clientEmailFill'));
                }

                if (!$client->getPhone() && $this->getControlValue('clientPhoneFill')) {
                    $clientUpdate = true;
                    $client->setPhone($this->getControlValue('clientPhoneFill'));
                }

                if (!$client->getAddress() && $this->getControlValue('clientAddressFill')) {
                    $clientUpdate = true;
                    $client->setAddress($this->getControlValue('clientAddressFill'));
                }

                if ($clientUpdate) {
                    $client->update();
                }

            }

        }

        $clientName = $order->getClientname();
        if (!$clientName && $client) {
            try{
                $clientName = $client->getName();
            } catch (Exception $ename) {

            }
        }
        $this->setControlValue('clientNameFill', $clientName);

        $clientPhone = $order->getClientphone();
        if (!$clientPhone && $client) {
            try{
                $clientPhone = $client->getPhone();
            } catch (Exception $ephone) {

            }
        }
        $this->setControlValue('clientPhoneFill', $clientPhone);

        $clientAddress = $order->getClientaddress();
        if (!$clientAddress && $client) {
            try{
                $clientAddress = $client->getAddress();
            } catch (Exception $eaddress) {

            }
        }
        $this->setControlValue('clientAddressFill', $clientAddress);

        $clientEmail = $order->getClientemail();
        if (!$clientEmail && $client) {
            try{
                $clientEmail = $client->getEmail();
            } catch (Exception $eemail) {

            }
        }
        $this->setControlValue('clientEmailFill', $clientEmail);

    }

}