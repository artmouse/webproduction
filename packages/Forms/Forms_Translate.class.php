<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Oleksii Golub <avator@webproduction.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_Translate {

    public function __construct() {
        $this->_parseTranslateXml();
    }

    /**
     * @return Forms_Translate
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    /**
     * Получить перевод по ключу
     *
     * @param $key
     * @return mixed
     * @throws Forms_Exception
     */
    public function getTranslate($key) {
        if (!$key) {
            throw new Forms_Exception("Empty key");
        }
        if (isset($this->_translateArray[$key])) {
            return $this->_translateArray[$key];
        }
        throw new Forms_Exception("Empty value for key '{$key}'");
    }

    /**
     * Безопасно получить перевода.
     * Если аргумента нет - вернет пустую стороку.
     *
     * @param $key
     */
    public function getTranslateSecure($key) {
        try {
            return $this->getTranslate($key);
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * Записать перевод по ключу
     *
     * @param $key
     * @param $value
     * @throws Forms_Exception
     */
    public function setTranslate($key, $value) {
        if (!$key) {
            throw new Forms_Exception("Empty key");
        }
        $this->_translateArray[$key] = $value;
    }

    /**
     * Получить массив с переводом
     *
     * @return array
     */
    public function getTranslates() {
        return $this->_translateArray;
    }

    /**
     * Записать массив переводов
     *
     * @param array $translates
     * @throws Forms_Exception
     */
    public function setTranslates(array $translates) {
        if (!$translates) {
            throw new Forms_Exception("Empty array");
        }
        $this->_translateArray = array_merge($this->_translateArray, $translates);
    }

    /**
     * @param $language
     */
    public function setLanguage($language) {
        $languageold = $this->_language;
        $this->_language = $language;
        if ($languageold != $language) {
            $this->_parseTranslateXml();
        }
    }

    /**
     * @return string
     */
    public function getLanguage() {
        return $this->_language;
    }

    /*
     * получить массив переводов
     * @return array
     */
    public function getTranslateArray () {
        return $this->_translateArray;
    }


    /**
     * Парсим xml с переводом по заданному языку
     * @deprecated
     */
    private function _parseTranslateXml() {
        // получает указаный язык
        $lang = $this->getLanguage();

        if ($lang) {
            $file = dirname(__FILE__).'/translate/'.$lang.'.xml';
            $file = file_get_contents($file);
            $this->_translateArray = (array) simplexml_load_string($file);
        }
    }

    /**
     * Парсим PHP с переводом по заданному языку
     */
    private function _parseTranslatePHP() {
        // получает указаный язык
        $lang = $this->getLanguage();

        if ($lang) {
            $file = dirname(__FILE__).'/translate/'.$lang.'.php';
            include_once $file;
            $this->_translateArray = $translate;
        }
    }

    private static $_Instance = null;

    private $_translateArray = array();

    private $_language  = 'ru';

}