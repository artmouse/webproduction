<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can redistribute it and/or
 * modify it.
 */

/**
 * Load Average статистика:
 * время выполнения скрипта,
 * использование памяти,
 * лимиты памяти и т.д.
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package EngineDebug
 */
class EngineDebug_ListenerLA implements EngineDebug_IListener {

    public function getName() {
        return 'Статистика L.A.';
    }

    public function __construct() {
        $this->_time = microtime(true);

        declare(ticks=1);
        register_tick_function(array($this, '_tickHandler'));
    }

    public function _tickHandler() {
        $this->_tickCount ++;
    }

    public function notify() {
        $a = array();
        $a['cpu_time'] = microtime(true) - $this->_time;
        $a['tick_count'] = $this->_tickCount;
        $a['memory_usage'] = memory_get_usage();
        $a['memory_usage_real'] = memory_get_usage(true);
        $a['memory_peak_usage'] = memory_get_peak_usage();
        $a['memory_peak_usage_real'] = memory_get_peak_usage(true);
        $a['memory_limit'] = ini_get('memory_limit');

        return Engine::GetSmarty()->fetch(
        dirname(__FILE__).'/EngineDebug_ListenerLA.html',
        $a
        );
    }

    private $_time = 0;

    private $_tickCount = 0;

}