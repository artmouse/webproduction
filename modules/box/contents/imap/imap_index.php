<?php
class imap_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_IMAPconfig());

        $field = new Forms_ContentFieldControlLink('id', 'admin-imap-config-control', 'key');
        $table->addField($field);

        $this->setValue('table', $table->render());
    }

}