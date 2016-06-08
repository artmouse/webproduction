<?php
class statistics_search extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_SearchLog());
        $this->setValue('table', $table->render());
    }

}