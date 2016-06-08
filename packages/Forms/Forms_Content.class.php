<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_Content {

    public function render($assignsArray = array()) {
        if (!$assignsArray) {
            $assignsArray = array();
        }

        $b = array_merge($this->_valuesArray, $assignsArray);
        $a = array_merge($b, $this->getTranslateArray());

        // строим hash
        array_multisort($a);

        // обрабатываем данные через шаблонизатор движка
        return Engine::GetSmarty()->fetch(
            $this->getFileHTML(),
            $a
        );
    }

    /**
     * @param array $translateArray
     */
    public function setTranslateArray($translateArray) {
        $this->_translateArray = $translateArray;
    }

    /**
     * @return array
     */
    public function getTranslateArray() {
        return array_merge($this->_translateArray, Forms_Translate::Get()->getTranslateArray());
    }

    /**
     * @param $file
     */
    public function setFileHTML($file) {
        $this->_filehtml = $file;
    }

    /**
     * @return string
     */
    public function getFileHTML() {
        return $this->_filehtml;
    }

    /**
     * @param $key
     * @return mixed
     * @throws Forms_Exception
     */
    public function getValue($key) {
        if (!$key) {
            throw new Forms_Exception("Empty key");
        }
        if (isset($this->_valuesArray[$key])) {
            return $this->_valuesArray[$key];
        }
        throw new Forms_Exception("Empty value for key '{$key}'");
    }

    /**
     * @param $key
     * @param $value
     * @throws Forms_Exception
     */
    public function setValue($key, $value) {
        if (!$key) {
            throw new Forms_Exception("Empty key");
        }
        $this->_valuesArray[$key] = $value;
    }

    private $_filehtml = __CLASS__;

    private $_valuesArray = array();

    private $_translateArray = array();

}