<?php

class Shop_ContentField_WorkflowType extends Forms_ContentField {

    public function renderView($rowIndex, $cellsArray) {
        $rowIndex = false;
        $value = @$cellsArray[$this->getKey()];
        $type = new XShopWorkflowType();
        $type->setType($value);
        if ($type->select()) {
            return $type->getName();
        } else {
            return $value;
        }
    }


}