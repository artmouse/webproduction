<?php
/**
 * WebProduction Packages
 *
 * @copyright (C) 2007-2016 WebProduction <webproduction.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * Smarty template engine for wpp Engine
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Engine
 * @subpackage Smarty
 */
class Engine_Smarty {

    /**
     * Через Smarty обработать файл и выдать html-код
     *
     * @param string $file
     * @param array $assignArray
     *
     * @return string
     */
    public function fetch($file, $assignArray) {
        $smarty = $this->getSmarty();
        $smarty->assignArray($assignArray, false); // no merge
        return $smarty->fetch($file);
    }

    /**
     * Выполнить обработку $html и вернуть строку HTML.
     *
     * @param string $html
     * @param array $assignArray
     *
     * @return string
     */
    public function fetchString($html, $assignArray) {
        $file = dirname(__FILE__).'/compile/'.md5($html).'.tpl';
        file_put_contents($file, $html, LOCK_EX);

        $smarty = $this->getSmarty();
        $smarty->assignArray($assignArray, false); // no merge

        $html = $smarty->fetch($file);
        return $html;
    }

    /**
     * Получить объект шаблонизатора Smarty
     *
     * @return Smarty
     */
    public function getSmarty() {
        return $this->_smarty;
    }

    public function __construct() {
        // подключаем Smarty
        PackageLoader::Get()->import('Smarty');

        // инициируем Smarty внутри (аггрегация Smarty)
        $this->_smarty = new Smarty();
        $this->_smarty->compile_dir = dirname(__FILE__).'/compile/';
    }

    /**
     * Внутренний объект Smarty
     *
     * @var Smarty
     */
    private $_smarty = null;

}