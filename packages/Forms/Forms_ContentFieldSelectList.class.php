<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Выпадающий список (поле-ссылка).
 * На отображении обычная ссылка.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldSelectList extends Forms_ContentField {

    public function __construct($key, $allowEmptyOption = false) {
        parent::__construct($key);

        $this->_allowEmptyOption = $allowEmptyOption;

        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'_Control.html');
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderControl($value = false) {
        $assigns = array();

        $assigns['name'] = $this->getName();
        $assigns['key'] = $this->getKey();
        $assigns['value'] = $value;

        // строим массив option-ов
        $a = array();

        if ($this->_allowEmptyOption) {
            $a[] = array(
            'value' => $this->_emptyOptionValue,
            'name' => '---',
            );
        }

        $datasource = clone $this->getDataSource();

        $options = $datasource->select();
        foreach ($options as $x) {
            $a[] = array(
            'value' => $x[$datasource->getFieldPrimary()->getKey()],
            'name' => $x[$datasource->getFieldPreview()->getKey()],
            );
        }
        $assigns['optionsArray'] = $a;
        $assigns['disabled'] = $this->getDisabled();

        return $this->getContentControl()->render($assigns);
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();

        $value = @$cellsArray[$this->getKey()];
        $datasource = clone $this->getDataSource();

        $url = false;
        try {
            $filter = new Forms_FilterObject(
            $datasource->getFieldPrimary()->getKey(),
            $value
            );

            $valueString = $datasource->select(
            array($filter),
            false, false,
            0, 1
            );

            $valueString = @$valueString[0][$datasource->getFieldPreview()->getKey()];
            if (!$valueString) {
                $valueString = $value;
            }

            // строим гиперссылку
            if ($this->_controlLinkContentID) {
                $url = Engine::GetLinkMaker()->makeURLByContentIDParam(
                $this->_controlLinkContentID,
                $value,
                $this->_controlLinkContentKey);
            }

        } catch (Exception $e) {
            $valueString = $value;
            $url = false;
        }

        if ($valueString == (string) $this->getEmptyOptionValue()) {
            $valueString = $this->getEmptyOptionName();
        }

        $assigns['key'] = $this->getKey();
        $assigns['value'] = $valueString;
        $assigns['url'] = $url;

        return $this->getContentView()->render($assigns);
    }

    /**
     * Задать правила формирования гиперссылки в отображении.
     * По умолчанию ничего не задано.
     *
     * @param string $contentID
     * @param string $keyName
     */
    public function setControlLink($contentID, $keyName = 'key') {
        $this->_controlLinkContentID = $contentID;
        $this->_controlLinkContentKey = $keyName;
    }

    /**
     * Задать значение empty-option'a. По умолчанию пустая строка ''
     *
     * @param mixed $value
     */
    public function setEmptyOptionValue($value) {
        $this->_emptyOptionValue = $value;
    }

    /**
     * Получить значение empty-option'a.
     * По умолчанию пустая строка ''
     *
     * @return mixed
     */
    public function getEmptyOptionValue() {
        return $this->_emptyOptionValue;
    }

    /**
     * Задать отображаемое значение empty-option'a.
     *
     * @param string $name
     */
    public function setEmptyOptionName($name) {
        $this->_emptyOptionName = $name;
    }

    /**
     * Получить отображаемое значение empty-option'a.
     * По умолчанию пустая строка ''
     *
     * @return return
     */
    public function getEmptyOptionName() {
        return $this->_emptyOptionName;
    }

    private $_controlLinkContentID = false;

    private $_controlLinkContentKey = false;

    protected $_allowEmptyOption = false;

    private $_emptyOptionValue = '';

    private $_emptyOptionName = '';

}