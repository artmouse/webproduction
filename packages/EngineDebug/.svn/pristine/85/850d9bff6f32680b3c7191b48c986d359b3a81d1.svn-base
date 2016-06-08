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
class EngineDebug_ListenerConnectionManagerMySQL implements EngineDebug_IListener {

    public function getName() {
        return 'ConnectionManager MySQL';
    }

    public function notify() {
        // получить статистику по SQLObject
        // @todo: нужно мониторить все конекшины!
        $stat = ConnectionManager::Get()->getConnectionMySQL()->getStatistics();
        $a = array();

        $time = 0;
        foreach ($stat as $q) {
            $a['queryArray'][] = array(
            'query' => $q['query'],
            'time' => number_format($q['time'], 8),
            );

            $time += $q['time'];
        }

        $a['queryTime'] = $time;
        $a['queryCount'] = count($stat);

        return Engine::GetSmarty()->fetch(
        dirname(__FILE__).'/EngineDebug_ListenerConnectionManagerMySQL.html',
        $a
        );
    }

}