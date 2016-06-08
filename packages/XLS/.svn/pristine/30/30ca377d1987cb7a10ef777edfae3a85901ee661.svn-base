<?php
/**
 * Утилитный класс, позволяющий быстро сложить XLS-файл
 * из разных источников: из массива, SQLObject'a, ...
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package XLS
 */
class XLS_Creator {

    /**
     * Создать CSV на основании 2D-assoc-массива.
     * Ключи первой строки задают заголовки XLS-файла.
     *
     * @param array $arrayshop_basket_buy
     * @return XLS_Creator
     */
    public static function CreateFromArray($array) {
        return new self($array);
    }

    private $_array = array();

    /**
	 * Конструктор приватный,
	 * но клонировать объект при этом - можно.
	 *
	 * @param array $array
	 */
    private function __construct($array) {
        $this->_array = $array;
    }

    public function __toString() {
        // require REAR::Spreadsheet_Excel_Writer
        require_once dirname(__FILE__)."/Spreadsheet/Excel/Writer.php";

        $filename = dirname(__FILE__).'/tmp/'.rand();

        $xls = new Spreadsheet_Excel_Writer($filename);
        $xls->setVersion(8);
        // $xls->_codepage = 0x04E3;
        $sheet = $xls->addWorksheet('List');
        $sheet->setInputEncoding('utf-8');

        $headersArray = array();
        $index = 0;
        foreach ($this->_array as $row) {
            // если еще нет заголовков - построим их
            if (!$headersArray) {
                foreach ($row as $k => $v) {
                    $headersArray[] = $k;
                }
                $sheet->writeRow($index, 0, $headersArray);
                $index ++;
            }

            $a = array();
            foreach ($headersArray as $k) {
            	$a[] = @iconv('utf-8', 'utf-8', @$row[$k]);
            }

            $sheet->writeRow($index, 0, $a);
            $index ++;
        }

        // $xls->send("phpPetstore.xls");
        $xls->close();

        $content =  file_get_contents($filename);

        // remove tmp file
        @unlink($filename);

        return $content;
    }

}