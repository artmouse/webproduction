<?php
class orders_control_block_comment extends Engine_Class {

    /**
     * Метод-обертка
     *
     * @return ShopOrder
     */
    private function _getOrder() {
        return $this->getValue('order');
    }

    public function process() {
        PackageLoader::Get()->import('CommentsAPI');

        PackageLoader::Get()->registerJSFile('/_js/dropzone.min.js');
        PackageLoader::Get()->registerJSFile('/_js/dropuploader.js');

        try {
            // получаем заказ
            $order = $this->_getOrder();

            // текущий авторизированный пользователь
            $user = $this->getUser();

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);

            // режим только отображения комметариев
            $view = $this->getValue('view');

            // режим box?
            $isBox = Engine::Get()->getConfigFieldSecure('project-box');
            $this->setValue('box', $isBox);

            // когда нажата кнопка Сохранить
            if (!$view && $canEdit && $this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    // добавления комментария/файла
                    $comment = $this->getControlValue('postcomment');
                    $comment = trim($comment);

                    $fileIDArray = $this->getArgumentSecure('fileid', 'array');

                    if (($comment || $fileIDArray)
                    && $this->getArgumentSecure('commenttype') == 'comment') {
                        try {
                            Shop::Get()->getShopService()->addOrderComment(
                                $order,
                                $this->getUser(),
                                $comment,
                                $fileIDArray
                            );

                            $this->setValue('message', 'commentok');
                        } catch (Exception $commentException) {
                            if (PackageLoader::Get()->getMode('debug')) {
                                print $commentException;
                            }

                            $this->setValue('message', 'commenterror');
                        }
                    }

                    if ($this->getArgumentSecure('commenttype') == 'letter'
                    && $this->getArgumentSecure('post_letter_email')) {
                        $emails = explode(',', $this->getArgumentSecure('post_letter_email'));
                        foreach ($emails as $email) {
                            $email = trim($email);

                            if (strlen($email) < 5) {
                                continue;
                            }

                            $comment = $this->getControlValue('postcomment');
                            if ($comment || $fileIDArray) {

                                $emailFrom = $this->getArgumentSecure('post_letter_email_from');
                                if (!$emailFrom) {
                                    $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('box-parser-email');

                                    if (!$emailFrom) {
                                        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue(
                                            'reverse-email'
                                        );
                                    }
                                }

                                $subject = trim($this->getArgumentSecure('post_letter_subject'));
                                if (!$subject) {
                                    $subject = $order->getName();
                                }

                                $subject .= ' #'.$order->getId();

                                $fileAttachedArray = array();
                                foreach ($fileIDArray as $fileID) {
                                    try {
                                        $file = Shop::Get()->getFileService()->getFileByID($fileID);

                                        $fileAttachedArray[] = array(
                                            'name' => $file->getName(),
                                            'type' => $file->getContenttype(),
                                            'tmp_name' => $file->makePath()
                                        );
                                    } catch (ServiceUtils_Exception $fse) {

                                    }
                                }

                                Shop::Get()->getUserService()->sendEmail(
                                    $emailFrom,
                                    $email,
                                    $subject,
                                    $this->getControlValue('postcomment'),
                                    'text',
                                    $fileAttachedArray,
                                    false, // no send date
                                    $this->getUser()
                                );

                                $commentEmail = $this->getControlValue('postcomment');
                                $commentEmail .= "\n\n";
                                $commentEmail .= Shop::Get()->getTranslateService()->getTranslateSecure(
                                    'translate_otpravleno_na_email_'
                                );
                                $commentEmail .= $email;
                                $commentEmail .= " с темой ".$subject;

                                Shop::Get()->getShopService()->addOrderEmail(
                                    $order,
                                    $this->getUser(),
                                    $commentEmail,
                                    $fileIDArray
                                );
                            }

                        }
                    }

                    // отправка SMS
                    if ($this->getArgumentSecure('commenttype') == 'sms'
                    && $this->getArgumentSecure('post_sms_number')) {
                        try{
                            Shop::Get()->getUserService()->sendSMS(
                                $this->getArgumentSecure('post_sms_number'),
                                $this->getControlValue('postcomment'),
                                $this->getUser()
                            );

                            $commentSMS = $this->getControlValue('postcomment');
                            $commentSMS .= "\n\n";
                            $commentSMS .=
                                Shop::Get()->getTranslateService()->getTranslateSecure(
                                    'translate_otpravleno_sms_na_nomer_'
                                );
                            $commentSMS .= $this->getArgumentSecure('post_sms_number');

                            Shop::Get()->getShopService()->addOrderSMS(
                                $order,
                                $this->getUser(),
                                $commentSMS
                            );
                        } catch (Exception $esms) {

                        }
                    }

                    // создание задачи
                    if ($this->getArgumentSecure('commenttype') == 'issue') {
                        $r = explode("\n\r\n", $this->getArgumentSecure('postcomment'));
                        foreach ($r as $issuetext) {
                            if (!$issuetext) {
                                continue;
                            }
                            $issuetext = explode("\n", $issuetext, 2);
                            if (@$issuetext[0]) {
                                try {
                                    $title = $issuetext[0];
                                    $managerID = false;

                                    if (preg_match("/\[(.+?)\#(\d+)\]/iuse", $title, $r)) {
                                        $managerID = @$r[2];
                                        $title = preg_replace(
                                            "/\[(.+?)\#(\d+)\]/iuse",
                                            '',
                                            $title
                                        );
                                    }

                                    if (!$managerID) {
                                        try{
                                            $managerID = $order->getStatus()->getManagerid();

                                        } catch (Exception $se) {

                                        }

                                        if (!$managerID) {
                                            $managerID = $order->getManagerid();
                                        }
                                    }

                                    $postissue = IssueService::Get()->addIssue(
                                        $this->getUser(),
                                        $title,
                                        @$issuetext[1],
                                        $managerID,
                                        false,
                                        false,
                                        false,
                                        $order->getId()
                                    );

                                    if ($fileIDArray) {
                                        $newFileIdArray = array();
                                        foreach ($fileIDArray as $fileId) {
                                            try{
                                                // делаем копию документа
                                                // т.к. каждый документ привязывается к заказу
                                                $file = Shop::Get()->getFileService()->getFileByID($fileId);
                                                $newFile = Shop::Get()->getFileService()->addFile(
                                                    $file->makePath(),
                                                    $file->getName(),
                                                    $file->getContenttype(),
                                                    $this->getUser()
                                                );
                                                $newFileIdArray[] = $newFile->getId();
                                            } catch (Exception $ef) {

                                            }

                                        }

                                        Shop::Get()->getShopService()->addOrderComment(
                                            $postissue,
                                            $this->getUser(),
                                            false,
                                            $newFileIdArray
                                        );
                                    }


                                } catch (Exception $issueAddEx) {

                                }
                            }
                        }
                    }

                    SQLObject::TransactionCommit();

                    if (Engine::GetURLParser()->getArgumentSecure('message') != 'error') {
                        Engine::GetURLParser()->setArgument('message', 'ok');
                    }

                } catch (ServiceUtils_Exception $te) {
                    SQLObject::TransactionRollback();

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $te;
                    }

                    Engine::GetURLParser()->setArgument('message', 'error');

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $te->getErrorsArray());
                }
            }

            // удаление файла
            // @todo: to transaction up?
            try {
                $file = new ShopFile(
                    $this->getArgument('filedelete')
                );

                $file->setDeleted(1);
                $file->update();
            } catch (Exception $e) {

            }

            if ($isBox) {
                try {
                    $this->setValue('clientEmail', $order->getClient()->getEmail());
                    $this->setValue('clientSMSArray', $order->getClient()->getPhoneArrayForSMS());
                } catch (Exception $e) {

                }
            }

            $clientEmail = $order->getClientemail();
            if (!$clientEmail) {
                try{
                    $clientEmail = $order->getClient()->getEmail();
                } catch (Exception $ee) {

                }
            }
            $this->setValue('clientPostEmail', $clientEmail);

            if (Shop::Get()->getSettingsService()->getSettingValue('sms-login')
            && Shop::Get()->getSettingsService()->getSettingValue('sms-password')
            && Shop::Get()->getSettingsService()->getSettingValue('sms-sender')) {
                try{
                    $clientSmsArray = $order->getClient()->getPhoneArrayForSMS();
                    $clientPhone = str_replace('+', '', $order->getClientphone());
                    if ($clientPhone && !in_array($clientPhone, $clientSmsArray)) {
                        array_unshift($clientSmsArray, $clientPhone);
                    }
                    $this->setValue('clientPostSmsArray', $clientSmsArray);
                } catch (Exception $ee) {

                }
            }

            // вывод комментариев
            $commentKeyArray = array();
            $commentKeyArray[] = 'shop-order-'.$order->getId();

            // дочерние ключи
            $tree = Shop::Get()->getShopService()->makeOrderTreeArray($this->getUser(), $order->getId());
            foreach ($tree as $x) {
                $commentKeyArray[] = 'shop-order-'.$x->getId();
            }

            $comments = CommentsAPI::Get()->getComments($commentKeyArray);
            $comments->setOrder('cdate', 'DESC');
            $block = Engine::GetContentDriver()->getContent('comment-block');
            $block->setValue('comments', $comments);
            $block->setValue('mainKey', $commentKeyArray[0]);
            $this->setValue('block_comment', $block->render());

            if ($isBox) {
                $this->setValue('box', true);

                // файлы-вложения
                $files = new ShopFile();
                $files->setKey('order-'.$order->getId());
                $files->setDeleted(0);
                $a = array();
                while ($x = $files->getNext()) {
                    try {
                        $username = Shop::Get()->getUserService()->getUserByID($x->getUserid())->makeName(true, 'lfm');
                    } catch (Exception $e) {
                        $username = false;
                    }

                    $urlDelete = Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                        array('filedelete' => $x->getId())
                    );

                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'url' => $x->makeURL(),
                    'username' => $username,
                    'cdate' => $x->getCdate(),
                    'size' => $x->makeSize(),
                    'urlDelete' => $urlDelete,
                    );
                }
                $this->setValue('fileArray', $a);

                $this->setValue('commentTemplateArray', Shop::Get()->getShopService()->getCommentTemplatesArray());
            }

            // исполнители
            $watcherArray = Shop::Get()->getShopService()->getOrderUserNotifyArray($order, '');
            $a = array();
            foreach ($watcherArray as $x) {
                $a[$x->getId()] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(true, 'lfm'),
                'url' => $x->makeURLEdit(),
                );
            }
            $this->setValue('watcherArray', $a);

            $emailFromArray = array();
            $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('box-parser-email');
            if (!$emailFrom) {
                $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
            }
            if ($emailFrom) {
                $emailFromArray[] = $emailFrom;
            }

            if (Checker::CheckEmail($user->getEmail())) {
                $emailFromArray[] = $user->getEmail();
            }
            $this->setValue('emailFromArray', $emailFromArray);

            $this->setValue('time', time());
        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }
}