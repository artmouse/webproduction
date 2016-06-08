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
class Forms_ContentFieldCKEditor extends Forms_ContentFieldTextarea {

	public function __construct($key) {
	    PackageLoader::Get()->import('CKEditor');

        parent::__construct($key);

        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'_Control.html');
    }

    /**
	 * Отрисовать поле для просмотра (в табличном выводе, например).
	 *
	 * @param int $rowIndex
	 * @param array $cellsArray
	 * @return string
	 */
    public function renderView($rowIndex, $cellsArray) {
        $value = @strip_tags($cellsArray[$this->getKey()]);

        // если можно ограничить запись - ограничиеваем ее
        if (PackageLoader::Get()->isImported('StringUtils')) {
            $l = $this->getViewLimitLength();
            if ($l > 0) {
                $value = StringUtils_Limiter::LimitLength($value, $l);
            }
        }

        return $value;
    }

}