<?php
class ajax_admin_send_email extends Engine_Class {

    public function process() {
        $emailTo = trim($this->getArgumentSecure('email'));
        $subject = trim($this->getArgumentSecure('subject'));
        $content = trim($this->getArgumentSecure('content'));
        $sendDate = trim($this->getArgumentSecure('sendDate'));
        $emailFrom = trim($this->getArgumentSecure('from'));
        $letterHtml = trim($this->getArgumentSecure('letterhtml'));
        $resultArray['status'] = 'error';

        if ($emailTo && ($subject || $content)) {
            try {
                if (!$emailFrom) {
                    $emailFrom = Shop::Get()->getUserService()->getUser()->getEmail();
                }

                // формируем массив файлов
                $fileArray = array();
                $index = 0;
                while (1) {
                    $tmp = $this->getArgumentSecure($index);
                    if ($tmp) {
                        $fileArray[] = $tmp;
                        $index ++;
                    } else {
                        break;
                    }
                }

                $attachFile = $this->getArgumentSecure('attachfile', 'array');
                foreach ($attachFile as $x) {
                    $x = explode(';', $x, 3);

                    $md5 = $x[0];
                    $folder1 = substr($md5, 0, 2);
                    $folder2 = substr($md5, 2, 2);
                    $folder3 = substr($md5, 4, 4);
                    $folder4 = substr($md5, 8, 4);
                    $saveDir = PackageLoader::Get()->getProjectPath().'media/email/';
                    $md5x = $folder1.'/'.$folder2.'/'.$folder3.'/'.$folder4.'/'.$md5;

                    $fileArray[] = array(
                    'tmp_name' => $saveDir.$md5x,
                    'type' => $x[1],
                    'name' => $x[2],
                    );
                }

                $bodyType = 'text';
                if ($letterHtml && $letterHtml != 'undefined') {
                    $bodyType = 'html';
                }

                Shop::Get()->getUserService()->sendEmail(
                    $emailFrom,
                    $emailTo,
                    $subject,
                    $content,
                    $bodyType,
                    $fileArray,
                    false, // no wrap
                    $this->getUser(), // чтобы добавить подпись
                    $sendDate
                );

                $resultArray['status'] = 'success';
            } catch (Exception $mailEx) {
                print $mailEx;
            }
        }
        echo json_encode($resultArray);
        exit();
    }

}