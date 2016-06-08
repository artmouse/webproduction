<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Универсальная форма: редактирование / добавление / удаление
 * данных из DataSource'a
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentForm extends Forms_Content {

    public function __construct($datasource) {
        $this->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');

        if ($datasource) {
            $this->setDataSource($datasource);
        }
    }

    public function denyInsert() {
        $this->_denyInsert = true;
    }

    public function denyUpdate() {
        $this->_denyUpdate = true;
    }

    public function denyDelete() {
        $this->_denyDelete = true;
    }

    public function disableForm() {
        $this->_enableForm = false;
    }

    public function enableForm() {
        $this->_enableForm = true;
    }

    /**
     * Узнать обработчик поля
     *
     * @param string $key
     * @return Forms_ContentField
     */
    public function getField($key) {
        return $this->_fieldsArray[$key];
    }

    /**
     * Задать обработчик поля
     *
     * @param Forms_ContentField $field
     */
    public function setField(Forms_ContentField $field) {
        $this->_fieldsArray[$field->getKey()] = $field;
    }


    /**
     * Удалить (скрыть) поле
     *
     * @param string $key
     */
    public function removeField($key) {
        unset($this->_fieldsArray[$key]);
    }

    /**
     * Установить источник данных
     *
     * @param Forms_ADataSource $datasource
     */
    public function setDataSource(Forms_ADataSource $datasource) {
        $this->_datasource = $datasource;

        $fieldsArray = $datasource->getFieldsArray();
        $a = array();
        foreach ($fieldsArray as $field) {
            $a[$field->getKey()] = $field;
        }

        $this->_fieldsArray = $a;
    }

    /**
     * @return Forms_ADataSource
     */
    public function getDataSource() {
        if (!$this->_datasource instanceof Forms_ADataSource) {
            throw new Forms_Exception('No datasource in Form');
        }
        return $this->_datasource;
    }

    /**
     * @return array
     */
    public function getFieldsArray() {
        return $this->_fieldsArray;
    }

    public function render($keyValue = false) {
        $assigns = array();
        //$assigns['cssClassName'] = $this->getCSSClassName();

        $key = $this->getDataSource()->getFieldPrimary()->getKey();

        // выборка записи по ключу
        if ($keyValue !== false) {
            // если передан ключ - то это update - и нужно показать данные
            $selectArray = $this->getDataSource()->select(
                array(new Forms_FilterObject($key, $keyValue)),
                false, false,
                0, 1
            );

            if (isset($selectArray[0])) {
                $selectArray = @$selectArray[0];

                // передаем ключ, чтобы форма знала, какие кнопки можно показать
                // для CRUD
                $assigns['datakey'] = $keyValue;
                $assigns['datakeyexists'] = true;
            } else {
                $assigns['nodata'] = true;
            }
        }

        // обновление записи
        if (!$this->_denyUpdate
        && Engine::GetURLParser()->getArgumentSecure('formsUpdate')
        && isset($selectArray)) {
            // нажали на кнопку update
            try {
                // @todo: транзакция?

                // проверка полей на валидность
                $fieldsArray = $this->getFieldsArray();
                $validateResult = true;
                foreach ($fieldsArray as $f) {
                    if ($f->getEditable()) {
                        if (!$f->validate()) {
                            $validateResult = false;
                        }
                    }
                }
                if (!$validateResult) {
                    throw new Forms_Exception();
                }

                $this->getDataSource()->update(
                $keyValue,
                $this->getFieldsArray()
                );

                // выбираем данные по первичному ключу
                $selectArray = $this->getDataSource()->select(
                array(new Forms_FilterObject($key, $keyValue)),
                false, false,
                0, 1
                );
                // @todo: а если нету? // хотя это маловероятно
                $selectArray = $selectArray[0];

                $assigns['message'] = 'updateok';
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
                $assigns['message'] = 'updateerror';
            }
        }

        // вставка новой записи
        $keyValueInserted = $this->renderInsert();
        if ($keyValueInserted) {
            $keyValue = $keyValueInserted;
        }

        // выборка записи по ключу
        if ($keyValue !== false) {
            // если передан ключ - то это update - и нужно показать данные
            $selectArray = $this->getDataSource()->select(
                array(new Forms_FilterObject($key, $keyValue)),
                false, false,
                0, 1
            );

            if (isset($selectArray[0])) {
                $selectArray = @$selectArray[0];

                // передаем ключ, чтобы форма знала, какие кнопки можно показать
                // для CRUD
                $assigns['datakey'] = $keyValue;
                $assigns['datakeyexists'] = true;
            } else {
               // $assigns['nodata'] = true;
            }
        }

        if (!$this->_denyDelete
        && Engine::GetURLParser()->getArgumentSecure('formsDelete')
        && isset($selectArray)) {
            // это delete
            try {
                $this->getDataSource()->delete($keyValue);

                $assigns['message'] = 'deleteok';
                // @todo: что делать после delete'a?
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
                $assigns['message'] = 'deleteerror';
            }
        }

        $a = array();
        foreach ($this->getFieldsArray() as $field) {
            if ($field->getEditable()
            ) {
                $value = @$selectArray[$field->getKey()];
                if (!$value) {
                    try {
                        $value = Engine::GetURLParser()->getArgument($field->getKey());
                    } catch (Exception $e) {

                    }
                }
                if (!$this->_enableForm) {
                    $field->setDisabled();
                }
                $a[] = array(
                'name' => $field->getName(),
                'control' => $field->renderControl($value),
                'hidden' => ($field instanceof Forms_ContentFieldHidden),
                );
            }
        }

        $assigns['controlsArray'] = $a;

        $assigns['allowDelete'] = !$this->_denyDelete;
        $assigns['allowInsert'] = !$this->_denyInsert;
        $assigns['allowUpdate'] = !$this->_denyUpdate;
        $assigns['disableForm'] = !$this->_enableForm;
        if (!$this->_enableForm) {
            $assigns['allowDelete'] = false;
            $assigns['allowInsert'] = false;
            $assigns['allowUpdate'] = false;
        }

        return parent::render($assigns);
    }

    public function renderInsert() {
        // @todo: нафиг отдельный метод еще и public
        if (!$this->_denyInsert
        && Engine::GetURLParser()->getArgumentSecure('formsInsert')) {
            // это insert
            try {
                // проверка полей на валидность
                $validateResult = true;
                $fieldsArray = $this->getFieldsArray();
                foreach ($fieldsArray as $f) {
                    if ($f->getEditable()) {
                        if (!$f->validate()) {
                            $validateResult = false;
                        }
                    }
                }
                if (!$validateResult) {
                    throw new Forms_Exception();
                }

                $key = $this->getDataSource()->insert($this->getFieldsArray());
                $this->setValue('message', 'insertok');
                return $key;
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
                $this->setValue('message', 'inserterror');
            }
        }

        return false;
    }

    private $_fieldsArray = array();

    private $_datasource = null;

    private $_denyInsert = false;

    private $_denyDelete = false;

    private $_denyUpdate = false;

    private $_enableForm = true;

    //private $_cssClassName = '';

    /*public function setCSSClassName($className) {
    $this->_cssClassName = $className;
    }

    public function getCSSClassName() {
    return $this->_cssClassName;
    }*/

}