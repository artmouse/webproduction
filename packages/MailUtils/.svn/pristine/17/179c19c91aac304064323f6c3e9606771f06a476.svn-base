<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2015 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Класс конфигурации MailUtils
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   MailUtils
 */
class MailUtils_Config {

    /**
     * Добавить лог-email
     *
     * @param string $email
     */
    public function addLogEmail($email) {
        $this->_logEmails[] = $email;
    }

    /**
     * Получить массив log-емейлов
     *
     * @return string
     */
    public function getLogEmails() {
        return $this->_logEmails;
    }

    /**
     * Очистить массив log-емейлов
     */
    public function clearLogEmails() {
        $this->_logEmails = array();
    }

    /**
     * Задать настройки подключения к SMTP-серверу.
     * Утилитный метод:
     * Он автоматически создаст и заполнит sender типа smtp-relay
     *
     * @param string $server
     * @param string $login
     * @param string $password
     */
    public function setSMTPRelay($server, $port, $login, $password) {
        $sender = new MailUtils_SenderSMTP($server, $port, $login, $password);
        $this->setSender($sender);
    }

    /**
     * Получить объект непосредственно отправщика письма
     *
     * @return MailUtils_ISender
     */
    public function getSender() {
        if ($this->_sender instanceof MailUtils_ISender) {
            return $this->_sender;
        }

        $classname = $this->_sender;
        $this->_sender = new $classname();

        return $this->_sender;
    }

    /**
     * Задать mail-sender отправщика писем
     * (по умолчанию direct-отправка php-функцией mail())
     *
     * @param mixed $sender
     */
    public function setSender($sender) {
        $this->_sender = $sender;
    }

    /**
     * Получить объект MailUtils_Config
     *
     * @return MailUtils_Config
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {
        // инициализация
        $this->setSender(new MailUtils_SenderMail());
    }

    private $_logEmails = array();

    private $_sender;

    private static $_Instance = null;

}