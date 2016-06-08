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
class EngineDebug_ListenerPHPInfo implements EngineDebug_IListener {

    public function getName() {
        return 'phpinfo()';
    }

    public function notify() {
        ob_start();
        phpinfo();
        $x = ob_get_contents();
        ob_clean();
        return $x;
    }

}