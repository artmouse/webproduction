<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Универсальный Event, которому в конструктор передается название процессора,
 * которое нужно будет запустить отложенно (в cron).
 *
 * Используется специально чтобы писать:
 * Events::Get()->observe('xxx', 'Shop_QueProcessor_Event', 'processorName');
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_QueProcessor_Event implements Events_IEventObserver {

    public function __construct($processorName) {
        $this->_processorName = $processorName;
    }

    public function notify(Events_Event $event) {
        $event;

        ProcessorQueService::Get()->addProcessor($this->_processorName);
    }

    private $_processorName;

}