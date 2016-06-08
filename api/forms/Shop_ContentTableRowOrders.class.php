<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Шапка таблицы
 *
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ContentTableRowOrders extends Shop_ContentTableRow {

    public function render(Forms_ContentTable $table, $rowIndex, $cellsArray) {
        $assigns = array();

        $a = array();
        $b = array();

        $primaryKeyName = $table->getDataSource()->getFieldPrimary()->getKey();
        $orderID = $cellsArray[$primaryKeyName];

        foreach ($table->getFieldsArray() as $field) {
            $b[$field->getKey()] = @$cellsArray[$field->getKey()];
            $colour = false;
            try {
                if ($field->getKey() =='statusid') {
                    $status = Shop::Get()->getShopService()->getStatusByID($cellsArray['statusid']);
                    $colour = $status->getColour();
                }
            } catch (Exception $e2) {

            }
            $a[$field->getKey()] = array(
            'cells' => $field->renderView($rowIndex, $cellsArray),
            'pkValue' => @$cellsArray[$primaryKeyName],
            'quickedit' => $field->getQuickedit(),
            'colour' => $colour
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