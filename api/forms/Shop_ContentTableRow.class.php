<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ContentTableRow extends Forms_ContentTableRow {

    public function __construct() {
        $this->setFileHTML(dirname(__FILE__).'/Shop_ContentTableRow.html');
    }

    public function render(Forms_ContentTable $table, $rowIndex, $cellsArray) {
        $assigns = array();

        $a = array();
        $b = array();

        $primaryKeyName = $table->getDataSource()->getFieldPrimary()->getKey();

        foreach ($table->getFieldsArray() as $field) {
            $b[$field->getKey()] = @$cellsArray[$field->getKey()];

            $a[$field->getKey()] = array(
            'cells' => $field->renderView($rowIndex, $cellsArray),
            'pkValue' => @$cellsArray[$primaryKeyName],
            'quickedit' => $field->getQuickedit(),
            );
        }

        $assigns['datasource'] = get_class($table->getDataSource());
        $assigns['cellsArray'] = $a;
        $assigns['cellsDataArray'] = $b;

        return Engine::GetSmarty()->fetch(
        $this->getFileHTML(),
        $assigns
        );
    }

}