<?php
class shop_product_carousel extends Engine_Class {

    /**
     * Получитть продукты
     *
     * @return ShopProduct
     */
    private function _getProducts() {
        $x = $this->getValue('products');
        $x->setHidden(0);
        $x->setDeleted(0);
        return $x;
    }

    public function process() {
        $admin = false;
        try {
            if ($this->getUser()->isAdmin()) {
                $admin = true;
            }
        } catch (Exception $e) {

        }

        $products = $this->_getProducts();

        $a = array();
        while ($p = $products->getNext()) {
            if ($p->isHidden()) {
                continue;
            }
            $info = $p->makeInfoArray();
            $a[] = $info;
        }
        $this->setValue('productsArray', $a);
    }

}