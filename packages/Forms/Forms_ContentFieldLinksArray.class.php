<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldLinksArray extends Forms_ContentField {

    public function __construct($key) {
        parent::__construct($key);

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function addLink($name, $url, $cssClassName = '') {
        $this->_linksArray[] = array(
        'name' => $name,
        'url' => $url,
        'css' => $cssClassName,
        );
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $assigns['linksArray'] = $this->_linksArray;
        return $this->getContentView()->render($assigns);
    }

    private $_linksArray = array();

}