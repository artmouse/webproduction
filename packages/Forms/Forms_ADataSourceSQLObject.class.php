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
abstract class Forms_ADataSourceSQLObject extends Forms_ADataSource {

    public function __construct() {
        PackageLoader::Get()->import('SQLObject');
    }

    /**
     * @return SQLObject
     */
    abstract public function getSQLObject();

    protected function _initialize() {
        $fieldsArray = $this->getSQLObject()->getFields();

        foreach ($fieldsArray as $field) {
            // делаем describe каждого поля, чтобы узнать тип данных
            // @todo: перенести в утилитные методы с кешированием
            $q = ConnectionManager::Get()->getConnectionDatabase()->query("DESCRIBE `{$this->getSQLObject()->getTablename()}` `{$field}`");
            $type = mysql_fetch_assoc($q);
            $type = $type['Type'];

            if ($field == 'id') {
                $x = new Forms_ContentFieldInt($field);
                $x->setEditable(false);
            } elseif ($type == 'tinyint(1)') {
                $x = new Forms_ContentFieldCheckbox($field);
            } elseif ($type == 'int(11)') {
                $x = new Forms_ContentFieldInt($field);
            } elseif ($type == 'text') {
                $x = new Forms_ContentFieldTextarea($field);
            } else {
                $x = new Forms_ContentField($field);
            }
            $x->setName($field);
            $this->addField($x);
        }
    }

    public function select($filtersArray = array(), $sortBy = false, $sortType = 'ASC', $limitFrom = false, $limitCount = false, $count = false) {
        $sqlobject = $this->getSQLObject();

        $fieldsArray = $this->getFieldsArray();

        // превращаем массив в ассоциативный для более быстрого доступа по ключу
        // это полезно в случае связи с другими таблицами
        foreach ($fieldsArray as $key => $field) {
            $fieldsArray[$field->getKey()] = $field;
            unset($fieldsArray[$key]);
        }

        if (!$count
        && is_array($filtersArray)
        && count($filtersArray) == 1
        && !$sqlobject->hasConditions()) {

            if ($filtersArray[0]->getKey() == $sqlobject->getPrimaryKey()
            && $filtersArray[0]->getExpression() == false) {
                // достаем из SQLObject'a с учетом кеша

                $r = SQLObject::GetObject(
                $sqlobject->getClassname(),
                $filtersArray[0]->getValue()
                );

                $b = array();
                foreach ($fieldsArray as $f) {
                    $b[$f->getKey()] = $r->getField($f->getLink());
                }
                return array($b);
            }
        }

        $tablelike = false;
        $filterRule = '';

        $whereArray = array();

        $connection = $this->getSQLObject()->getConnectionDatabase();

        if ($filtersArray) {
            foreach ($filtersArray as $key => $value) {
                if (is_object($value)) {
                    $key = $value->getKey();

                    // отлов специального фильтра
                    if ($key == 'filterrule') {
                        $filterRule = $value->getValue();
                        continue;
                    }

                    // отлов специального фильтра
                    if ($key == 'tablelike') {
                        $tablelike = $value->getValue();
                        continue;
                    }

                    if ($value->getExpression()) {
                        $whereArray[] = $fieldsArray[$value->getKey()]->getLink().' '.$value->getValue();
                    } else {
                        $whereArray[] = $fieldsArray[$value->getKey()]->getLink()." = '".$connection->escapeString($value->getValue())."'";
                    }
                } else {
                    $whereArray[] = $fieldsArray[$key]->getLink()." = '".$connection->escapeString($value)."'";
                }
            }
        }

        // all/any filter rule
        if ($filterRule == 'any') {
        	$filterRule = ' OR ';
        } else {
            $filterRule = ' AND ';
        }

        if ($whereArray) {
        	$sqlobject->addWhereQuery('('.implode($filterRule, $whereArray).')');
        }

        // массовый like по таблице
        if ($tablelike) {
            $tablelike = $connection->escapeString($tablelike);
            $w = array();
            foreach ($fieldsArray as $field) {
                if (!$field->getTablelike()) {
                    continue;
                }

                $w[] = $field->getLink().' LIKE \''.$tablelike.'%\'';
            }
            if ($w) {
                $sqlobject->addWhereQuery("(".implode(' OR ', $w).")");
            }
        }

        $sqlobject->setLimit($limitFrom, $limitCount);
        if ($count) {
            return $sqlobject->getCount();
        }

        if ($sortBy) {
            $sqlobject->setOrder($sortBy, $sortType);
        }

        $a = array();
        while ($x = $sqlobject->getNext()) {
            $b = array();
            foreach ($fieldsArray as $f) {
                try {
                    $b[$f->getKey()] = $x->getField($f->getKey());
                } catch (Exception $e) {

                }
            }
            $a[] = $b;
        }
        return $a;
    }

    public function insert($fieldsArray) {
        $sqlobject = $this->getSQLObject();

        foreach ($fieldsArray as $field) {
            if ($field->getEditable()) {
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
            if ($field->getEditable()) {
                try {
                    $sqlobject->setField($field->getKey(), $field->getValue());
                } catch (Exception $e) {

                }
            }
        }

        $sqlobject->update();
    }

}