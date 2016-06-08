<?php
class callback_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Callback());
        $this->setValue('table', $table->render());

    }

}