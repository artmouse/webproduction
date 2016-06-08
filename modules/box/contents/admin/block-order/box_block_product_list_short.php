<?php
class box_block_product_list_short extends Engine_Class {

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    private function _getOrder() {
        return $this->getValue('order');
    }

    public function process() {
        // получаем заказ
        $order = $this->_getOrder();
        $user = $this->getUser();

        // получаем все товары в заказе
        $orderproducts = $order->getOrderProducts();

        $a = array();
        $countProductAll = 0;
        while ($x = $orderproducts->getNext()) {
            $product = false;
            try {
                // productid может быть не действительный,
                // поэтому заключаем в try-catch
                $product = $x->getProduct();
            } catch (Exception $e) {

            }

            $productCount = $x->getProductcount();

            try {
                $sum = $x->makeSum($order->getCurrency());
            } catch (Exception $priceEx) {
                $sum = 0;
            }

            $countProductAll += $productCount;

            // товары
            @$a[] = array(
                'id' => $x->getId(),
                'name' => htmlspecialchars($x->getProductname()),
                'productid' => $x->getProductid(),
                'productUrl' => $product ? $product->makeURLEdit():false,
                'count' => (float) $productCount,
                'price' => $x->getProductprice(),
                'sum' => $sum,
                'currencySym' => $x->getCurrency()->getSymbol(),
                'unit' => $product ? $product->getUnit() : false
            );
        }

        $this->setValue('productsArray', $a);
        $this->setValue('discountSum', $order->getDiscountsum());
        $this->setValue('countProductAll', $countProductAll);

        $this->setValue('currency', $order->getCurrency()->getSymbol());
        $this->setValue('allSum', $order->getSum());

        /*$delivery2 = false;
        try {
            $delivery2 = Shop::Get()->getDeliveryService()->getDeliveryByID($order->getDeliveryid());
        } catch (Exception $e) {

        }

        // сумма заказа
        if ($delivery2 && $delivery2->getPaydelivery()) {
            $this->setValue('allSum', $order->getSum() + $order->getDeliveryprice());
        } else {
            $this->setValue('payDelivery', true);
        }*/

    }

}