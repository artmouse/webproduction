<?php

class Finance_CronHourDefault implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        $paymentsAll = PaymentService::Get()->getPaymentsAll();
        $paymentsAll->addWhere('pdate', DateTime_Object::Now()->addDay(-1), '>');
        $paymentsAll->addWhere('linkkey', 'order-%', 'LIKE');
        $paymentsAll->addWhere('clientid', '', '<>');
        $paymentsAll->setReferalprocessed(0);

        while ($x = $paymentsAll->getNext()) {
            try{
                if ($parentid = $x->getClient()->getParentid()) {
                    $parent = Shop::Get()->getUserService()->getUserByID($parentid);

                    // выплачивать реферальные?
                    if ($referal = $parent->getAllowreferal()) {
                        // ищем/создаем заказ
                        $order = Shop::Get()->getShopService()->getOrdersAll();
                        $order->setLinkkey('referal-'.$parentid);

                        if (!$order->select()) {
                            // создаем заказ
                            $order = Shop::Get()->getShopService()->makeOrderEmpty($parent);
                            $order->setName('Реферальные '.$parent->makeName(false));
                            $order->setLinkkey('referal-'.$parentid);
                            $order->setOutcoming(1);
                            $order->setUserid($parentid);
                            $order->setClientname($parent->makeName(false));
                            $order->setClientphone($parent->getPhone());
                            $order->setClientemail($parent->getEmail());
                            $order->update();
                        }

                        $financeOrderId = str_replace('order-', '', $x->getLinkkey());

                        $clientOrder = false;
                        try {
                            $clientOrder = Shop::Get()->getShopService()->getOrderByID($financeOrderId);
                        } catch (Exception $e) {

                        }

                        // ищем/создаем продукт
                        try{
                            $product = Shop::Get()->getShopService()->getProductByCode1c(
                                'referal-'.$x->getClientid().'order-'.$financeOrderId
                            );
                        } catch (Exception $e) {
                            $product = Shop::Get()->getShopService()->addProduct(
                                'Реферальная выплата Клиент '.$x->getClientid().
                                ', Заказ '.($clientOrder ? $clientOrder->makeName() : $financeOrderId)
                            );
                            $product->setCode1c('referal-'.$x->getClientid().'order-'.$financeOrderId);
                            $product->setDeleted(1);
                            $product->update();
                        }

                        $amount = Shop::Get()->getCurrencyService()->convertCurrency(
                            $x->getAmount(),
                            Shop::Get()->getCurrencyService()->getCurrencyByID($x->getCurrencyid()),
                            Shop::Get()->getCurrencyService()->getCurrencySystem()
                        );

                        $product->setPrice($amount * $referal/100);
                        $product->update();

                        // добавляем продукт к заказу, пересчитываем заказ
                        Shop::Get()->getShopService()->addOrderProduct($order, $product->getId());
                        Shop::Get()->getShopService()->recalculateOrderSums($order);

                        $x->setReferalprocessed(1);
                        $x->update();

                    }

                }

            } catch (Exception $e) {

            }

        }

    }

}