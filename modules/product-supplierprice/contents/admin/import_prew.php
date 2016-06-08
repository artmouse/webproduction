<?php

class import_prew extends Engine_Class {

    public function process() {

        $dataArray = $this->getValue('dataArray');
        $this->setValue('dataArray', $dataArray);
    }


}