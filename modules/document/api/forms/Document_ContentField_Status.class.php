<?php
/**
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Document_ContentField_Status extends Forms_ContentField {

    public function __construct($keyValue) {
        parent::__construct($keyValue);
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();

        $sdate = @$cellsArray['sdate'];
        $bdate = @$cellsArray['bdate'];
        $adate = @$cellsArray['adate'];
        $file = @$cellsArray['file'];

        $status = 'Новый';

        if ($sdate && $sdate != '0000-00-00 00:00:00') {
            $status = 'Документ отправлен';
        }

        if ($bdate && $bdate != '0000-00-00 00:00:00') {
            $status = 'Документ получен';
        }

        if ($adate && $adate != '0000-00-00 00:00:00') {
            $status = 'Документ в архиве';
        }

        $assigns['status'] = $status;
        $assigns['scan'] = ($file) ? 'Скан приложен' : 'Скан не приложен';

        return $this->getContentView()->render($assigns);
    }

}