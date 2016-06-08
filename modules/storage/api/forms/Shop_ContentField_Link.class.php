<?php
/**
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Shop_ContentField_Link extends Forms_ContentField {

    public function __construct($keyValue, $contentID, $linkKey = 'id', $linkKeyName = 'id') {
        parent::__construct($keyValue);

        $this->_contentID = $contentID;
        $this->_linkKey = $linkKey;
        $this->_linkKeyName = $linkKeyName;

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();
        $key = $this->getKey();
        
        $assigns['value'] = @$cellsArray[$key];
        $assigns['valueExists'] = (@$cellsArray[$key] !== false);
        $assigns['url'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
        $this->_contentID,
        @$cellsArray[$this->_linkKey],
        $this->_linkKeyName);

        return $this->getContentView()->render($assigns);
    }

    private $_contentID = 0;
    private $_linkKey = 'id';
    private $_linkKeyName = 'id';
}