<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Проверка валидности URL-prefix'a
 *
 * @author Oleksii Golub <avator@webproduction.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ValidatorSubUrl extends Forms_AValidator {

    public function __construct($shopurl = true) {
        // если true для проверки внутрених уролов, если фолст то проверяет внешние урлы
        $this->_shopurl = $shopurl;
    }

    public function validate($data) {
        if(!empty($data)){
            if (!$this->_shopurl && Checker::CheckURL($data)) {
                return true;
            } else {
                return preg_match("/^[a-zA-Z0-9\-\_a-zA-Z0-9]+$/", $data);
            }
        } elseif (empty($data)) {
        	return true;
        }
    }

    private $_shopurl;

}