<?php
class kpi_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_KPI());

        $field = new Forms_ContentFieldControlLink('name', 'kpi-control', 'key');
        $table->addField($field);

        $table->getField('name')->setName('KPI');

        $this->setValue('table', $table->render());
    }

}