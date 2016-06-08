<?php
/**
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Shop_ContentField_Actions extends Forms_ContentField {

    public function __construct($keyValue, $actionArray) {
        parent::__construct($keyValue);

        $this->_actionArray = $actionArray;
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();

        $id = @$cellsArray[$keyPrimary];
        $actionArray = $this->_actionArray;
        
        if ($id && is_array($actionArray)) {
            $a = array();

            foreach ($actionArray as $x) {
                $a[] = array(
                'url' => Engine::GetLinkMaker()->makeURLByContentIDParam($x['contentID'], $id),
                'name' => $x['actionName']
                );
            }

            $assigns['actionAray'] = $a;
         }

        return $this->getContentView()->render($assigns);
    }

    private $_actionArray = array();
}