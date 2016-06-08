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
class Forms_ContentFieldPasswordMD5 extends Forms_ContentField {

    public function __construct($key, $newHashPassword = false) {
        parent::__construct($key);

        $this->_newHashPassword = $newHashPassword;

        // @todo: o my god :(
        if (!method_exists('Shop_UserService', 'createHash')){
            $this->_newHashPassword = false;
        }

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'_Control.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();

        $assigns['key'] = $this->getKey();
        $assigns['value'] = @$cellsArray[$this->getKey()];

        return $this->getContentView()->render($assigns);
    }

    /**
     * Получить значение во введенный элемент
     *
     * @return string
     */
    public function getValue() {
        $x = Engine::GetURLParser()->getArgumentSecure($this->getKey());
        if ($x) {
            if($this->_newHashPassword){
                return Shop::Get()->getUserService()->createHash($x);
            }else{
                return md5($x);
            }
        }
        $x = Engine::GetURLParser()->getArgumentSecure($this->getKey().'-original');
        return $x;
    }

    /**
     * Получаем хеш пароля
     *
     * @param $password
     * @return string
     */
    private function _createHash($password){
        $salt = $this->_salt;
        if($salt){
            $salt = md5($salt);
            $md5password = md5(md5($password).$salt);

            return $md5password;
        }
        return md5($password);
    }

    private $_newHashPassword = false;
}