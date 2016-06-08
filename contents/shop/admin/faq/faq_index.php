<?php
class faq_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Faq());
        $this->setValue('table', $table->render());
    }

}