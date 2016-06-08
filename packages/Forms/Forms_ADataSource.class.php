<?php
/**
 * WebProduction Packages
 *
 * Copyright (C) 2007-2011 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Источник данных для Forms
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Forms
 */
abstract class Forms_ADataSource {

    /**
     * Получить массив всех полей структуры
     *
     * @return array of Forms_ContentField
     */
    public function getFieldsArray() {
        if (!$this->_initialized) {
            // бросам событие, к которому можно будет прицепиться и дописать что-то в DataSource
            $eventName = get_class($this).'.initialize.before';
            // быстрая проверка на "есть или нет" события
            if (Events::Get()->hasEvent($eventName)) {
                $event = Events::Get()->generateEvent($eventName);
                $event->setObject($this);
                $event->notify();

                // получаем подмененное значение
                $value = $event->getFieldValue();
            }

            $this->_initialize();

            // бросам событие, к которому можно будет прицепиться и дописать что-то в DataSource
            $eventName = get_class($this).'.initialize.after';
            // быстрая проверка на "есть или нет" события
            if (Events::Get()->hasEvent($eventName)) {
                $event = Events::Get()->generateEvent($eventName);
                $event->setObject($this);
                $event->notify();
            }

            $this->_initialized = true;
        }
        return $this->_fieldsArray;
    }

    /**
     * Получить поле по его ключу
     *
     * @param string $key
     *
     * @return Forms_ContentField
     */
    public function getField($key) {
        if (!$this->_fieldsKeysArray) {
            $a = $this->getFieldsArray();
            foreach ($a as $f) {
                $this->_fieldsKeysArray[$f->getKey()] = $f;
            }
        }

        if (isset($this->_fieldsKeysArray[$key])) {
            return $this->_fieldsKeysArray[$key];
        }

        throw new Forms_Exception("Field by key '{$key}' not found");
    }
    
    /**
     * Зарегистрировать поле в DataSource
     *
     * @param Forms_ContentField $field
     * @param $count
     */
    public function addField(Forms_ContentField $field, $count = false) {
        // устанавливаем datasource
        $field->setDataSourceGroup($this);

        if ($count) {
            $arr1 = array_slice($this->_fieldsArray, 0, $count);
            $arr2 = array_slice($this->_fieldsArray, $count-1);

            $this->_fieldsArray = array_merge($arr1, array($field), $arr2);
        } else {
            // регистрируем поле
            $this->_fieldsArray[] = $field;
        }

        // сбрасываем инициализацию
        $this->_initialized = false;
    }

    /**
     * Получить primary-поле
     * По умолчанию это id.
     *
     * @return Forms_ContentField
     */
    public function getFieldPrimary() {
        return $this->getField('id');
    }

    /**
     * Получить preview-поле (по умолчанию это name)
     *
     * @return Forms_ContentField
     */
    public function getFieldPreview() {
        return $this->getField('name');
    }

    /**
     * Получить parent-поле
     * По умолчанию это parentid
     *
     * @return Forms_ContentField
     */
    public function getFieldParent() {
        return $this->getField('parentid');
    }

    abstract public function select($filtersArray = array(), $sortBy = false, $sortType = 'ASC',
    $limitFrom = false, $limitCount = false, $count = false);

    /**
     * Выполнить вставку данных в datasource.
     *
     * Значения для вставки спрашивать через field->getValue()
     *
     * Метод дожен вернуть primary key из datasource, который
     * был вставлен.
     *
     * @param array $fieldsArray Массив Forms_ContentField-полей, подлажащих вставке
     *
     * @return string
     */
    abstract public function insert($fieldsArray);

    /**
     * Удалить данные из datasource'a с определенным ключем
     *
     * @param string $key
     */
    abstract public function delete($key);

    /**
     * Обновить данные в datasource.
     * Вторым параметром передается массив полей,
     * по которым пришли данные (array of Forms_ContentField).
     *
     * @param array $fieldsArray
     * @param string $key
     */
    abstract public function update($key, $fieldsArray);

    /**
     * Инициализация DataSource.
     * Вызывается один раз перед любым дерганьем чего-либо из DataSource
     *
     * @todo Разобраться с концепцией
     */
    abstract protected function _initialize();

    private $_initialized = false;

    private $_fieldsArray = array();

    private $_fieldsKeysArray = array();

}