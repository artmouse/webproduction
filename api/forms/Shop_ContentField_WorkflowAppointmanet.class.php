<?php

class Shop_ContentField_WorkflowAppointmanet extends Forms_ContentField {

    public function renderView($rowIndex, $cellsArray) {
        $value = @$cellsArray[$this->getKey()];
        if ($value == 'issue') {
            $value = 'Для задач';
        } elseif ($value == 'project') {
            $value = 'Для проектов';
        } else {
            $value = 'Для заказов';
        }
        return $value;
    }


}