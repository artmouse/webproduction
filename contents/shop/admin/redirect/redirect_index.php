<?php
class redirect_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Redirect());

        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-redirect-control', 'key');
        $table->addField($field);

        $table->getField('id')->setName('ID');

        $this->setValue('table', $table->render());
    }

}