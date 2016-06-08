<?php
class box_block_productview_order_block extends Engine_Class {

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    private function _getOrder() {
        return $this->getValue('order');
    }

    public function process() {
        try {
            // получаем заказ
            $order = $this->_getOrder();
            $client = $order->getClient();

            $productView = new XShopProductView();
            $productView->setUserid($client->getId());
            $productView->setGroupByQuery('productid');
            $productView->setOrder('id', 'DESC');

            $a = array();

            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
            while ($x = $productView->getNext()) {
                try{
                    $product = Shop::Get()->getShopService()->getProductByID($x->getProductid());

                    $categoryName = false;
                    try{
                        $categoryName = $product->getCategory()->getName();
                    } catch (Exception $ecategory) {

                    }

                    // товары
                    @$a[] = array(
                        'id' => $product->getId(),
                        'name' => htmlspecialchars($product->getName()),
                        'productid' => $product->getId(),
                        'productUrl' => $product->makeURLEdit(),
                        'price' => $product->makePrice($currencyDefault),
                        'categoryName' => $categoryName
                    );

                    if (count($a) >= 30) {
                        break;
                    }
                } catch (Exception $eproduct) {

                }
            }

            $this->setValue('productsArray', $a);
        } catch (Exception $e) {

        }

    }

}