<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Утилитный класс, позволяющий быстро сложить XML-файл
 * из разных источников: из массива, SQLObject'a, ...
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package XML
 */
class XML_Creator {

    /**
     * Создать XML на основании 2D-assoc-массива
     *
     * @param array $array
     * @return XML_Creator
     */
    public static function CreateFromArray($array) {
        return new self($array);
    }

    /**
	 * Конструктор приватный,
	 * но клонировать объект при этом - можно.
	 *
	 * @param array $array
	 */
    private function __construct($array) {
        $this->_array = $array;
    }

    private function _makeXML($array, $formattedLevel = false) {
        $identSeparator = '';
        if ($formattedLevel !== false) {
            for ($j = 1; $j < $formattedLevel; $j++) {
                $identSeparator .= $this->_identSeparator;
            }
        }

        $xml = '';
        foreach ($array as $k => $v) {
            // проходимся по переданныму массиву.

            if (is_array($v)) {
                // сначала проверяем, есть ли атрибуты
                $attributes = '';

                if (isset($v['@attributes'])) {
                    // строим дополнение к имени тега

                    $tmp = array();
                    foreach ($v['@attributes'] as $ak => $av) {
                        $tmp[] = $ak.'="'.$av.'"';
                    }
                    $attributes = ' '.join(' ', $tmp);

                    // убираем атрибуты
                    unset($v['@attributes']);
                }

                // проверяем, ассоциативный или нет
                if (key_exists(0, $v)) {
                    // это индексный массив
                    foreach ($v as $ak => $av) {
                        if ($formattedLevel !== false) {
                            $xml .= $identSeparator;
                        }
                        $xml .= "<$k$attributes>";
                        if ($formattedLevel !== false) {
                            $xml .= $this->_identBreak;
                        }

                        $xml .= $this->_makeXML($av, $formattedLevel === false ? false : $formattedLevel + 1);

                        if ($formattedLevel !== false) {
                            $xml .= $identSeparator;
                        }
                        $xml .= "</$k>";
                        if ($formattedLevel !== false) {
                            $xml .= $this->_identBreak;
                        }
                    }
                } else {
                    // это ассоциативный массив
                    // рекурсия
                    if ($formattedLevel !== false) {
                        $xml .= $identSeparator;
                    }
                    $xml .= "<$k$attributes>";
                    if ($formattedLevel !== false) {
                        $xml .= "\n";
                    }

                    $xml .= $this->_makeXML($v, $formattedLevel === false ? false : $formattedLevel + 1);

                    if ($formattedLevel !== false) {
                        $xml .= $identSeparator;
                    }
                    $xml .= "</$k>";
                    if ($formattedLevel !== false) {
                        $xml .= $this->_identBreak;
                    }
                }
            } else {
                // это строковое значение
                if ($formattedLevel !== false) {
                    $xml .= $identSeparator;
                }
                if (preg_match("/([<>\&]+)/uis", $v)) {
                    $xml .= "<$k><![CDATA[$v]]></$k>";
                } else {
                    $xml .= "<$k>$v</$k>";
                }
                if ($formattedLevel !== false) {
                    $xml .= $this->_identBreak;
                }
            }
        }
        return $xml;
    }

    public function render($formatted = false) {
        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        if ($formatted) {
            $xml .= "\n";
        }
        $xml .= $this->_makeXML($this->_array, $formatted);
        return $xml;
    }

    public function __toString() {
        return $this->render();
    }

    public function setIdentSeparator($separator) {
        $this->_identSeparator = $separator;
    }

    public function setIdentBreak($break) {
        $this->_identBreak = $break;
    }

    private $_array = array();

    private $_identSeparator = '    ';

    private $_identBreak = "\n";

}