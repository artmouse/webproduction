<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package CSV
 */
class CSV_Parser {

    /**
     * Распарсить CSV из строки.
     * $headers определяет сколько первых строк относиться к заголовкам
     *
     * @param string $csv
     * @param bool $headers
     * @return CSV_Parser
     */
    public static function CreateFromString($csv, $headers = 1, $separator = ';') {
        return new self($csv, $headers, $separator);
    }

    /**
     * Распарсить CSV из файла.
     * $headers определяет сколько первых строк относиться к заголовкам
     *
     * @param string $file
     * @param bool $headers
     * @return CSV_Parser
     */
    public static function CreateFromFile($file, $headers = 1, $separator = ';') {
        if (!file_exists($file)) {
            throw new CSV_Exception('File not exists');
        }
        return self::CreateFromString(file_get_contents($file), $headers, $separator);
    }

    public function __construct($csv, $headers = 1, $separator = ';') {
        $csv = str_replace(array("\r"), '', $csv);
        $csv = explode("\n", $csv);
        $index = 0;
        foreach ($csv as $line) {
            $line = trim($line);
            if (!$line) {
                continue;
            }

            if (function_exists('str_getcsv')) {
                $line = str_getcsv($line, $separator);
            } else {
                $line = explode($separator, $line);
            }

            if ($index == 0 && $headers > 0) {
                // it's first header
                foreach ($line as $x) {
                    $x = trim($x);
                    if ($x) {
                        $this->_headers[] = $x;
                    }
                }
            } else {
                // it's data
                $a = array();
                foreach ($line as $j => $x) {
                    $x = trim($x);
                    if ($headers) {
                        if (isset($this->_headers[$j])) {
                            $a[$this->_headers[$j]] = $x;
                        }
                    } else {
                        $a[] = $x;
                    }
                }
                $this->_data[] = $a;
            }

            $index++;
        }
    }

    /**
     * @param bool $assoc
     * @return array
     */
    public function toArray($assoc = true) {
        if ($assoc) {
            return $this->_data;
        } else {
            // @todo
        }
    }

    /**
     * Установить разделитель.
     * По умолчанию ";"
     *
     * @param string $separator
     */
    /*public function setSeparator($separator) {
    if (!$separator) {
    throw new CSV_Exception('Invalid separator');
    }
    $this->_separator = $separator;
    }*/

    /**
     * Получить разделитель колонок.
     * По умолчанию ";"
     *
     * @return string
     */
    /*public function getSeparator() {
    return $this->_separator;
    }*/

    private $_separator = ';';

    private $_data = array();

    private $_headers = array();

}