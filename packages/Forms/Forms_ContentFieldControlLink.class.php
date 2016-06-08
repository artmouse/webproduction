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
class Forms_ContentFieldControlLink extends Forms_ContentField {

    public function __construct($keyValue, $contentID, $keyName = 'key') {
        parent::__construct($keyValue);

        $this->_keyName = $keyName;

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
        $this->_contentID = $contentID;
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $key = $this->getKey();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();
        $assigns['value'] = @$cellsArray[$key];
        $assigns['valueExists'] = (@$cellsArray[$key] !== false);
        $assigns['url'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
        $this->_contentID,
        @$cellsArray[$keyPrimary],
        $this->_keyName);

        return $this->getContentView()->render($assigns);
    }

    private $_contentID = 0;

    private $_keyName = 'key';

}