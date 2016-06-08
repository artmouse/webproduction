<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can redistribute it and/or
 * modify it.
 */

/**
 * Отправищик сообщений в панель EngineDebug
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package EngineDebug
 */
class EngineDebug_ListenerMessages implements EngineDebug_IListener {

    public function getName() {
        return 'Сообщения в панель';
    }

    /**
     * @return EngineDebug_ListenerMessages
     */
    public function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    public function print_r($var) {
        $this->_messageArray[] = print_r($var, true);
    }

    public function var_dump($var) {
        $this->_messageArray[] = var_export($var, true);
    }

    public function notify() {
        return Engine::GetSmarty()->fetch(
        dirname(__FILE__).'/EngineDebug_ListenerMessages.html',
        array('messagesArray' => $this->_messageArray)
        );
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private static $_Instance = null;

    private $_messageArray = array();

}