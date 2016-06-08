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
class EngineDebug_ListenerVars implements EngineDebug_IListener {

    public function getName() {
        return '$_SERVER, $_SESSION, $_COOKIE, ...';
    }

	public function notify() {
	    $assignsArray['server'] = $this->_makeArray($_SERVER);
	    $assignsArray['session'] = $this->_makeArray($_SESSION);
	    $assignsArray['cookie'] = $this->_makeArray($_COOKIE);
	    $assignsArray['get'] = $this->_makeArray($_GET);
	    $assignsArray['post'] = $this->_makeArray($_POST);
	    //$assignsArray['globals'] = $this->_makeArray($GLOBALS);

	    return Engine::GetSmarty()->fetch(
        dirname(__FILE__).'/EngineDebug_ListenerVars.html',
        $assignsArray
        );
	}

	/**
	 * Проработать массив
	 *
	 * @param array $array
	 * @return array
	 */
	private function _makeArray($array) {
	    $a = array();
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $a[$k] = '<pre>'.print_r($v, true).'</pre>';
            } else {
                $a[$k] = htmlspecialchars($v);
            }
        }
        return $a;
	}

}