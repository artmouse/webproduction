<?php
class timework_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_TimeWork());
        $this->setValue('table', $table->render());
    }

}