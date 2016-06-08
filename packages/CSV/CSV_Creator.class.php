<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.com.ua>
 */

/**
 * Утилитный класс, позволяющий быстро сложить CSV-файл
 * из разных источников: из массива, SQLObject'a, ...
 *
 * CSV - Comma Separated Values
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package CSV
 */
class CSV_Creator {

    /**
     * Создать CSV на основании 2D-assoc-массива.
     * Ключи первой строки задают заголовки CSV-файла.
     *
     * @param array $array
     * @param bool $headers
     * @return CSV_Creator
     */
    public static function CreateFromArray($array, $headers = true) {
        return new self($array, $headers);
    }

    /**
	 * Конструктор приватный,
	 * но клонировать объект при этом - можно.
	 *
	 * @param array $array
	 * @param bool $headers
	 */
    private function __construct($array, $headers) {
        $this->_array = $array;
        $this->_headers = (bool) $headers;
    }

    private function _makeCSVString($string) {
        // чтобы MS Excel правильно понимал числа, нужно ставить запятую
        // вместо точки
        if (preg_match("/^(\d+)$/ius", $string)) {
        	$string = str_replace('.', ',', $string);
        }
        // @todo: экранирование
        return $string;
    }

    public function __toString() {
        $csv = '';
        $headersArray = array();
        foreach ($this->_array as $row) {
            if (!$headersArray) {
                // если еще нет заголовков - построим их
                foreach ($row as $k => $v) {
                    $headersArray[] = $k;
                    // если разрешено формировать заголовки
                    if ($this->_headers) {
                        $csv .= $this->_makeCSVString($k);
                        $csv .= ';';
                    }
                }
                $csv .= "\n";
            }

            foreach ($headersArray as $k) {
                $csv .= $this->_makeCSVString(@$row[$k]);
                $csv .= ';';
            }
            $csv .= "\n";
        }
        return $csv;
    }

    /**
     * Записать CSV-данные в файл.
     * Если файл не указан - формируется временный и возвращается его имя.
     *
     * @param string $filename
     * @return string
     */
    public function __toFile($filename = false) {
        $data = $this->__toString();
        $md5 = md5($data);

        // если нет имени файла - формируем его
        // во временном хранилище
        if (!$filename) {
            $filename = dirname(__FILE__).'/tmp/'.$md5.'.csv';
        }

        // записываем
        file_put_contents(
        $filename,
        $data,
        LOCK_EX
        );

        // возвращаем имя файла
        return $filename;
    }

    private $_array = array();

    private $_headers = true;

}