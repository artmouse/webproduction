<?php
class action_block_notification_sms_clients_all extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('text_notify_sms_clients_all', $data['text']);
    }

    public function processData() {
        $index = $this->getValue('index');

        $status = $this->_getStatus();
        $status->setSms($this->getArgumentSecure($index.'_text_notify_sms_clients_all'));
        $status->update();

        $data = array(
            'text' => $this->getArgumentSecure($index.'_text_notify_sms_clients_all')
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }

    public function processDataDelete() {
        $status = $this->_getStatus();
        $status->setSms('');
        $status->update();
    }

    public function processStatus(Events_Event $event) {
        $order = $this->_getOrder($event);
        $data = (Array) json_decode($this->getValue('data'));

        $arrayPhone = array();
            
        $orderClients = new XShopOrderContacts();
        $orderClients->setOrderid($order->getId());
        while ($or = $orderClients->getNext()) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($or->getUserid());
                if ($user->getPhoneSMS()) {
                    $arrayPhone[] = $user->getPhoneSMS();
                }
            } catch (Exception $ex) {

            }
        }
        
        if (!$arrayPhone) {
            return;
        }

        // получаем шаблон
        $tpl = $data['text'];
        if (!$tpl) {
            return;
        }

        // формируем письмо
        $html = Shop::Get()->getShopService()->makeOrderTemplate($order, $tpl);

        // отправляем SMS
        try {
            $user = $this->_getUser($event);
            
            foreach ($arrayPhone as $phone) {
                try {
                    Shop::Get()->getUserService()->sendSMS(
                        $phone,
                        $html,
                        $user
                    ); 
                } catch (Exception $ex) {
                    
                }
                
            }

            $comment = trim(strip_tags($html));
            $comment .= "\n\n";
            $comment .= Shop::Get()->getTranslateService()->getTranslateSecure(
                'translate_otpravleno_sms_na_nomera_vseh_klientov_dannogo_bp'
            );

            // после того как письмо отправлено,
            // добавляем его в комментарий к order'y
            Shop::Get()->getShopService()->addOrderSMS(
                $order,
                $user,
                $comment
            );
        } catch (Exception $smsEx) {

        }
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
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

}