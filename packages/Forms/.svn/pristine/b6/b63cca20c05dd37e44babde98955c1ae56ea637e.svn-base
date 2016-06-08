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
class Forms_ContentField {

    public function __construct($key) {
        $this->_key = $key;
        $this->_name = $key;

        $this->_options = new Forms_Options();
        $this->getOptions()->setName($key);

        $this->setContentView(new Forms_Content());
        $this->setContentControl(new Forms_Content());

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'_Control.html');
    }

    /**
     * Резрешено ли tablelike по данному полю
     *
     * @return bool
     */
    public function getTablelike() {
        return $this->_tablelike;
    }

    /**
     * Разрешить/запретить tablelike по данному полю
     *
     * @param bool $allow
     */
    public function setTablelike($allow) {
        $this->_tablelike = (bool) $allow;
    }

    /**
     * @return bool
     */
    public function getQuickedit() {
        return $this->_quickedit;
    }

    /**
     * @param $allow
     */
    public function setQuickedit($allow) {
        $this->_quickedit = (bool) $allow;
    }

    /**
     * Служебное поле для связи с внутренним источником данных.
     * Например, имя таблицы и поля в таблице.
     *
     * @param string $link
     */
    public function setLink($link) {
        $this->_link = $link;
    }

    /**
     * Служебное поле для связи с внутренним источником данных.
     * Например, имя таблицы и поля в таблице.
     *
     * @return string
     */
    public function getLink() {
        $link = $this->_link;
        if (!$link) {
            return $this->getKey();
        }
        return $link;
    }

    /**
     * @return Forms_Content
     */
    public function getContentView() {
        return $this->_contentView;
    }

    /**
     * @param Forms_Content $content
     */
    public function setContentView(Forms_Content $content) {
        $this->_contentView = $content;
    }

    /**
     * @return Forms_Content
     */
    public function getContentControl() {
        return $this->_contentControl;
    }

    /**
     * @param Forms_Content $content
     */
    public function setContentControl(Forms_Content $content) {
        $this->_contentControl = $content;
    }

    /**
	 * @param bool $sortable
	 */
    public function setSortable($sortable) {
        $this->_sortable = $sortable;
    }

    /**
     * @return bool
     */
    public function getSortable() {
        return $this->_sortable;
    }

    /**
     * @return mixed
     */
    public function getName() {
        if ($this->getTranslateField()) {
            try {
                return $this->getTranslate();
            } catch (Exception $e) {}
        }
        return $this->_name;
    }

    /**
     * @param $name
     */
    public function setName($name) {
        $this->_name = $name;
    }

    /**
	 * Получить уникальный ключ поля
	 * (техническое имя)
	 *
	 * @return string
	 */
    public function getKey() {
        return $this->_key;
    }

    /**
     * Можно ли редактировать поле.
     * Будет ли оно доступно в формах.
     *
     * @return bool
     */
    public function getEditable() {
        return $this->_editable;
    }

    /**
     * Можно ли редактировать поле.
     * Будет ли оно доступно в формах.
     *
     * @param bool $editable
     */
    public function setEditable($editable) {
        $this->_editable = $editable;
    }

    /**
     * Можно переводить название поля в форме или нет
     *
     * @return bool
     */
    public function getTranslateField() {
        return $this->_translatefield;
    }

    /**
     * Можно переводить название поля в форме или нет
     *
     * @param bool $translatefield
     */
    public function setTranslateField($translatefield) {
        $this->_translatefield = (bool) $translatefield;
    }

    /**
     * Получить перевод по данному полю
     *
     * @return mixed
     */
    public function getTranslate() {
        return Forms_Translate::Get()->getTranslate($this->getKey());
    }

    /**
     * Изменить перевод по данному полю
     *
     * @param $translate
     */
    public function setTranslate($translate) {
        Forms_Translate::Get()->setTranslate($this->getKey(), $translate);
    }

    /**
	 * @return Forms_ADataSource
	 */
    public function getDataSource() {
        if (!$this->_datasource instanceof Forms_ADataSource) {
            throw new Forms_Exception("No datasource in field {$this->getKey()}");
        }
        return $this->_datasource;
    }

    /**
	 * Задать datasource для поля.
	 * Например, если поле categoryid - то из какого источника данных
	 * брать информацию по категориям.
	 *
	 * @param Forms_ADataSource $datasource
	 */
    public function setDataSource(Forms_ADataSource $datasource) {
        $this->_datasource = $datasource;
    }

    /**
     * Получить datasource-группу, в которую входит это поле
     *
     * @return Forms_ADataSource
     */
    public function getDataSourceGroup() {
        if (!$this->_datasourceGroup instanceof Forms_ADataSource) {
            throw new Forms_Exception("No datasource group in field {$this->getKey()}");
        }
        return $this->_datasourceGroup;
    }

    /**
     * Задать datasource-группу, в которую входит это поле
     *
     * @param Forms_ADataSource $datasource
     */
    public function setDataSourceGroup(Forms_ADataSource $datasource) {
        $this->_datasourceGroup = $datasource;
    }

    /**
	 * Отрисовать поле для просмотра (в табличном выводе, например).
	 *
	 * @param int $rowIndex
	 * @param array $cellsArray
	 * @return string
	 */
    public function renderView($rowIndex, $cellsArray) {
        return htmlspecialchars(@$cellsArray[$this->getKey()]);
    }

    /**
     * Отрисовать контрол поля для форм редактирования / добавления
     *
     * @param mixed $value
     * @return string
     */
    public function renderControl($value = false) {
        $assigns = array();

        $assigns['name'] = $this->getName();
        $assigns['key'] = $this->getKey();
        $assigns['value'] = $value;
        $assigns['disabled'] = $this->_disabled;
        $assigns['valid'] = $this->_validateState;
        $assigns['control_value'] = @htmlspecialchars($value);

        return $this->getContentControl()->render($assigns);
    }

    /**
     * Получить значение во введенный элемент
     *
     * @return string
     */
    public function getValue() {
        return Engine::GetURLParser()->getArgumentSecure($this->getKey());
    }

    /**
     * Включить поле в формах.
     */
    public function setEnabled() {
        $this->_disabled = false;
    }

    /**
     * Выключить поле в формах.
     */
    public function setDisabled() {
        $this->_disabled = true;
    }

    /**
     * Выключено (off) ли поле в формах?
     *
     * @return bool
     */
    public function getDisabled() {
        return $this->_disabled;
    }

    /**
     * Включено (on) ли поле в формах?
     *
     * @return bool
     */
    public function getEnabled() {
        return !$this->_disabled;
    }

    /**
     * @return Forms_Options
     */
    public function getOptions() {
        return $this->_options;
    }

    /**
     * Получить массив валидаторов.
     * Array of Forms_AValidator
     *
     * @return array
     */
    public function getValidatorsArray() {
        return $this->_validatorsArray;
    }

    public function clearValidators() {
        $this->_validatorsArray = array();
    }

    /**
     * Добавить валидатор поля
     *
     * @param Forms_AValidator $validator
     */
    public function addValidator(Forms_AValidator $validator) {
        $this->_validatorsArray[] = $validator;
    }

    /**
     * Валидировать поля
     *
     * @return bool
     */
    public function validate() {
        try {
            $value = $this->getValue();
        } catch (Exception $e) {
            $value = false;
        }
        $result = true;

        foreach ($this->getValidatorsArray() as $validator) {
            if (!$validator->validate($value)) {
                $result = false;
                $this->_validateState = false;
            }
        }
        return $result;
    }

    public function setValidateState($state) {
        $this->_validateState = $state;
    }

    public function getValidateState() {
        return $this->_validateState;
    }

    private $_contentView;

    private $_contentControl;

    private $_editable = true;

    private $_key;

    private $_name;

    private $_sortable = true;

    private $_disabled = false;

    private $_link = false;

    private $_datasource = null;

    private $_datasourceGroup = null;

    private $_options;

    private $_validatorsArray = array();

    private $_validateState = true;

    private $_tablelike = false;

    private $_quickedit = false;

    private $_translatefield = true;

}