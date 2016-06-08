<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2014 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldTextarea extends Forms_ContentField {

    public function __construct($key) {
        parent::__construct($key);

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
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
        $value = @htmlspecialchars($cellsArray[$this->getKey()]);

        // если можно ограничить запись - ограничиеваем ее
        if (PackageLoader::Get()->isImported('StringUtils')) {
            $l = $this->getViewLimitLength();
            if ($l > 0) {
                $valueSmall = StringUtils_Limiter::LimitLength($value, $l);

                if ($valueSmall == $value) {
                    return $valueSmall;
                }

                return $this->getContentView()->render(array(
                'value' => $valueSmall,
                'hint' => $value
                ));
            }
        }

        return $value;
    }

    /**
     * Отрисовать контрол поля
     * для форм редактирования / добавления
     *
     * @param mixed $value
     * @return string
     */
    public function renderControl($value = false) {
        $assigns = array();

        $assigns['name'] = $this->getName();
        $assigns['key'] = $this->getKey();
        $assigns['value'] = $value;
        $assigns['disabled'] = $this->getDisabled();

        return $this->getContentControl()->render($assigns);
    }

    public function setViewLimitLength($length) {
        $this->_viewLimitLength = $length;
    }

    public function getViewLimitLength() {
        return $this->_viewLimitLength;
    }

    private $_viewLimitLength = 30;

}