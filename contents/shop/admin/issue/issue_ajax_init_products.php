<?php
class issue_ajax_init_products extends Engine_Class {

    public function process() {

        $workflowId = $this->getArgumentSecure('workflowId');
        $productsArray = array();

        if ($workflowId) {
            try{
                $workflow = Shop::Get()->getShopService()->getOrderCategoryByID($workflowId);
                $products = $workflow->getProductsDefault();
                $products = explode(',', $products);
                foreach ($products as $prodId) {
                    try{
                        $product = Shop::Get()->getShopService()->getProductByID($prodId);

                        $name = str_replace('"', '\"', $product->getName());
                        $name = str_replace('\'', '\"', $name);

                        try{
                            $categoryName = $product->getCategory()->makeName(false);
                        } catch (Exception $e) {
                            $categoryName = false;
                        }

                        $productsArray[] = array(
                            'id' => $product->getId(),
                            'name' => $product->getName(),
                            'categoryName' => $categoryName,
                            'url' => $product->makeURL(),
                            'name2' => $name,
                            'pricebase' => $product->getPricebase(),
                            'price' => $product->makePrice(Shop::Get()->getCurrencyService()->getCurrencySystem()),

                        );
                    } catch (Exception $e) {

                    }
                }

            } catch (Exception $e) {

            }
        }

        echo json_encode($productsArray);

    }

}