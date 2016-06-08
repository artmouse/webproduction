<?php
class action_block_client_notification_payment extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('text_notify_email_client', $data['text']);
        $this->setValue('html', $data['html']);
        $this->setValue('subject', $data['subject']);
        $this->setValue('email', $data['email']);
        $this->setValue('virtual', $data['virtual']);
        $this->setValue('signature', $data['signature']);
        $this->setValue('type', $data['type']);
        $this->setValue('userSignature', $data['userSignature']);

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

        $status = $this->_getStatus();
        $status->setMessage($this->getArgumentSecure($index.'_text_notify_email_client'));
        $status->update();

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

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode(
                array(
                    'signature' => $this->getArgumentSecure($index.'_signature'),
                    'type' => $this->getArgumentSecure($index.'_type'),
                    'text' => $this->getArgumentSecure($index.'_text_notify_email_client'),
                    'html' => $this->getArgumentSecure($index.'_html'),
                    'subject' => trim($this->getArgumentSecure($index.'_subject')),
                    'email' => trim($this->getArgumentSecure($index.'_email')),
                    'virtual' => $this->getArgumentSecure($index.'_virtual'),
                    'userSignature' => $this->getArgumentSecure($index.'_userSignature'),
                    'fileIdArray' => $filesArray
                )
            )
        );
    }

    public function processDataDelete() {
        $status = $this->_getStatus();
        $status->setMessage('');
        $status->update();
    }

    public function processCronDay(Events_Event $event) {
        $data = (Array) json_decode($this->getValue('data'));

        // получаем шаблон
        $tpl = $data['text'];

        $virtual = $data['virtual'];

        if (!Shop_ModuleLoader::Get()->isImported('finance') || !$tpl) {
            return;
        }

        $status = $this->_getStatus($event);

        // получить задачи с контролируемым этапом
        $orders = Shop::Get()->getShopService()->getOrdersAll(false, true);
        $orders->filterDateclosed('0000-00-00 00:00:00');
        $orders->filterStatusid($status->getId());
        while ($order = $orders->getNext()) {
            try {
                if ($order->makeSumBalance($virtual) >= 0) {
                    continue;
                }

                $clientEmail = $order->getClientemail();

                if (!$clientEmail) {
                    try {
                        $clientEmail = $order->getClient()->getEmail();
                    } catch (Exception $emailEx) {

                    }
                }

                if (!$clientEmail) {
                    continue;
                }

                $client = false;
                try {
                    $client = $order->getClient();
                } catch (Exception $eclient) {

                }

                // получаем шаблон
                $tpl = $data['text'];

                $tpl = Shop::Get()->getShopService()->emailVariableReplace($order, $client, $tpl);

                Shop::Get()->getShopService()->getMailTemplate();

                // формируем письмо
                $html = Shop::Get()->getShopService()->makeOrderTemplate($order, $tpl);

                // убираем из него subject
                if (trim(@$data['subject'])) {
                    $subject = trim($data['subject']);
                } else {
                    if (preg_match("/Subject\:\s*(.+?)\n/iu", $html, $r)) {
                        $subject = trim(strip_tags($r[1]));
                        $html = trim(preg_replace("/Subject\:\s*(.+?)\n/iu", '', $html, 1));
                    } else {
                        $subject = false;
                    }
                }

                $subject = Shop::Get()->getShopService()->emailVariableReplace($order, $client, $subject);

                // обратный емейл
                if (trim(@$data['email'])) {
                    $emailFrom = trim($data['email']);
                } else {
                    $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
                }

                $template = false;
                if ($data['html']) {
                    $template = Shop::Get()->getShopService()->getMailTemplate();
                }

                $signatureUser = false;
                if ($data['signature']) {
                    try {
                        $signatureUser = $order->getManager();
                    } catch (Exception $emanager) {

                    }
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

                $comment = trim(strip_tags($html));
                $comment .= "\n\n";
                $comment .= "Отправлено на email {$clientEmail} от email {$emailFrom}";
                $comment .= " с темой ".$subject;

                // после того как письмо отправлено,
                // добавляем его в комментарий к order'y
                Shop::Get()->getShopService()->addOrderEmail(
                    $order,
                    false,
                    $comment
                );
            } catch (Exception $eorder) {

            }

        }

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