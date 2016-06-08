<?php
/**
 * WebProduction Packages
 * @copyright (C) 2007-2012 WebProduction <webproduction.com.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * Система ответа в Engine.
 * Позволяет удобно устанавливать ответы заголовки HTTP-ответа.
 * Например, настройки cache, gzip, last-modified, body, ...
 *
 * Через систему ответа можно проганять картинки с настройками
 * кеширования, а не только страницы.
 *
 * @concept
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Engine
 */
class Engine_Response {

    /**
     * Установить 404й статус ответа
     */
    public function setHTTPStatus404() {
        $this->setHTTPStatus('404 Not Found');
    }

    /**
     * Установить заголовок powered-by.
     * По умолчанию он устанавливается в конструкторе.
     *
     * @see __construct()
     * @param string $value
     */
    public function setXPoweredBy($value) {
        $this->setHeader('X-Powered-By', $value);
    }

    /**
     * Задать заголовок языка
     *
     * @param string $language
     */
    public function setContentLanguage($language) {
        $this->setHeader('Content-Language', $language);
    }

    /**
     * Задать статус ответа HTTP
     *
     * @param string $status
     */
    public function setHTTPStatus($status) {
        $this->setHeader('HTTP/1.0 '.$status);
    }

    /**
     * Установить кеширование через Last-Modified
     *
     * @param int $seconds
     */
    public function setLastModifiedCaching($seconds) {
        $time = time() - $seconds;
        $this->setHeader('Last-Modified', gmdate('D, d M Y H:i:s', $time).' GMT');
    }

    /**
     * Задать mime-type ответа
     *
     * @param string $value
     */
    public function setContentType($value) {
        $this->setHeader('content-type', $value);
    }

    /**
     * Задать заголовок
     *
     * @param string $header
     * @param string $value
     */
    public function setHeader($header, $value = false) {
        $this->_headerArray[$header] = $value;
    }

    /**
     * Получить значение установленного заголовка
     *
     * @param string $header
     * @return string
     */
    public function getHeader($header) {
        if (isset($this->_headerArray[$header])) {
            return $this->_headerArray[$header];
        }
        throw new Engine_Exception("Header '{$header}' not found");
    }

    public function __toString() {
        if (!headers_sent())
        foreach ($this->_headerArray as $k => $v) {
            if ($v) {
                header("{$k}: {$v}");
            } else {
                header($k);
            }
        }
        return $this->_body;
    }

    /**
     * Задать тело ответа
     *
     * @param string $content
     */
    public function setBody($content) {
        $this->_body = $content;
    }

    /**
     * Получить тело ответа
     *
     * @return string
     */
    public function getBody() {
        return $this->_body;
    }

    public function __construct() {
        $this->setXPoweredBy('WebProduction Packages Engine');
    }

    private $_headerArray = array();

    private $_body = '';

}