<?php
class guestbook_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_GuestBook_Kazakh());
        $this->setValue('table', $table->render());
    }

}