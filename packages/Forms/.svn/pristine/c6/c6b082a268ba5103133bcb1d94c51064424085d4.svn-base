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
abstract class Forms_ADataSourceSQLObjectPg extends Forms_ADataSource {

    /**
     * @return SQLObject
     */
    abstract public function getSQLObject();

    /**
     * Инициализация DataSource.
     * Вызывается один раз перед любым дерганьем чего-либо из DataSource
     *
     * @todo может все-таки конструктор?
     */
    protected function _initialize() {
        $sqlobject = $this->getSQLObject();

        // получаем все поля (строковый массив)
        $fieldsArray = $sqlobject->getFields();

        foreach ($fieldsArray as $field) {
            // делаем describe каждого поля, чтобы узнать тип данных
            $x = new Forms_ContentField($field);
            //$x->setLink($sqlobject->getTablename().'.'.$field); // ссылка на ячейку таблицы
            $x->setLink($field); // ссылка на ячейку таблицы
            $x->setName($field);
            $this->addField($x);
        }

        // для PgSQL поле primary key делаем по умолчанию not editable
        $this->getFieldPrimary()->setEditable(false);
    }

    /**
     * @return Forms_ContentField
     */
    public function getFieldPrimary() {
        // @todo: to usual sql object also
        return $this->getField($this->getSQLObject()->getPrimaryKey());
    }

    public function select($filtersArray = array(), $sortBy = false, $sortType = 'ASC', $limitFrom = false, $limitCount = false, $count = false) {
        $this->_initialize();

        $sqlobject = $this->getSQLObject();

        // @todo: возможно это все вынести как параметры
        // вместе с sort, limit, getcount
        if ($filtersArray) {
            foreach ($filtersArray as $filter) {
                $key = $filter->getKey();
                $key = $this->getField($key)->getLink();

                if ($filter->getExpression()) {
                    $sqlobject->addWhereQuery(
                    $key.' '.$filter->getValue()
                    );
                } else {
                    $sqlobject->addWhere(
                    $key,
                    $filter->getValue()
                    );
                }
            }
        }

        $sqlobject->setLimit($limitFrom, $limitCount);
        if ($count) {
            return $sqlobject->getCount();
        }

        if ($sortBy) {
            $sortBy = $this->getField($sortBy)->getLink();
            $sqlobject->setOrder($sortBy, $sortType);
        }

        $fieldsArray = $this->getFieldsArray();

        $a = array();
        while ($x = $sqlobject->getNext()) {
            $b = array();
            foreach ($fieldsArray as $f) {
                $b[$f->getKey()] = $x->getField($f->getLink());
            }
            $a[] = $b;
        }
        return $a;
    }

    public function insert($fieldsArray) {
        $sqlobject = $this->getSQLObject();

        foreach ($fieldsArray as $field) {
            if ($field->getEditable()
            && $field->getEnabled()
            ) {
                try {
                    $sqlobject->setField($field->getKey(), $field->getValue());
                } catch (Exception $e) {

                }
            }
        }

        $sqlobject->insert();

        return $sqlobject->getField($this->getFieldPrimary()->getKey());
    }

    public function delete($key) {
        $classname = $this->getSQLObject()->getClassname();
        $sqlobject = SQLObject::GetObject($classname, $key);
        $sqlobject->delete();
    }

    public function update($key, $fieldsArray) {
        $classname = $this->getSQLObject()->getClassname();
        $sqlobject = SQLObject::GetObject($classname, $key);

        foreach ($fieldsArray as $field) {
            if ($field->getEditable()
            && $field->getEnabled()
            ) {
                try {
                    $sqlobject->setField($field->getKey(), $field->getValue());
                } catch (Exception $e) {

                }

            }
        }

        $sqlobject->update();
    }

}