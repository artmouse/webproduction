<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can redistribute it and/or
 * modify it.
 */

/**
 * EngineDebug - пакет, который на основе плагинов-слушателей
 * запрашивает статистику по всем компонентам системы (и пакетам),
 * регистрирует в Engine контент Debug Toolbar, при помощи которого,
 * разработчик получает красивую и понятную debug-информацию по скриптам.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package EngineDebug
 */
class EngineDebug {

    /**
     * @return EngineDebug
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    /**
     * Добавить обработчик события
     *
     * @param EngineDebug_IListener $listener
     */
    public function addListener(EngineDebug_IListener $listener) {
        $this->_listenerArray[] = $listener;
    }

    /**
     * Собрать статистику и записать в файл с ключем
     */
    public function finalize() {
        $html = '';

        // спрашиваем готовый код у слушателей
        foreach ($this->_listenerArray as $x) {
            // @todo: to content?
            $class = get_class($x);
            $html .= '<a href="#" id="EngineDebug-'.$class.'-link" class="wpp-h1">'.$x->getName().'</a><br />';
            $html .= '<div class="EngineDebug-autohide" id="EngineDebug-'.$class.'">'.$x->notify().'</div><br />';
        }

        // записываем все в файл
        file_put_contents(
        dirname(__FILE__).'/tmp/'.$this->getKey(),
        $html
        );
    }

    /**
     * Получить уникальный ключ, в который сейчас
     * пишется debug-статистика
     *
     * @return string
     */
    public function getKey() {
        return $this->_key;
    }

    private function __construct() {
        // строим уникальный ключ (имя файла)
        @session_start();
        $this->_key = md5(session_id().time());

        // подчищаем старые файлы из /tmp/ за последний час
        $dir = dirname(__FILE__).'/tmp/';
        $d = opendir($dir);
        while ($x = readdir($d)) {
            if (is_file($dir.$x)) {
                if (DateTime_Differ::DiffHour('now', date('Y-m-d H:i:s', filectime($dir.$x))) >= 1) {
                    unlink($dir.$x);
                }
            }

        }
        closedir($d);
    }

    private function __clone() {
        // клонирование запрещено
    }

    private static $_Instance = null;

    private $_listenerArray = array();

    private $_key;

}