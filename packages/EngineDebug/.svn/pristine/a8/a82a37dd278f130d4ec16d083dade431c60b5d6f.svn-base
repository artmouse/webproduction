<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package EngineDebug
 */
class EngineDebug_ListenerSQLObject implements EngineDebug_IListener {

    public function getName() {
        return 'SQLObject';
    }

    public function __construct() {

    }

    public function notify() {
        // получить статистику по SQLObject
        $a = SQLObject::GetStatistics();

        foreach ($a['queryArray'] as $index => $q) {
            $a['queryArray'][$index]['time'] = number_format($q['time'], 8);
            // $a['queryArray'][$index]['trace'] = print_r($q['trace'], true);
        }

        return Engine::GetSmarty()->fetch(
        dirname(__FILE__).'/EngineDebug_ListenerSQLObject.html',
        $a
        );
    }

}