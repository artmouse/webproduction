<?php
class products_report_autocomplete extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');
            $a = array();
            // поиск продуктов
            $products = Shop::Get()->getShopService()->searchProducts($query, false);
            $products->setLimitCount(10);
            while ($x = $products->getNext()) {
                $b = array();
                $b['name'] = $x->makeName(false);
                $a[] = $b;
            }           
            
            // выдача результатов
            echo json_encode($a);
            exit;
        } catch (Exception $e) {
            throw $e;
        }
    }

}