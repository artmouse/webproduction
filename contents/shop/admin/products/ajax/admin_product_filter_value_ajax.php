<?php
class admin_product_filter_value_ajax extends Engine_Class {

    public function process() {
        $id = $this->getArgument('id');
        $query = trim($this->getArgumentSecure('query'));

        $filterValue = new XShopProductFilterValue();
        $filterValue->setFilterid($id);

        if ($query) {
            $filterValue->addWhere('filtervalue', '%'.$query.'%', 'LIKE');
        }

        $filterValue->setLimitCount(15);

        $returnArray = array();
        while ($x = $filterValue->getNext()) {
            if ($x->getFiltervalue()) {
                $returnArray[] = $x->getFiltervalue();

            }
        }

        $returnArray = array_unique($returnArray);

        echo json_encode($returnArray);
        exit;

    }

}