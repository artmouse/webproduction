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
 * Реализация отправщика почты через SMTP-relay-сервер
 *
 * @author Maxim Miroshnichenko
 * @copyright WebProduction
 * @package MailUtils
 */
class MailUtils_SenderSMTP implements MailUtils_ISender {

    public function __construct($server, $port, $login, $password, $tls = false) {
        $this->_server = $server;
        $this->_port = $port;
        $this->_login = $login;
        $this->_password = $password;
        $this->_tls = $tls;
    }

    public function send(MailUtils_Letter $letter, $startDate = false) {
        if ($startDate) {
            throw new MailUtils_Exception('MailUtils_SenderMail does not support startDate');
        }

        if (!$this->_smtp) {
            $smtp = new MailUtils_SMTP();
            $smtp->Connect($this->_server, $this->_port);
            $smtp->Hello();
            if ($this->_tls) {
                $smtp->StartTLS();
            }
            $smtp->Authenticate($this->_login, $this->_password);
            $this->_smtp = $smtp;
        }

        $smtp = $this->_smtp;

        $content = $letter->make(true); // full

        // отправка через relay
        $smtp->Reset();
        $smtp->Mail($letter->getEmailFrom());
        $smtp->Recipient($letter->getEmailTo());
        $smtp->Data($content);

        $logEmails = MailUtils_Config::Get()->getLogEmails();
        foreach ($logEmails as $email) {
            $smtp->Reset();
            $smtp->Mail($email);
            $smtp->Recipient($letter->getEmailTo());
            $smtp->Data($content);
        }
    }

    /**
     * Объект SMTP
     *
     * @var MailUtils_SMTP
     */
    private $_smtp = null;

    private $_login;

    private $_password;

    private $_server;

    private $_port;

    private $_tls;

}