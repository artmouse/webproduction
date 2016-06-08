<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

class Forms_ContentFieldControlLinkParams extends Forms_ContentField {

    public function __construct($keyValue, $contentID, $keyArray) {
        parent::__construct($keyValue);

        $this->_keyName = $keyArray;

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
        $this->_contentID = $contentID;
    }

    public function renderView($rowIndex, $cellsArray) {
        $rowIndex = false;
        $assigns = array();
        $urlArray = $this->_keyName;
        foreach ($urlArray as $key => $item) {
            $urlArray[$key] = $cellsArray[$key];
        }
        $key = $this->getKey();
        $assigns['value'] = @$cellsArray[$key];
        $assigns['valueExists'] = (@$cellsArray[$key] !== false);
        $assigns['url'] = Engine::GetLinkMaker()->makeURLByContentIDParams(
            $this->_contentID,
            $urlArray
        );

        return $this->getContentView()->render($assigns);
    }

    private $_contentID = 0;

    private $_keyName = array();

}