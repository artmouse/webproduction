<?php
class settings_project_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Project());
        $this->setValue('table', $table->render());
    }

}