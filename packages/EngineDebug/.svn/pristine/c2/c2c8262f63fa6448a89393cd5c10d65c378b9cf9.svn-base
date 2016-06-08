<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can redistribute it and/or
 * modify it.
 */

/**
 * Слушатель final-события для Engine
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package EngineDebug
 */
class EngineDebug_EngineOnFinal implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        EngineDebug::Get()->finalize();
    }

}