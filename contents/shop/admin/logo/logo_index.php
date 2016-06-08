<?php
class logo_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Logo());
        $this->setValue('table', $table->render());
    }

}