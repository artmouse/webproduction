<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Виртуальный DataSource для работы с полями типа Enum.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
abstract class Forms_ADataSourceEnum extends Forms_ADataSource {

    public function __construct($optionsArray = false) {
        if ($optionsArray && is_array($optionsArray)) {
            foreach ($optionsArray as $key => $value) {
                $this->addOption($key, $value);
            }
        }
    }

    /**
     * Добавить option в источник
     *
     * @param string $key
     * @param string $value
     */
    public function addOption($key, $value) {
        $this->_optionsArray[$key] = $value;
    }

    protected function _initialize() {
        $x = new Forms_ContentField('id');
        $x->setEditable(false);
        $x->setSortable(false);
        $this->addField($x);

        $x = new Forms_ContentField('name');
        $x->setEditable(false);
        $x->setSortable(false);
        $this->addField($x);
    }

    public function select($filtersArray = array(), $sortBy = false, $sortType = 'ASC', $limitFrom = false, $limitCount = false, $count = false) {
        $a = array();
        if (isset($filtersArray[0]) && $filtersArray[0]->getKey() == 'id') {
            $x = $filtersArray[0]->getValue();

            if (isset($this->_optionsArray[$x])) {
                return (array(array(
                'id' => $x,
                'name' => $this->_optionsArray[$x],
                )));
            } else {
                return array();
            }
        }
        foreach ($this->_optionsArray as $key => $value) {
            $a[] = array(
            'id' => $key,
            'name' => $value,
            );
        }
        return $a;

        $sqlobject = $this->getSQLObject();

        if ($filtersArray) {
            foreach ($filtersArray as $key => $value) {
                if (is_object($value)) {
                    if ($value->getExpression()) {
                        $sqlobject->addWhereQuery(
                        $value->getKey().' '.$value->getValue()
                        );
                    } else {
                        $sqlobject->addWhere(
                        $value->getKey(),
                        $value->getValue()
                        );
                    }
                } else {
                    $sqlobject->addWhere($key, $value);
                }
            }
        }

        $sqlobject->setLimit($limitFrom, $limitCount);
        if ($count) {
            return $sqlobject->getCount();
        }

        if ($sortBy) {
            $sqlobject->setOrder($sortBy, $sortType);
        }

        $fieldsArray = $this->getFieldsArray();

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
        throw new Forms_Exception();
    }

    public function delete($key) {
        throw new Forms_Exception();
    }

    public function update($key, $fieldsArray) {
        throw new Forms_Exception();
    }

    private $_optionsArray = array();

}