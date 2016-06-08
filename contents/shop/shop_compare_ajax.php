<?php
class shop_compare_ajax extends Engine_Class {

    /**
     * 1. (опционально) принимаем параметр productID
     * 2. Выдаем список всех товаров в сравнении (id + текст ссылки)
     */
    public function process() {

        // Удаление из сравнений.
        try {
            $deleteID = $this->getArgument('delete');
            Shop::Get()->getCompareService()->deleteFromCompare($deleteID);
        } catch (Exception $deleteEx) {

        }
        // 1. (опционально) принимаем параметр buy=productID
        try {
            $productID = $this->getArgument('productid');

            Shop::Get()->getCompareService()->addToCompare($productID);
        } catch (Exception $e) {

        }
        $a = array();
        try {
            // результаты

            // 2. Выдаем список всех товаров в сравнении (id + текст ссылки)
            $compares = Shop::Get()->getCompareService()->getCompareProducts();
            $productArray = array();

            if ($compares->getCount()) {
                while ($x = $compares->getNext()) {
                    try {
                        $product = $x->getProduct();

                        $productArray[] = array(
                            'id' => $product->getId(),
                            'url' => $product->makeURL(),
                            'name' => $product->getName()
                        );
                    } catch (Exception $e) {

                    }
                }

            }

            $a['productArray'] = $productArray;
            $a['count'] = count($productArray);
        } catch (Exception $e) {

        }

        echo json_encode($a);
        exit();
    }

}