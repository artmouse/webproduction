<?php
class product_search extends Engine_Class {

    public function process() {
        $a = array();
        $status = false;
        $errorsArray = array();

        try {
            $query = $this->getArgumentSecure('query', 'string');
            $categoryID = $this->getArgumentSecure('categoryid', 'int');

            if ($query) {
                try {
                    $products = Shop::Get()->getShopService()->searchProducts($query, false);
                    $products->setLimitCount(50);

                    // фильтр по категории
                    if ($categoryID) {
                        $categoryIDArray = array($categoryID);
                        $treeArray = Shop::Get()->getShopService()->makeCategoryTree($categoryID);
                        foreach ($treeArray as $x) {
                            $categoryIDArray[] = $x->getId();
                        }
                        $products->addWhereArray($categoryIDArray, 'categoryid');
                    }
                } catch (Exception $e) {

                }
            } else {
                // просто показываем все товары
                $products = Shop::Get()->getShopService()->getProductsAll();
                // фильтр по категории
                if ($categoryID) {
                    $categoryIDArray = array($categoryID);
                    $treeArray = Shop::Get()->getShopService()->makeCategoryTree($categoryID);
                    foreach ($treeArray as $x) {
                        $categoryIDArray[] = $x->getId();
                    }
                    $products->addWhereArray($categoryIDArray, 'categoryid');
                }
                $products->setDeleted(0);
                $products->setLimitCount(50);
            }

            // вывродим товары
            while ($x = $products->getNext()) {
                try {
                    $currencyName = $x->getCurrency()->getSymbol();
                } catch (Exception $cEx) {
                    $currencyName = '';
                }
                $image = false;
                if ($x->getImage()) {
                    $image = $x->makeImageThumb('250', '200');
                }

                try {
                    $categoryName = $x->getCategory()->makeName();
                } catch (Exception $e) {
                    $categoryName = false;
                }

                $a[] = array(
                'id' => $x->getId(),
                'name' => htmlspecialchars($x->getName()),
                'availtext' => htmlspecialchars($x->getAvailtext()),
                'avail' => $x->getAvail(),
                'price' => $x->getPrice(),
                'currencyname' => $currencyName,
                'categoryname' => $categoryName,
                'image' => $image
                );
            }
            $status = 'success';
        } catch (Exception $e) {
            $status = 'error';
            $errorsArray = array();
        }

        $json = array(
        'status' => $status,
        'result' => $a,
        'errors' => $errorsArray
        );

        echo json_encode($json);
        exit();
    }

}