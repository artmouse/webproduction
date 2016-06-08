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
            $count = $this->getArgumentSecure('productcount');
            if ($count <= 0) {
                $count = 1;
            }

            $action = $this->getArgumentSecure('action');
            $options = $this->getArgumentSecure('productoptions');
            $basket = $this->addToBasket($productID, $count, $action, $options);
            unset($options);

            $params = $this->getArgumentSecure('params');
            if ($params) {
                $basket->setParams($params);
                $basket->update();
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
            foreach ($basketArray as $x) {
                try {
                    $p = $x->getProduct();
                    $productIDArray[] = $p->getId();

                    for($i=1;$i<10;$i++) {
                        $optionArray[$p->getId()][$i] = array(
                             'filterid' => $x->getField('filter'.$i.'id'),
                             'filtervalue' => $x->getField('filter'.$i.'value'),
                             'filtermarkup' => $x->getField('filter'.$i.'markup'),
                        );
                    }

                } catch (Exception $e) {

                }
            }
            $a['productID'] = $productID;
            $a['productIDArray'] = @$productIDArray;
            $a['optionArray'] = @$optionArray;
        } catch (Exception $e) {

        }

        echo json_encode($a);
        exit();
    }

    /**
     * Добавить товар в корзину
     *
     * @return ShopBasket
     */
    public function addToBasket($productID, $count, $action, $options = false) {
        try {
            SQLObject::TransactionStart();

            $count = str_replace(',', '.', $count);
            $count = (float) trim($count);

            if ($count <= 0) {
                throw new ServiceUtils_Exception();
            }

            $product = Shop::Get()->getShopService()->getProductByID($productID);

            $count = $product->getCountWithDivisibility($count);

            $x = new ShopBasket();

            // session basket
            @session_start();
            $x->setSid($this->_getSessionID());

            // issue #34973 - smart basket
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $x->setUserid($user->getId());
            } catch (Exception $e) {

            }

            // product
            $x->setProductid($productID);


            // если переданы опции - сохраняем их
            if ($options) {
                $optionArray = explode(';', $options);
                foreach ($optionArray as $option) {
                    $option = trim($option);
                    if (!$option) {
                        continue;
                    }
                    $option = explode(':', $option);
                    $filterID = $option[0];
                    $filterValue = $option[1];

                    try {
                        $filter_count = Engine::Get()->getConfigField('filter_count');
                    } catch (Exception $e) {
                        $filter_count = 10;
                    }
                    for ($j = 1; $j <= $filter_count; $j++) {
                        if ($x->getField('filter'.$j.'id')) {
                            continue;
                        }
                        if ($filterID && $filterValue) {
                            $x->setField('filter'.$j.'id', $filterID);
                            $x->setField('filter'.$j.'value', $filterValue);
                            //находим наценку в товаре
                            for ($z = 1; $z <= 10; $z++) {
                                if ($product->getField('filter'.$z.'id') == $filterID) {
                                    if ($filterValue === '') {
                                        $x->setField('filter'.$j.'markup', 0);
                                    } elseif($product->getField('filter'.$z.'value') == $filterValue) {
                                        $x->setField('filter'.$j.'markup', $product->getField('filter'.$z.'markup'));
                                        break;
                                    }
                                }
                            }
                            break;
                        }

                    }
                    unset($filterID);
                    unset($filterValue);
                }
            }
            $x->setBuyOrExchange($action);

            if ($x->select()) {
                $x->setProductcount($count + $x->getProductcount());
                $x->update();
            } else {
                $x->setCdate(date('Y-m-d H:i:s'));
                $x->setProductcount($count);

                $x->insert();
            }

            SQLObject::TransactionCommit();

            // сбрасываем данные в кеше
            $this->_basketArray = false;

            // возвращаем элемент корзины
            return $x;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    private function _getSessionID() {
        $sid = @session_id();
        if (!$sid) {
            throw new ServiceUtils_Exception('empty SessionID!');
        }
        return $sid;
    }

}