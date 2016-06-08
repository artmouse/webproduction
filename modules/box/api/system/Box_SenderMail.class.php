<?php
/**
 * WebProduction Packages
 *
 * Copyright (C) 2007-2015 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Отправка почты через SMTP если это возможно,
 * иначе обычный mail()
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 *
 * @copyright WebProduction
 *
 * @package MailUtils
 */
class Box_SenderMail implements MailUtils_ISender {

    public function send(MailUtils_Letter $letter, $startDate = false) {
        // получаем настройки почты
        $configArray = EventService::Get()->getEmailParserArray();
        if (!$configArray) {
            $configArray = array();
        }

        $emailFrom = $letter->getEmailFrom();
       // $emailFrom = $this->_parseEmail($emailFrom);

        // ищем наш ящик from
        $config = false;
        foreach ($configArray as $mailbox) {
            if ($emailFrom == $mailbox['username'] && !@$mailbox['notusesmtp']) {
                $config = $mailbox;
                break;
            }
        }

        $host = false;
        $username = false;
        if ($config) {
            // если конфиг найден - юзаем SMTP
            $sender = $this->_getSMTP($config);
            $method = 'smtp';
            if (@$config['smtphost']) {
                $host = $config['smtphost'];
            } else {
                $host = $config['host'];
            }
            $username = $config['username'];
        } else {
            // если конфиг не найден - юзаем обычный mail
            $sender = $this->_getMail();
            $method = 'mail';
        }

        if (PackageLoader::Get()->getMode('debug')) {
            print_r($sender);
        }

        $logArray = array(
            'from: '.$letter->getEmailFrom(),
            'to: '.$letter->getEmailTo(),
            'subject: '.$letter->getSubject(),
            'date: '.$startDate ? $startDate : DateTime_Object::Now()->__toString(),
            'method: '.$method,
            'class: '.get_class($sender),
            'host: '.$host,
            'username: '.$username

        );

        LogService::Get()->add($logArray, 'sendmail');

        $sender->send($letter, $startDate);
    }

    private function _getMail() {
        if (!$this->_mail) {
            $this->_mail = new MailUtils_SenderMail();
        }
        return $this->_mail;
    }

    private function _getSMTP($config) {
        if (!isset($this->_smtpArray[$config['username']])) {
            $port = @$config['smptport'];
            if (!$port) {
                $port = 25;
            }

            $host = @$config['smtphost'];

            if (!$host) {
                $host = $config['host'];
            }

            $smtp = new MailUtils_SenderSMTP(
                $host,
                $port,
                $config['username'],
                $config['password'],
                @$config['tls']
            );

            $this->_smtpArray[$config['username']] = $smtp;
        }

        return $this->_smtpArray[$config['username']];
    }

    /**
     * Parse clear email address
     *
     * @param string $email
     *
     * @return string
     *
     * @todo move to StringUtils
     */
    private function _parseEmail($email) {
        $a = imap_mime_header_decode($email);
        $r = '';
        foreach ($a as $x) {
            if ($x->charset.'' == 'default') {
                $r .= $x->text.'';
            } else {
                $r .= @iconv($x->charset.'', 'utf-8//IGNORE', $x->text.'');
            }
        }

        $r = preg_replace("/^UTF-8''(.+?)\./iuse", 'urldecode("$1").".";', $r);

        $x = trim($r);
        if (preg_match("/\<(.+?)\>/uis", $x, $email)) {
            $x = $email[1];
        }

        $x = substr($x, 0, 64);
        return strtolower($x);
    }

    private $_mail;

    private $_smtpArray = array();

}