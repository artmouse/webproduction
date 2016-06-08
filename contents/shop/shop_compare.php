<?php
class shop_compare extends Engine_Class {

    public function process() {
        try {
            $compares = Shop::Get()->getCompareService()->getCompareProducts();

            $productArray = array();
            $fieldArray = array();
            $valueArray = array();

            while ($x = $compares->getNext()) {
                try {
                    $product = $x->getProduct();

                    $productArray[$product->getId()] = $product->makeInfoArray();

                    // характеристики по данному товару
                    $a = array();
                    for ($j = 1; $j <= 10; $j++) {
                        try {
                            // разрешена ли фильтрация
                            if (!$product->getField('filter'.$j.'actual')) {
                                //continue;
                            }

                            // получаем фильтр и значение
                            $filterID = $product->getField('filter'.$j.'id');
                            $filterValue = $product->getField('filter'.$j.'value');

                            $filter = Shop::Get()->getShopService()->getProductFilterByID($filterID);
                            if ($filter->getHidden()) {
                                continue;
                            }

                            $fieldArray[$filter->getId()] = $filter->getName();
                            $valueArray[$product->getId()][$filter->getId()] = htmlspecialchars($filterValue);
                        } catch (Exception $filterEx) {

                        }
                    }
                } catch (Exception $productEx) {

                }
            }

            if(count($productArray) == 1){
                $this->setValue('warning', 'ok');
            }

            $this->setValue('productArray', $productArray);
            $this->setValue('fieldArray', $fieldArray);
            $this->setValue('valueArray', $valueArray);

        } catch (Exception $ge) {
            if (method_exists($ge, 'log')) {
            	$ge->log();
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}