<?php
class client_shop_orders_view extends Engine_Class {

    public function process() {

        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            if ($order->getUserid() != $this->getUser()->getId()) {
                throw new ServiceUtils_Exception('access');
            }

            Engine::GetHTMLHead()->setTitle(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_zakaz_').$order->getId()
            );

            $currencyOrder = $order->getCurrency();

            $orderproducts = $order->getOrderProducts();
            $a = array();
            while ($x = $orderproducts->getNext()) {
                try {
                    $unit = $x->getProduct()->getUnit();
                } catch (Exception $e) {
                    $unit = false;
                }

                $url = false;
                try {
                    if ($order->getStatus()->getDownloadable()) {
                        $url = Shop::Get()->getShopService()->makeProductDownloadURL($x->getProduct());
                        $url = Engine::Get()->getProjectURL().'/'.$url;
                    }
                } catch (Exception $e) {

                }

                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getProductname(),
                'productid' => $x->getProductid(),
                'count' => (float) $x->getProductcount(),
                'price' => $x->makePrice($currencyOrder),
                'unit' => $unit,
                'sum' => $x->makeSum($currencyOrder),
                'currency' => $currencyOrder->getSymbol(),
                'url' => $url,
                'comment' => $x->getComment(),
                );
            }
            $this->setValue('productsArray', $a);

            $this->setValue('status', $order->getStatus()->getName());
            $this->setValue('sum', $order->getSum()); // без доставки и со скидкой
            // полная сумма, со скидкой и доставкой
            $this->setValue('allSum', $order->getSum() + $order->getDeliveryprice());
            $this->setValue('currency', $currencyOrder->getSymbol());
            $this->setValue('cdate', $order->getCdate());
            $this->setValue('orderid', $order->getId());
            $this->setValue('clientname', htmlspecialchars($order->getClientname()));
            $this->setValue('clientemail', htmlspecialchars($order->getClientemail()));
            $this->setValue('clientphone', htmlspecialchars($order->getClientphone()));
            $this->setValue('clientcontacts', htmlspecialchars($order->getClientcontacts()));
            try{
                $payment = Shop::Get()->getShopService()->getPaymentByID($order->getPaymentid());
                $this->setValue('payment', $payment->getName());
            }catch(Exception $ge){

            }
            $this->setValue('comments', htmlspecialchars($order->getComments()));

            if ($order->getManagerid()) {
                try {
                    $manager = $order->getManager();
                    $this->setValue('managername', htmlspecialchars($manager->getName()));
                    $this->setValue('managerphone', htmlspecialchars($manager->getPhone()));
                    $this->setValue('manageremail', htmlspecialchars($manager->getEmail()));
                } catch (Exception $e) {
                }
            }

            try {
                $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID($order->getDeliveryid());
                $this->setValue('dname', $delivery->getName());
                $this->setValue('dcurrency', $delivery->getCurrency()->getSymbol());
                $this->setValue('dprice', $order->getDeliveryprice());
            } catch (Exception $e) {

            }

            // информауция о скидках
            try {
                $discount = Shop::Get()->getShopService()->getDiscountByID($order->getDiscountid());
                $this->setValue('discountName', $discount->getName() . "(" . $discount->getValue() . "%)");
                $this->setValue('discountSum', $order->getDiscountsum());
            } catch (Exception $e) {

            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}