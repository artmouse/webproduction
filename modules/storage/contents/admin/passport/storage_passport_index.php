<?php
class storage_passport_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_ProductPassport());
        $this->setValue('table', $table->render());
    }

}