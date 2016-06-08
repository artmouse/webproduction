<?php
/**
 * Copyright (C) 2007-2014 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Обработчик ошибок
 */
class Shop_ContentErrorHandler {

    /**
     * Задать файл-шаблон для вывода ошибок
     *
     * @param string $file
     */
    public function setHTMLFile($file) {
        $this->_HTMLFile = $file;
    }

    /**
     * @return string
     */
    public function getHTMLFile() {
        return $this->_HTMLFile;
    }

    /**
     * Добавить массив ключей-ошибок
     *
     * @param array $errorKeyArray
     */
    public function addErrorKeyArray($errorKeyArray) {
        $a = $this->_errorKeyArray;
        $a = array_merge($a, $errorKeyArray);
        $this->_errorKeyArray = $a;
    }

    /**
     * @return array
     */
    public function getErrorKeyArray() {
        return $this->_errorKeyArray;
    }

    /**
     * Получить массив текстов ошибок
     *
     * @param ServiceUtils_Exception $exception
     * @return array
     */
    public function getErrorValueArray(ServiceUtils_Exception $exception) {
        $errorValueArray = array();

        // получить массив ошибок из exception-а
        $exceptionErrorArray = $exception->getErrorsArray(true);

        // получить массив соответствий код ошибки - текст ошибки
        $errorKeyArray = $this->getErrorKeyArray();

        foreach ($exceptionErrorArray as $error) {
            if (!isset($error['key'])) {
                continue;
            }

            $errorKey = $error['key'];
            $errorParamArray = $error['parameterArray'];

            if (isset($errorKeyArray[$errorKey])) {
                // получаем шаблон теста ошибки
                $errorTemplate = $errorKeyArray[$errorKey];

                // смотрим параметры, переданные в exception
                foreach ($errorParamArray as $errorParamKey => $errorParamValue) {
                    $errorTemplate = str_replace('{|$'.$errorParamKey.'|}', $errorParamValue, $errorTemplate);
                }

                $errorValueArray[] = $errorTemplate;
            }
        }

        return $errorValueArray;
    }

    /**
     * @return Shop_ContentErrorHandler
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private static $_Instance = null;

    private $_HTMLFile = false;
    private $_errorKeyArray = array();

}