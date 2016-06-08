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
 * @author EngineDebug
 */
class EngineDebug_ListenerURLParser implements EngineDebug_IListener {

    public function getName() {
        return 'Engine::GetURLParser()';
    }

    public function notify() {
        $a = array();
        $arguments = Engine::GetURLParser()->getArguments();
        foreach ($arguments as $k => $v) {
            if (is_array($v)) {
                $a[$k] = '<pre>'.print_r($v, true).'</pre>';
            } else {
                $a[$k] = htmlspecialchars($v);
            }
        }

        $assignsArray = array();
        $assignsArray['argumentsArray'] = $a;
        $assignsArray['urlcurrent'] = Engine::GetURLParser()->getCurrentURL();
        $assignsArray['urlid'] = Engine::GetURLParser()->makeURLID();
        $assignsArray['urlmatch'] = Engine::GetURLParser()->getMatchURL();
        $assignsArray['urltotal'] = Engine::GetURLParser()->getTotalURL();
        $assignsArray['urlget'] = Engine::GetURLParser()->getGETString();
        $assignsArray['urlhost'] = Engine::GetURLParser()->getHost();

        return Engine::GetSmarty()->fetch(
        dirname(__FILE__).'/EngineDebug_ListenerURLParser.html',
        $assignsArray
        );
    }

}