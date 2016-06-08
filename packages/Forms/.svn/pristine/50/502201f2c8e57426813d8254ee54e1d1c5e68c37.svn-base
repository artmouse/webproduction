<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Мультидерево.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldTree extends Forms_ContentField {

    public function __construct($key) {
        parent::__construct($key);

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'_Control.html');
    }

    public function renderControl($value = false) {
        $assigns = array();

        $assigns['name'] = $this->getName();
        $assigns['key'] = $this->getKey();
        //$assigns['value'] = $value;

        $a = array();

        // получаем все дерево
        $treeArray = $this->getDataSource()->select();

        // превращаем линейку в дерево
        $treeArray = $this->_makeTree($treeArray);

        foreach ($treeArray as $x) {
            $v = $x[$this->getDataSource()->getFieldPrimary()->getKey()];

            $a[] = array(
            'value' => $v,
            'name' => $x[$this->getDataSource()->getFieldPreview()->getKey()],
            'selected' => in_array($v, $value),
            'level' => $x['level'],
            );
        }
        $assigns['treeArray'] = $a;

        return $this->getContentControl()->render($assigns);
    }

    private function _makeTree($treeArray, $parentKey = 0, $level = 0) {
        $a = array();
        foreach ($treeArray as $x) {
            if ($x['parentid'] == $parentKey) {
                $x['level'] = $level;
            	$a[] = $x;

            	$tmp = $this->_makeTree($treeArray, $x['id'], $level + 1);
            	foreach ($tmp as $tmpx) {
            		$a[] = $tmpx;
            	}
            }
        }
        return $a;
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();

        $value = @$cellsArray[$this->getKey()];
        if (!$value) {
            $value = array();
        }
        if (!is_array($value)) {
            $value = array($value);
        }

        $a = array();
        // по каждому значению делаем запрос в источник:
        // дай мне название (preview-поле) элемента с таким ключем (key-поле)
        foreach ($value as $v) {
            $x = $this->getDataSource()->select(
            array($this->getDataSource()->getFieldPrimary()->getKey() => $v),
            false, false,
            0, 1
            );
            $a[] = @$x[0][$this->getDataSource()->getFieldPreview()->getKey()];
        }

        $assigns['key'] = $this->getKey();
        $assigns['valueArray'] = $a;

        return $this->getContentView()->render($assigns);
    }

}