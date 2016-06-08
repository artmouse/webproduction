<?php
class storage_ajaxproduct_list extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('query');
            $categoryid = $this->getArgumentSecure('categoryid');

            $a = array();

            if ($query) {
                $products = Shop::Get()->getShopService()->searchProducts($query, false);
                $products->setSource(false);
                $products->setLimitCount(50);
            } else {
                $products = Shop::Get()->getShopService()->getProductsAll();
                $products->setSource(false);
                $products->setDeleted(0);
                $products->setLimitCount(50);
            }

            if ($categoryid) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID($categoryid);
                    $products->addWhere('category'.$category->getLevel().'id', $category->getId());
                } catch (ServiceUtils_Exception $se) {

                }
            }

            while ($product = $products->getNext()) {
                try {
                    $a[] = array(
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'price' => $product->getPricebase(),
                    'currencyid' => $product->getCurrencyid(),
                    'currency' => $product->getCurrency()->getSymbol(),
                    'image' => $product->makeImageThumb(100, 100),
                    'unit' => $product->getUnit()
                    );
                } catch (ServiceUtils_Exception $se) {

                }
            }

            $this->setValue('productArray', $a);
        } catch (Exception $e) {

        }
    }

}