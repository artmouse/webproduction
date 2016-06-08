<?php

class Shop_ContentFieldNoBalance extends Forms_ContentField  {

    public function __construct($key) {
        parent::__construct($key);

        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'_Control.html');
    }

    /**
     * Отрисовать поле для просмотра (в табличном выводе, например).
     *
     * @param int $rowIndex
     * @param array $cellsArray
     * @return string
     */
    public function renderView($rowIndex, $cellsArray) {
        $value = @$cellsArray[$this->getKey()];
        if ($value) {
            $value = '-';
        } else {
            $value = '+';
        }
        return $value;
    }


}