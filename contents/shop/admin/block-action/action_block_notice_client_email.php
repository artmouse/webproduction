<?php
class action_block_notice_client_email extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));

        $this->setValue('type', $data['type']);
        $this->setValue('signature', $data['signature']);
        $this->setValue('userSignature', $data['userSignature']);
        $this->setValue('subject', $data['subject']);
        $this->setValue('email', $data['email']);
        $this->setValue('text', $data['text']);
        $this->setValue('html', $data['html']);

        $filesArray = false;

        $filesDataArray = $data['fileIdArray'];
        if ($filesDataArray) {
            foreach ($filesDataArray as $fileId) {
                try {
                    $file = Shop::Get()->getFileService()->getFileByID($fileId);

                    $filesArray[] = array(
                        'name' => $file->getName(),
                        'type' => $file->getContenttype(),
                        'tmp_name' => $file->makePath(),
                        'url' => $file->makeURL(),
                        'id' => $file->getId()
                    );

                } catch (Exception $efile) {

                }
            }
        }

        $this->setValue('filesArray', $filesArray);

        $this->setValue('box', Shop_ModuleLoader::Get()->isModuleInModulesArray('box'));
    }

    public function processData() {
        $index = $this->getValue('index');

        $filesArray = $this->getArgumentSecure($index.'_fileId');

        $filesDelete = $this->getArgumentSecure($index.'_deleteFileId');

        if ($filesDelete) {
            foreach ($filesDelete as $fileDelId) {
                $key = array_search($fileDelId, $filesArray);
                if ($key !== false) {
                    unset($filesArray[$key]);
                }
            }
        }

        $data = array(
            'type' => $this->getArgumentSecure($index.'_type'),
            'signature' => $this->getArgumentSecure($index.'_signature'),
            'subject' => trim($this->getArgumentSecure($index.'_subject')),
            'email' => trim($this->getArgumentSecure($index.'_email')),
            'text' => $this->getArgumentSecure($index.'_text'),
            'html' => $this->getArgumentSecure($index.'_html'),
            'ordercomment' => $this->getArgumentSecure($index.'_ordercomment'),
            'userSignature' => $this->getArgumentSecure($index.'_userSignature'),
            'fileIdArray' => $filesArray
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }

    public function processStatus(Events_Event $event) {

        $order = $this->_getOrder($event);

        $clientEmail = $order->getClientemail();

        if (!$clientEmail) {
            try {
                $clientEmail = $order->getClient()->getEmail();
            } catch (Exception $emailEx) {

            }
        }

        if (!$clientEmail) {
            return;
        }

        $data = (Array) json_decode($this->getValue('data'));

        // получаем шаблон
        $tpl = $data['text'];
        if (!$tpl) {
            return;
        }

        $client = false;
        try {
            $client = $order->getClient();
        } catch (Exception $eclient) {

        }

        $tpl = Shop::Get()->getShopService()->emailVariableReplace($order, $client, $tpl);

        // формируем письмо
        $html = Shop::Get()->getShopService()->makeOrderTemplate($order, $tpl);

        // убираем из него subject
        if ($data['subject']) {
            $subject = $data['subject'];
        } elseif (preg_match("/Subject\:\s*(.+?)\n/iu", $html, $r)) {
            $subject = trim(strip_tags($r[1]));
            $html = trim(preg_replace("/Subject\:\s*(.+?)\n/iu", '', $html, 1));
        } else {
            $subject = false;
        }

        $subject = Shop::Get()->getShopService()->emailVariableReplace($order, $client, $subject);

        // обратный емейл
        $emailFrom = $data['email'];
        if (!$emailFrom) {
            $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
        }

        $signatureUser = false;
        if ($data['signature']) {
            try {
                $signatureUser = $order->getManager();
            } catch (Exception $emanager) {

            }
        }

        $template = false;
        if ($data['html']) {
            $template = Shop::Get()->getShopService()->getMailTemplate();
        }

        $filesArray = array();

        $filesDataArray = $data['fileIdArray'];
        if ($filesDataArray) {
            foreach ($filesDataArray as $fileId) {
                try {
                    $file = Shop::Get()->getFileService()->getFileByID($fileId);

                    $filesArray[] = array(
                        'name' => $file->getName(),
                        'type' => $file->getContenttype(),
                        'tmp_name' => $file->makePath()
                    );

                } catch (Exception $efile) {

                }
            }
        }

        // отправляем письмо
        if ($clientEmail && Checker::CheckEmail($emailFrom) && ($subject || $html) ) {
            Shop::Get()->getUserService()->sendEmail(
                $emailFrom,
                $clientEmail,
                $subject,
                $html,
                $data['type'],
                $filesArray,
                $template,
                $signatureUser,
                false,
                true,
                @$data['userSignature']
            );
        }


        $user = $this->_getUser($event);

        $comment = trim(strip_tags($html));
        $comment .= "\n\n";
        $comment .= "Отправлено на email {$clientEmail} от email {$emailFrom}";
        $comment .= " с темой ".$subject;

        // после того как письмо отправлено,
        // добавляем его в комментарий к order'y
        Shop::Get()->getShopService()->addOrderEmail(
            $order,
            $user,
            $comment
        );
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

    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

}