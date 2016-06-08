<?php

class Shop_ContentField_WorkflowDirection extends Forms_ContentField {

    public function renderView($rowIndex, $cellsArray) {
        $value = @$cellsArray[$this->getKey()];
        if ($value) {
            $value = 'Исходящий';
        } else {
            $value = 'Входящий';
        }
        return $value;
    }
}