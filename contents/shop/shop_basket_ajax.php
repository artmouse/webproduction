<?php
class shop_basket_ajax extends Engine_Class {

    /**
     * 1. (опционально) принимаем параметр productID
     * 2. Выдаем всплывающий блок (содержимое корзины)
     * 3. Выдаем блок preview-корзины
     * 4. Выдаем список всех товаров id в корзине
     */
    public function process() {
        // 1. (опционально) принимаем параметр buy=productID
        try {
            $productID = $this->getArgument('productid');
            // набор товаров
            $setID = $this->getArgumentSecure('setid');
            $count = $this->getArgumentSecure('productcount');
            $deleted = $this->getArgumentSecure('deleted');
            if ($count <= 0) {
                $count = 1;
            }

            if ($deleted) {
                $basket = Shop::Get()->getShopService()->getBasketProducts();
                while ($x = $basket->getNext()) {
                    if (($x->getProductid() == $productID && $x->getActionsetid() == 0)
                        || ($setID != 0 && $x->getActionsetid() == $setID)) {
                        $x->delete();
                        break;
                    }
                }

            } else {
                if ($setID > 0) {
                    Shop::Get()->getShopService()->addSetToBasket($setID, $count, false, false, false);
                } else {
                    $options = $this->getArgumentSecure('productoptions');
                    $basket = Shop::Get()->getShopService()->addToBasket($productID, $count, $options);
                    unset($options);

                    $params = $this->getArgumentSecure('params');
                    if ($params) {
                        $basket->setParams($params);
                        $basket->update();
                    }
                }
            }

        } catch (Exception $e) {

        }

        try {
            // результаты
            $a = array();

            // 2. Выдаем всплывающий блок (содержимое корзины)
            // 3. Выдаем блок preview-корзины
            $render = Engine::GetContentDriver()->getContent('block-basket');
            $a['html'] = $render->render();

            // 4. Выдаем список всех товаров (ID), которые есть в корзине
            $basketArray = Shop::Get()->getShopService()->getBasketProductsArray();
            $productIDArray = array();
            $productsArray = array();
            $optionArray = array();
            foreach ($basketArray as $x) {
                try {
                    $p = $x->getProduct();
                    $productIDArray[] = $p->getId();
                    $productsArray[] = array(
                        'id' => $x->getProductid(),
                        'name' => $p->getName(),
                        'price' => $x->getProductprice(),
                        'count' => $x->getProductcount(),
                        'sum' => $x->getProductprice() * $x->getProductcount()
                    );

                    $filters = Shop::Get()->getShopService()->getProductFilterValues($p);
                    while ($filter = $filters->getNext()) {
                        $optionArray[$p->getId()][] = array(
                            'filterid' => $filter->getFilterid(),
                            'filtervalue' => $filter->getFiltervalue(),
                            'filtermarkup' => $filter->getFiltermarkup(),
                        );
                    }

                } catch (Exception $e) {

                }
            }
            $a['productID'] = $productID;
            $a['setID'] = $setID;
            $a['productIDArray'] = $productIDArray;
            $a['optionArray'] = $optionArray;
            $a['productsArray'] = $productsArray;
        } catch (Exception $e) {

        }

        echo json_encode($a);
        exit();
    }

}