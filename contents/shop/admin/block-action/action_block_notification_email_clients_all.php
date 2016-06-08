<?php
class action_block_notification_email_clients_all extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));

        $this->setValue('type', $data['type']);
        $this->setValue('signature', $data['signature']);
        $this->setValue('subject', $data['subject']);
        $this->setValue('email', $data['email']);
        $this->setValue('text', $data['text']);
        $this->setValue('html', $data['html']);
        $this->setValue('ordercomment', $data['ordercomment']);
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

    /*public function processOrderAddAfter(Events_Event $event) {
        $this->processStatus($event);
    }*/

    public function processStatus(Events_Event $event) {
        $order = $this->_getOrder($event);

        $data = (Array) json_decode($this->getValue('data'));

        $orderClients = new XShopOrderContacts();
        $orderClients->setOrderid($order->getId());

        $send = false;
        $subject = false;
        $html = false;
        $emailFrom = false;
        while ($or = $orderClients->getNext()) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($or->getUserid());

                $emailTo = $user->getEmail();
                if (!$emailTo) {
                    continue;
                }

                // получаем шаблон

                if ($data['ordercomment']) {
                    $tpl = $order->getComments();
                } else {
                    $tpl = $data['text'];
                }

                if (!$tpl) {
                    return;
                }

                $tpl = Shop::Get()->getShopService()->emailVariableReplace($order, $user, $tpl);

                $nameFirst =  trim($user->getName());
                $nameLast = trim($user->getNamelast());
                $nameMiddle = trim($user->getNamemiddle());

                if ($user->getTypesex() == 'company') {
                    $nameSmart = $user->getCompany();
                } else {
                    $nameSmart = trim($nameFirst.' '.$nameMiddle);
                }

                $currencySym = false;
                try {
                    $currencySym = $order->getCurrency()->getSymbol();
                } catch (Exception $ecurrency) {

                }

                $contractorDetails = false;
                try {
                    $contractor = Shop::Get()->getShopService()->getContractorByID($order->getContractorid());
                    $contractorDetails = $contractor->getDetails();
                } catch (Exception $e) {

                }



                // формируем письмо
                $html = Shop::Get()->getShopService()->makeOrderTemplate($order, $tpl);

                // убираем из него subject
                if ($data['subject']) {
                    $subject = $data['subject'];
                } elseif (preg_match("/Subject\:\s*(.+?)\n/iu", $html, $r)) {
                    $subject = trim(strip_tags($r[1]));
                    $html = trim(preg_replace("/Subject\:\s*(.+?)\n/iu", '', $html, 1));
                } else {
                    $subject = $order->getName();
                }

                $subject = Shop::Get()->getShopService()->emailVariableReplace($order, $user, $subject);

                // обратный емейл
                $emailFrom = $data['email'];
                if (!$emailFrom) {
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

                if ($emailTo && Checker::CheckEmail($emailFrom) && ($subject || $html) ) {
                    Shop::Get()->getUserService()->sendEmail(
                        $emailFrom,
                        $emailTo,
                        $subject,
                        $html,
                        $data['type'],
                        $filesDataArray,
                        $template,
                        $signatureUser,
                        false,
                        true,
                        @$data['userSignature']
                    );

                    $send = true;
                }

            } catch (Exception $ex) {

            }
        }

        if (!$send) {
            return;
        }

        $user = $this->_getUser($event);

        $comment = trim(strip_tags($html));
        $comment .= "\n\n";
        $comment .= "Отправлено на email всех контактов от email {$emailFrom}";
        if ($subject) {
            $comment .= " с темой ".$subject;
        } else {
            $comment .= " без темы";
        }

        // после того как письмо отправлено,
        // добавляем его в комментарий к order'y
        Shop::Get()->getShopService()->addOrderEmail(
            $order,
            $user,
            $comment
        );
    }

    /**
     * Заменить картинку (callback)
     *
     * @param array $x
     *
     * @return string
     */
    private function _fileImage($x) {
        $fileID = $x[1];
        try {
            $file = Shop::Get()->getFileService()->getFileByID($fileID);
            $url = Shop::Get()->getFileService()->makeFileURLByHash($file->getFile());
            return Engine::Get()->getProjectURL().$url;
        } catch (Exception $e) {
            return $fileID;
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