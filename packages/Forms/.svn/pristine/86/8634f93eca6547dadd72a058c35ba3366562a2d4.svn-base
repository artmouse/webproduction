<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Дерево в select'e.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldSelectTree extends Forms_ContentFieldSelectList {

    public function __construct($key, $allowEmptyOption = false) {
        parent::__construct($key, $allowEmptyOption);

        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'_Control.html');
    }

    public function renderControl($value = false) {
        $assigns = array();

        $assigns['name'] = $this->getName();
        $assigns['key'] = $this->getKey();
        $assigns['value'] = $value;
        $assigns['allowEmptyOption'] = $this->_allowEmptyOption;

        // строим массив option-ов
        $listArray = array();

        $datasource = clone $this->getDataSource();

        $options = $datasource->select();
        foreach ($options as $x) {
            $parentValue = $x[$datasource->getFieldParent()->getKey()];

            $listArray[$parentValue][] = array(
            'value' => $x[$datasource->getFieldPrimary()->getKey()],
            'name' => $x[$datasource->getFieldPreview()->getKey()],
            );
        }

        $assigns['optionsArray'] = $this->_makeTree(0, 0, $listArray);

        return $this->getContentControl()->render($assigns);
    }

    private function _makeTree($parentID, $level, $listArray) {
        $a = array();
        if (empty($listArray[$parentID])) {
            return $a;
        }
        foreach ($listArray[$parentID] as $x) {
            $x['level'] = $level;
            $a[] = $x;
            $childs = $this->_makeTree($x['value'], $level + 1, $listArray);
            foreach ($childs as $y) {
                $a[] = $y;
            }
        }
        return $a;
    }

}