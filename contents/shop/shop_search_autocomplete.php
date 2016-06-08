<?php
class shop_search_autocomplete extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');

            $a = array();
            $products = Shop::Get()->getShopService()->searchProducts($query, false);
            $products->setLimitCount(10);
            while ($x = $products->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => htmlspecialchars($x->getName()),
                'url' => $x->makeURL(),
                );
            }
            $this->setValue('productArray', $a);
        } catch (Exception $e) {

        }
    }

}