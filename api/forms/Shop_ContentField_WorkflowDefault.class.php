<?php

class Shop_ContentField_WorkflowDefault extends Forms_ContentField {

    public function renderView($rowIndex, $cellsArray) {
        $value = @$cellsArray[$this->getKey()];
        if ($value) {
            if (@$cellsArray['issue']) {
                $value = 'По умолчанию для новых задач';
            } else {
                $value = 'По умолчанию для новых заказов';
            }
        } else {
            $value = '';
        }
        return $value;
    }
}