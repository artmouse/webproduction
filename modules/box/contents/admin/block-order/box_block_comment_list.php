<?php
class box_block_comment_list extends Engine_Class {

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
        $process = $this->getValue('process');

        $this->setValue('time', time());
        // текущий авторизированный пользователь
        $user = $this->getUser();
        $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);

        PackageLoader::Get()->registerJSFile('/_js/admin/comment.js');

        // когда нажата кнопка Сохранить
        if (!$process && $this->getControlValue('ok')) {
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

            if ($canEdit && $this->getArgumentSecure('commenttype') == 'letter'
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
                        
                        $letterhtml = $this->getArgumentSecure('letter_email_html');
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

                        $bodyType = 'text';
                        $template = false;
                        if ($letterhtml) {
                            $bodyType = 'html';
                            $template = Shop::Get()->getShopService()->getMailTemplate();
                        }
                        
                        Shop::Get()->getUserService()->sendEmail(
                            $emailFrom,
                            $email,
                            $subject,
                            $this->getControlValue('postcomment'),
                            $bodyType,
                            $fileAttachedArray,
                            $template,
                            $this->getUser()
                        );

                        $commentEmail = $this->getControlValue('postcomment');
                        $commentEmail .= "\n\n";
                        $commentEmail .=
                            Shop::Get()->getTranslateService()->getTranslateSecure('translate_otpravleno_na_email_');
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
            if ($canEdit && $this->getArgumentSecure('commenttype') == 'sms'
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
                        Shop::Get()->getTranslateService()->getTranslateSecure('translate_otpravleno_sms_na_nomer_');
                    $commentSMS .= $this->getArgumentSecure('post_sms_number');

                    Shop::Get()->getShopService()->addOrderSMS(
                        $order,
                        $this->getUser(),
                        $commentSMS
                    );
                } catch (Exception $esms) {

                }
            }

            // отправка Forms
            if ($canEdit && $this->getArgumentSecure('commenttype') == 'forms'
                && $this->getArgumentSecure('select_forms')) {
                
                try{
                    $email = $order->getClientemail();
                    if (!$email) {
                        throw new Exception('not-email');
                    }                   
                    $body = $this->getControlValue('postcomment');
                    $formid = $this->getControlValue('select_forms');
                    if ($formid) {
                        $emailFrom = $order->getManager()->getEmail();
                        if (!$emailFrom) {
                            $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('box-parser-email');

                            if (!$emailFrom) {
                                $emailFrom = Shop::Get()->getSettingsService()->getSettingValue(
                                    'reverse-email'
                                );
                            }
                        }

                        $form = new XShopFormsSettings($formid);                        
                        $subject = $form->getName()." #".$order->getId();
                        $link = Engine::Get()->getProjectURL()."/form/".$order->getId()."/".$formid."/";
                        $body .= "<br><br><br>";
                        $body .= '<div style="text-align:center;"><a style="display:inline-block;
                        vertical-align:middle; border:0;color: #fff;font-size:14px;cursor: pointer;padding: 8px 10px; 
                        text-decoration: none; margin: 5px;text-align: center;background-color: #39b54a;"
                        href="'.$link.'">';
                        $body .= Shop::Get()->getTranslateService()->getTranslate('translate_fill')."</a>
                            <div style='display:none'>".$link."</div></div>";
                                
                        Shop::Get()->getUserService()->sendEmail(
                            $emailFrom,
                            $email,
                            $subject,
                            $body,
                            'html',
                            false, // no send date
                            Shop::Get()->getShopService()->getMailTemplate()
                        );

                        $commentEmail = $this->getControlValue('postcomment');
                        $commentEmail .= "\n\n";
                        $commentEmail .=
                            Shop::Get()->getTranslateService()->getTranslateSecure('translate_otpravleno_na_email_');
                        $commentEmail .= $email;
                        $commentEmail .= " с темой ".$subject;
                        $commentEmail .= "\n\n Ссылка на форму: ".$link;

                        Shop::Get()->getShopService()->addOrderEmail(
                            $order,
                            $this->getUser(),
                            $commentEmail,
                            false
                        );
                    }
                } catch (Exception $esms) {

                }
            }

            // создание задачи
            if ($canEdit && $this->getArgumentSecure('commenttype') == 'issue') {
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
                                            MEDIA_PATH.'/file/'.$file->getFile(),
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

        }

        // удаление файла
        // @todo: to transaction up?
        if ($canEdit) {
            try {
                $file = new ShopFile(
                    $this->getArgument('filedelete')
                );

                $file->setDeleted(1);
                $file->update();
            } catch (Exception $e) {

            }
        }

        $onPage = 50;
        $p = $this->getArgumentSecure('p');

        $userId = Shop::Get()->getUserService()->getUser();
        $level = $userId->getLevel();
        $id = $userId->getId();
        $mainKey = $this->getValue('mainKey');

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

        $formsArray = array();
        $forms = new XShopFormsSettings();
        while ($f = $forms->getNext()) {
            $a = array();
            $a['id'] = $f->getId();
            $a['name'] = $f->getName();
            
            $formsArray[] = $a;
        }
        
        $this->setValue('formsArray', $formsArray);
        
        // режим box?
        $isBox = Engine::Get()->getConfigFieldSecure('project-box');
        $this->setValue('box', $isBox);

        if ($isBox) {
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

        $this->setValue('client', $order->getClientemail());
        
        // вывод комментариев
        $commentKeyArray = array();
        $commentKeyArray[] = 'shop-order-'.$order->getId();

        // дочерние ключи
        $tree = Shop::Get()->getShopService()->makeOrderTreeArray($this->getUser(), $order->getId());
        foreach ($tree as $x) {
            $commentKeyArray[] = 'shop-order-'.$x->getId();
        }

        $mainKey = $commentKeyArray[0];

        $comments = CommentsAPI::Get()->getComments($commentKeyArray);
        $comments->setOrder('cdate', 'DESC');

        $commentsCount = $comments->getCount();
        $comments->setLimit($p * $onPage, $onPage);

        $a = array();
        $j = 0;
        while ($x = $comments->getNext()) {

            // если наш юзер админ или создатель, открываем доступ к редактированию
            if ($level == 3 || $id == $x->getId_user()) {
                $edit = true;
            } else {
                $edit = false;
            }

            if ($this->getValue('notCanEdit')) {
                $edit = false;
            }

            try {
                $user = Shop::Get()->getUserService()->getUserByID(
                    $x->getId_user()
                );

                $color = $user->makeColor();
                $userName = $user->makeName(true, 'lfm');
                $userURL = $user->makeURLEdit();
                $userID = $user->getId();

                $avatar = $user->makeImageThumb(200);

                $companyName = $user->getCompany();
                if ($user->getEmployer()) {
                    $companyName = false;
                }
            } catch (Exception $userEx) {
                $userName = false;
                $userURL = false;
                $userID = false;
                $color = 'gray';
                $companyName = false;

                $avatar = MEDIA_PATH . '/shop/stub-man.jpg';
            }

            $key = $x->getKey();
            if (preg_match("/^shop-order-(\d+)$/ius", $key, $r)) {
                $key = 'order-'.$r[1];

                try {
                    $order = Shop::Get()->getShopService()->getOrderByID($r[1]);
                } catch (Exception $e) {
                    $order = false;
                }
            }

            $content = $x->getContent();

            $type = $x->getType();
            if (!$type) {
                $type = 'comment';
            }

            if ($mainKey && $mainKey != $x->getKey()) {
                $type = 'change';

                if ($order) {
                    $content = '#'.$order->getId().' '.$content;
                }
            }

            // это мой комментарий или нет?
            try {
                $my = $x->getId_user() == $this->getUser()->getId();
            } catch (Exception $e) {
                $my = false;
            }

            $eventData = array();
            if ($type == 'ecall') {
                $event = new ShopEvent();
                $event->setId($x->getIp());
                $event = $event->getNext();

                if ($event) {

                    $fromName = false;
                    $fromUrl = false;
                    $toName = false;
                    $toUrl = false;
                    try {
                        $toName = $event->getToContact()->makeName(true, 'lfm');
                        $toUrl = $event->getToContact()->makeURLEdit();
                    } catch (Exception $eto) {
                        $toName = $event->getTo();
                    }

                    try {
                        $fromName = $event->getFromContact()->makeName(true, 'lfm');
                        $fromUrl = $event->getFromContact()->makeURLEdit();
                    } catch (Exception $efrom) {
                        $fromName = $event->getFrom();
                    }
                    $eventData = array(
                        'idFrom' => $event->getFromuserid(),
                        'idTo' => $event->getTouserid(),
                        'nameFrom' => $fromName,
                        'nameTo' => $toName,
                        'urlTo' => $toUrl,
                        'urlFrom' => $fromUrl
                    );
                }
            }


            $a[] = array(
                'id' => $x->getId(),
                'content' => Shop::Get()->getShopService()->formatComment(
                    $content,
                    $key,
                    ($j == 0),
                    $x->getType(),
                    true
                ),
                'contentOriginal' => $x->getContent(),
                'datetime' => DateTime_Formatter::DateTimePhonetic($x->getCdate()),
                'color' => $color,
                'userName' => $userName,
                'userURL' => $userURL,
                'avatar' => $avatar,
                'userID' => $userID,
                'edit' => $edit,
                'type' => $type,
                'my' => $my,
                'companyName' => $companyName,
                'ip' => $x->getIp(),
                'eventData' => $eventData
            );

            $j++;
        }
        $this->setValue('commentArray', $a);

        $ar = $this->_pages($p, $onPage, $commentsCount);

        $a = $ar['pagesArray'];
        $this->setValue('pagesArray', $a);
        if (isset($ar['urlnext'])) {
            $this->setValue('urlnext', $ar['urlnext']);
        }
        if (isset($ar['urlprev'])) {
            $this->setValue('urlprev', $ar['urlprev']);
        }
        if (isset($ar['hellip'])) {
            $this->setValue('hellip', $ar['hellip']);
        }

    }

    private function _pages($page, $onPage, $count) {
        $assignsArray = array();

        $a = array();
        $cnt = ceil($count / $onPage);

        $stop = $page + 3;
        $start = $page - 3;

        if ($stop > $cnt) {
            $stop = $cnt;
            $start = $stop - 5;
        }

        if ($start < 0) {
            $start = 0;
            $stop = $start + 5;
        }
        if ($stop > $cnt) {
            $stop = $cnt;
        }

        $urlCurrent = Engine::GetURLParser()->getTotalURL();
        $urlCurrent = preg_replace("/\/p-(\d+)\//ius", '/', $urlCurrent);
        $urlGET = Engine::GetURLParser()->getGETString();
        if ($urlGET) {
            $urlGET = '?' . $urlGET;
        }

        for ($j = $start; $j < $cnt; $j++) {
            $a[] = array(
                'name' => ($j + 1),
                'url' => $j > 0 ? $urlCurrent . 'p-' . $j . '/' . $urlGET : $urlCurrent . $urlGET,
                'selected' => $j == $page,
                'visible' => $j > $stop ? false : true,
            );
        }

        $assignsArray['pagesArray'] = $a;

        // next
        if ($page + 1 < $cnt) {
            $urlNext = $urlCurrent . 'p-' . ($page + 1) . '/' . $urlGET;

            $assignsArray['urlnext'] = $urlNext;

            Engine::GetHTMLHead()->addLink('next', Engine::Get()->getProjectURL() . $urlNext);
        }

        // prev
        if ($page - 1 >= 0) {
            if ($page - 1 > 0) {
                $urlPrev = $urlCurrent . 'p-' . ($page - 1) . '/' . $urlGET;
            } else {
                $urlPrev = $urlCurrent . $urlGET;
            }

            $assignsArray['urlprev'] = $urlPrev;

            Engine::GetHTMLHead()->addLink('prev', Engine::Get()->getProjectURL() . $urlPrev);
        }

        if ($stop - $start > 0) {
            $assignsArray['hellip'] = true;
        }

        return $assignsArray;
    }

}