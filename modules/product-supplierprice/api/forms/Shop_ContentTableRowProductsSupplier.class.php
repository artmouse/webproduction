<?php

/**
 * Shop_ContentTableRowProductsSupplier
 *
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_ContentTableRowProductsSupplier extends Shop_ContentTableRow {

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

        $assigns['productId'] = @$cellsArray['productid'];

        $assigns['class'] = 'js-droppable';


        return Engine::GetSmarty()->fetch(
            $this->getFileHTML(),
            $assigns
        );
    }

}