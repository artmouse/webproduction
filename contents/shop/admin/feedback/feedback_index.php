<?php
class feedback_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Feedback());
        $this->setValue('table', $table->render());
    }

}