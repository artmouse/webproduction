<?php
class block_callback extends Engine_Class {

    public function process() {
        // прием заказного звонка
        if ($this->getArgumentSecure('call')) {
            try {
                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }
                if (!$this->getControlValue('cbphone')) {
                    throw new ServiceUtils_Exception('phone');
                }

                try {
                    $user = $this->getUser();
                } catch (Exception $e) {
                    $user = Shop::Get()->getUserService()->addUserClient(
                        $this->getControlValue('cbname'),
                        $this->getControlValue('cbnamelast'),
                        $this->getControlValue('cbnamemiddle'),
                        false, // typesex
                        false, // company
                        false, // post
                        false, // email
                        $this->getControlValue('cbphone')
                    );
                }

                $fullname =  $this->getControlValue('cbnamelast')." ".
                    $this->getControlValue('cbname')." ".$this->getControlValue('cbnamemiddle');

                $url = Engine::Get()->getProjectURL().Engine_URLParser::Get()->getTotalURL();

                Shop::Get()->getCallbackService()->addCallback(
                    $fullname,
                    $this->getControlValue('cbphone'),
                    $this->getControlValue('cbanswer'),
                    $user,
                    $url
                );

                // добавляем комментарий в заказ
                $orders = Shop::Get()->getShopService()->getOrdersAll();
                $orders->setUserid($user->getId());
                $orders->setIssue(0);
                $orders->setDateclosed('0000-00-00 00:00:00');
                $ok = false;
                while ($x = $orders->getNext()) {
                    $ok = true;
                    Shop::Get()->getShopService()->addOrderComment(
                        $x,
                        $user,
                        Shop::Get()->getTranslateService()->getTranslateSecure(
                            'translate_klient_poprosil_perezvonit_emu_'
                        ).$this->getControlValue('cbanswer').
                        "\nФ.И.О.: ".$fullname."\nТелефон: ".$this->getControlValue('cbphone').
                        "\nСо страницы: ".$url,
                        false,
                        false
                    );
                    break;
                }

                if (!$ok) {
                    // создаем новый заказ
                    $order = Shop::Get()->getShopService()->makeOrderEmpty($user);
                    $order->setUserid($user->getId());
                    $order->setClientname($user->makeName(false, 'lfm'));
                    $order->setClientphone($user->getPhone());
                    $order->setClientemail($user->getEmail());
                    $order->setClientaddress($user->getAddress());
                    $order->update();

                    Shop::Get()->getShopService()->addOrderComment(
                        $order,
                        $user,
                        Shop::Get()->getTranslateService()->getTranslateSecure(
                            'translate_klient_poprosil_perezvonit_emu_'
                        ).$this->getControlValue('cbanswer').
                        "\nФ.И.О.: ".$fullname."\nТелефон: ".
                        $this->getControlValue('cbphone')."\nСо страницы: ".$url,
                        false,
                        false
                    );
                }

                $this->setValue('callmessage', 'ok');
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('callmessage', 'error');
                $this->setValue('callerrorsArray', $e->getErrorsArray());
                return;
            }
        }

        // заполняем по умолчанию данными форму callback'a
        try {
            $u = $this->getUser();

            if (!$this->getValue('feedbackmessage') && $u ) {
                $this->setControlValue('cbname', $u->getName());
                $this->setControlValue('cbnamelast', $u->getNamelast());
                $this->setControlValue('cbnamemiddle', $u->getNamemiddle());
                $this->setControlValue('cbphone', $u->getPhone());
            }
        } catch (Exception $e) {

        }
    }

}