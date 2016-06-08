<?php
class ignore_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_EventIgnore());
        $this->setValue('table', $table->render());
    }

}