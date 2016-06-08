<?php
/**
 * WebProduction Packages
 * @copyright (C) 2007-2012 WebProduction <webproduction.com.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * Интерфейс для URLParser'a
 *
 * @copyright WebProduction
 * @package Engine
 * @author Max
 * @subpackage URLParser
 */
interface Engine_IURLParser {

    /**
     * Получение парсера (реализация шаблона singleton)
     *
     * @static
     * @return Engine_IURLParser
     */
    public static function Get();

    /**
     * Для текущей открытой страницы получить идентификатор, который
     * с большой степенью вероятности будет ее однозначно идентифицировать
     *
     * Необходим для системы кеширования контентов.
     *
     * @return string
     */
    public function makeURLID();

    /**
     * Возвращает URL, на основании которого Engine будет искать необходимый контент
     *
     * @return string
     */
    public function getMatchURL();

    /**
     * Возвращает "чистый" URL запрос
     *
     * @author Ramm
     * @return string
     */
    public function getTotalURL();

    /**
     * Возвращает часть URL запроса, которая содержит содержит GET параметры
     *
     * @return string
     */
    public function getGETString();

    /**
     * Возвращает хост
     *
     * @return string
     */
    public function getHost();

    /**
     * Возвращает аргументы передаваемые странице
     *
     * @return array
     */
    public function getArguments();

    /**
     * Возвращает аргумент по ключу
     *
     * @throws Engine_Exception
     * @param string $key
     * @return mixed
     */
    public function getArgument($key);

    /**
     * Добавить агрумент.
     * Метод добавлен по инициативе.
     *
     * @author Max
     * @param string $key
     * @param mixed $value
     */
    public function setArgument($key, $value);

    /**
     * Возвращает аргумент по ключу (без генерации исключения в случае его отсутствия - тогда вернет false)
     *
     * @param string $key
     * @return mixed
     */
    public function getArgumentSecure($key);

    /**
     * Возвращает ПОЛНЫЙ URL с гет параметрами, если они были переданы
     *
     * @return string
     */
    public function getCurrentURL();

}