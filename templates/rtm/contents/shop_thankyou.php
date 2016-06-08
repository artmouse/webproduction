<?php
class shop_thankyou extends Engine_Class {

    public function process() {
        $orderId = $this->getArgumentSecure('orderid');
        if (!$orderId) {
            return;
        }

        try {
            $order = Shop::Get()->getShopService()->getOrderByID($orderId);

            $shopTpl = Engine::GetContentDriver()->getContent('shop-tpl');

            $shopTpl->setValue('productArray', $this->_getOrderProductsArray($order));

            $shopTpl->setValue('order', $this->_getOrderArray($order));

            $shopTpl->setValue('urlredirect', $this->_getUrlRedirect($order));

            $shopTpl->setValue('host',Engine::GetURLParser()->getHost());

            $shopTpl->setValue('thanckyou', 1);

        } catch (Exception $e) {

        }

    }

    /**
     * Возвращает url редиректа, если есть контент оплаты или пользаватель администратор.
     * @param $order
     * @return string
     */
    private function _getUrlRedirect($order) {
        $urlredirect = '';
        // если система оплаты автоматизирована -
        // переход на контент системы оплаты
        try {
            $paymentContentID = $order->getPayment()->getContentid();
            if ($paymentContentID) {
                $urlredirect = Engine::GetLinkMaker()->makeURLByContentIDParam($paymentContentID, $order->getId(), 'orderid');
            }
        } catch (Exception $e) {

        }

        // если админ - то редирект на управление заказом
        try {
            if ($this->getUser()->isAdmin() && !$urlredirect) {
                $urlredirect =  $order->makeURLEdit();
            }
        } catch (Exception $ue) {

        }
        return $urlredirect;
    }

    /**
     * @param ShopOrder $order
     * @return array
     * @throws Exception
     */
    private function _getOrderProductsArray(ShopOrder $order) {
        $a = array();
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencyDefault();
        try {
            $orderProducts = $order->getOrderProducts();

            while( $x = $orderProducts->getNext() ) {

                $a[] = array(
                    'sku' => $x->getProductid(),
                    'name' => $x->getProductname(),
                    'category' => $x->getCategoryname(),
                    'price' => $x->makePrice($currencyDefault),
                    'quantity' => round($x->getProductcount())
                );
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $a;
    }

    /**
     * @param ShopOrder $order
     * @return array
     * @throws Exception
     */
    private function _getOrderArray(ShopOrder $order) {
        $a = array();
        try {
            $a['id'] = $order->getId();
            $a['transactionTotal'] = $this->_getAmount($order);
            $a['transactionTax'] = number_format(round($order->makeTaxSum()), 2, '.', ' ');
            $a['transactionShipping'] = $order->getDeliveryid() ? $order->getDeliveryprice():0.00;
        } catch (Exception $e) {
            throw $e;
        }
        return $a;
    }


    /**
     * Возвращает сумму заказа
     * @param ShopOrder $order
     * @return float
     * @throws Exception
     */
    private function _getAmount(ShopOrder $order) {
        try{
            $amount = $order->getSum();

            if ($order->getDeliveryid() && $order->getDelivery()->getPaydelivery()) {
                $amount += $order->getDeliveryprice();
            }
            return $amount;
        } catch (Exception $e) {
            throw $e;
        }
    }

}