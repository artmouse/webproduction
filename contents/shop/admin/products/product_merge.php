<?php
class product_merge extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            if ($this->getControlValue('merge')) {
                try {
                    $productIDArray = $this->getArgumentSecure('product_id', 'array');
                    $productSortArray = $this->getArgumentSecure('product_sort', 'array');

                    foreach ($productSortArray as $k => $v) {
                        if ($v == 1) {
                            $productMain = Shop::Get()->getShopService()->getProductByID($productIDArray[$k]);
                            unset($productIDArray[$k]);

                            Shop::Get()->getShopService()->mergeProducts($productMain, $productIDArray);
                        }
                    }

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $se) {
                    $this->setValue('message', 'error');
                }
            }

            if ($this->getControlValue('ok')) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID(
                    $this->getControlValue('categoryid')
                    );

                    $products = Shop::Get()->getShopService()->getProductsByCategory($category);
                } catch (ServiceUtils_Exception $se) {
                    $products = Shop::Get()->getShopService()->getProductsAll();
                }

                if ($productName = $this->getControlValue('productname')) {
                    $productName = $products->getConnectionDatabase()->escapeString($productName);
                    $productName = '%'.str_replace(' ', '%', $productName).'%';
                    $products->addWhereQuery('(`shopproduct`.`id` LIKE \''.$productName.'\' OR `shopproduct`.`name` LIKE \''.$productName.'\')');
                }

                $productArray = array();
                while ($product = $products->getNext()) {
                    $a = array();

                    $a['id'] = $product->getId();
                    $a['name'] = $product->makeName();
                    $a['photo'] = $product->makeImageThumb(100);

                    try {
                        $a['categoryName'] = $product->getCategory()->makeName();
                    } catch (ServiceUtils_Exception $se) {

                    }

                    try {
                        $a['brandName'] = $product->getBrand()->makeName();
                    } catch (ServiceUtils_Exception $se) {

                    }

                    $a['price'] = $product->getPrice();

                    try {
                        $a['currency'] = $product->getCurrency()->getSymbol();
                    } catch (ServiceUtils_Exception $se) {

                    }

                    $productArray[] = $a;
                }

                $this->setValue('productArray', $productArray);
            }

            // список категорий
            $category = Shop::Get()->getShopService()->makeCategoryTree();
            $a = array();
            foreach ($category as $x) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'hidden' => $x->getHidden(),
                'level' => $x->getField('level'),
                'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
                'parentid' => $x->getParentid(),
                );
            }
            $this->setValue('categoryArray', $a);

        } catch (Exception $e) {

        }
    }

}