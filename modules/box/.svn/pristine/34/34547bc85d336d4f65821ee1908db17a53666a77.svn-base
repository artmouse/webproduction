<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Источник данных для KPI
 *
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_KPI extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return KPIService::Get()->getKPIAll();
    }

    public function getFieldPreview() {
        return $this->getField('name');
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName('KPI');
        $this->addField($field);

        $field = new Forms_ContentField('logicclass');
        $field->setName('KPI processor');
        $this->addField($field);

        $field = new Forms_ContentField('logicclassparam');
        $field->setName('KPI processor param');
        $this->addField($field);
    }

}