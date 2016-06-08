<?php
class products_manage_ajax extends Engine_Class {

    public function process() {


        try {

            $dropOnId = $this->getArgumentSecure('dropOnId');
            $isProduct = $this->getArgumentSecure('isProduct');
            $movedId = $this->getArgumentSecure('movedId');


            if ( $isProduct  ){
                try {
                    SQLObject::TransactionStart();

                    $product = Shop::Get()->getShopService()->getProductByID($movedId);
                    if ($dropOnId != 0) {
                        $category = Shop::Get()->getShopService()->getCategoryByID($dropOnId);
                        Shop::Get()->getShopService()->updateProductCategory($product,$category);
                    } else {
                        $product->setCategoryid(0);
                        Shop::Get()->getShopService()->buildProductCategories($product);
                    }


                    SQLObject::TransactionCommit();
                } catch (Exception $e) {
                    SQLObject::TransactionRollback();
                    throw $e;
                }

            } else {
                try {
                    SQLObject::TransactionStart();
                    $category = Shop::Get()->getShopService()->getCategoryByID($movedId);
                    $category->setParentid($dropOnId);
                    // @TODO доделать sort
                    $category->update();

                    $this->_updateCategoruTreeInProducts();

                    SQLObject::TransactionCommit();

                } catch ( Exception $e ){
                    SQLObject::TransactionRollback();
                    throw $e;
                }
            }

            $resultArray['status'] = 'success';
        } catch (Exception $e) {
            $resultArray['status'] = 'error';
        }
        echo json_encode($resultArray);
        exit();
    }

    private function _updateCategoruTreeInProducts(){
        try {

            // Обновляем дерево категорий у товаров.
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setOrderBy('categoryid'); // оптимизация кеша по категориям

            $transactions = 250;
            $index = 0;

            SQLObject::TransactionStart();

            while ($product = $products->getNext()) {

                // устанавливаем родительские категории
                try {
                    Shop::Get()->getShopService()->buildProductCategories($product);
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {

                    }
                }

                $index ++;
                if ($index % $transactions == 0) {
                    SQLObject::TransactionCommit();
                    SQLObject::TransactionStart();
                }
            }

            SQLObject::TransactionCommit();

        } catch (Exception $e) {
            throw $e;
        }

    }


}

