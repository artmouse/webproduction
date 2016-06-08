<?php
class shop_order extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByHash(
            $this->getArgument('hash')
            );

            // содержимое заказа
            $orderProducts = Shop::Get()->getShopService()->getOrderProducts($order);
            $a = array();
            $sum = 0;
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
            while ($x = $orderProducts->getNext()) {

                $url = false;
                try {
                    if ($order->getStatus()->getDownloadable()) {
                        $url = Shop::Get()->getShopService()->makeProductDownloadURL($x->getProduct());
                        $url = Engine::Get()->getProjectURL().'/'.$url;
                    }
                } catch (Exception $e) {

                }


                try {
                    $p = $x->getProduct();

                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $p->getName(),
                    'description' => StringUtils_Limiter::LimitLength($p->getDescription(), 130),
                    'producturl' => $p->makeURL(),
                    'image' => $p->makeImageThumb(80, 56, 'prop'),
                    'amount' => (float) $p->getCountWithDivisibility($x->getProductcount()),
                    'price' => $x->makePrice($currencyDefault),
                    'sum' => $x->makeSum($currencyDefault),
                    'currency' => $currencyDefault->getSymbol(),
                    'unit' => $p->getUnit(),
                    'url' => $url
                    );

                    $sum += $x->makeSum($currencyDefault);
                } catch (Exception $e) {

                }
            }

            $this->setValue('productsArray', $a);

            $this->setValue('orderid', $order->getId());
            $this->setValue('orderdate', $order->getCdate());
            try {
                $this->setValue('orderstatus', $order->getStatus()->getName());
            } catch (ServiceUtils_Exception $e) {

            }

            $this->setValue('clientname', $order->getClientname());
            $this->setValue('clientphone', $order->getClientphone());
            $this->setValue('clientemail', $order->getClientemail());
            $this->setValue('clientcontacts', $order->getClientcontacts());
            $this->setValue('comments', $order->getComments());

            try {
                $manager = $order->getManager();
                $this->setValue('managername', $manager->getName());
                $this->setValue('manageremail', $manager->getEmail());
                $this->setValue('managerphone', $manager->getPhone());
            } catch (ServiceUtils_Exception $e) {

            }

            // доставка
            $deliveryPrice = $order->getDeliveryprice();
            $this->setValue('deliveryPrice', $deliveryPrice);

            // имя доставки
            try {
                $this->setValue('deliveryname', $order->getDelivery()->getName());
            } catch (ServiceUtils_Exception $e) {

            }

            // скидка
            $discountSum = $order->getDiscountsum();
            try {
                // Определяем название скидки, сумму скидки берем из заказа.
                $discount = Shop::Get()->getShopService()->getDiscountByID($order->getDiscountid());
                $this->setValue('discountName', $discount->getName() . "(" . $discount->getValue() ."%)");
            } catch (ServiceUtils_Exception $e) {}

            $this->setValue('discountSum', $discountSum);

            $this->setValue('sum', $sum); // Сумма без доставки и без скидки (просто сумма товаров)
            $this->setValue('allSum', $sum - $discountSum + $deliveryPrice); // сумма с доставкой и со скидкой
            $this->setValue('currency', $currencyDefault->getSymbol());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}