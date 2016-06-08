<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ContentTableRowProducts extends Shop_ContentTableRow {

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

        $hidden = !empty($assigns['cellsDataArray']['hidden']);
        $deleted = !empty($assigns['cellsDataArray']['deleted']);

        $assigns['classPreview'] = 'js-product-preview';
        $assigns['productId'] = @$cellsArray[$primaryKeyName];

        if ($deleted) {
            $assigns['class'] = 'row-deleted';
        } elseif ($hidden) {
            $assigns['class'] = 'row-hidden';
        }

        return Engine::GetSmarty()->fetch(
        $this->getFileHTML(),
        $assigns
        );
    }

}