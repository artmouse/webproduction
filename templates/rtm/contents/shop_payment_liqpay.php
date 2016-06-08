<?php
require_once(dirname(__FILE__).'/../../../packages/LiqPay/LiqPay.php');
class shop_payment_liqpay extends Engine_Class {

    public function process() {
        try {
            $publicKey = Shop::Get()->getSettingsService()->getSettingValue('public-key');
            $privateKey = Shop::Get()->getSettingsService()->getSettingValue('private-key');
            $this->setValue('publicKey', $publicKey);
            $this->setValue('privateKey', $privateKey);

            $orderID = $this->getArgumentSecure('orderid');

            if ($orderID) {
                $order = Shop::Get()->getShopService()->getOrderByID($orderID);
                $amount = $order->getSum();
                try{
                    if ($order->getDeliveryid() && $order->getDelivery()->getPaydelivery()) {
                        $amount += $order->getDeliveryprice();

                    }

                } catch (Exception $e) {

                }



                $liqpay = new LiqPay($publicKey, $privateKey);
                $html = $liqpay->cnb_form(array(
                    'amount'         => $amount,
                    'currency'       => $order->getCurrency()->getName(),
                    'description'    => 'Оплата заказа №'.$order->getId(),
                    'order_id'       => $order->getId(),
                    'type'           => 'buy',
                    'pay_way'           => 'card,delayed',
                    'language'           => 'ru',
                    'result_url'           => Engine::Get()->getProjectURL(),
                    'server_url'           => Engine::Get()->getProjectURL().Engine_URLParser::Get()->getTotalURL()
                ));

                $html = substr_replace($html, ' target="_blank" ', strpos($html, 'method="post"')-1 , 0);

                $this->setValue('html', $html);

                $this->setValue('orderID', $order->getId());
                $this->setValue('orderSum', $amount);

                // подпись
                $liqpay = new LiqPay($publicKey, $privateKey);
                $signature = $liqpay->cnb_signature(array(
                    'amount'         => $order->getSum(),
                    'currency'       => $order->getCurrency()->getName(),
                    'description'    => 'Оплата заказа №'.$order->getId(),
                    'order_id'       => $order->getId(),
                    'type'           => 'buy'
                ));

                $sign = new XShopPaymentResult();
                $sign->setAmount($amount);
                $sign->setOrderid($order->getId());
                $sign->setStatus('sent');
                $sign->insert();

            }

            $result = $this->getArgumentSecure('status');

            if ($result) {
                $order_id = $this->getArgumentSecure('order_id');
                $amount = $this->getArgumentSecure('amount');
                $sign = base64_encode( sha1(
                    $privateKey .
                    $amount .
                    $this->getArgumentSecure('currency') .
                    $publicKey .
                    $order_id .
                    $this->getArgumentSecure('type') .
                    $this->getArgumentSecure('description') .
                    $this->getArgumentSecure('status') .
                    $this->getArgumentSecure('transaction_id') .
                    $this->getArgumentSecure('sender_phone')
                    , 1 ));

                $PaymentResult = new XShopPaymentResult();
                $PaymentResult->setOrderid($order_id);
                $PaymentResult->setOrder('id', 'DESC');
                $PaymentResult->setAmount($amount);
                if (!$PaymentResult->select()) {
                    // не нашли
                    exit;
                }


                // проверка подписи
                if ($this->getArgumentSecure('signature') == $sign) {

                    if ($result == 'success') {
                        // если все успешно - принимаем деньги за заказ

                        Shop::Get()->getShopService()->payOrder(
                            $orderID,
                            $amount,
                            true // не проверять ACL
                        );
                        $PaymentResult->setStatus('success');
                        $PaymentResult->update();

                    } elseif ($result == 'failure') {
                        $PaymentResult->setStatus('fail');
                        $PaymentResult->update();

                    } else {
                        $PaymentResult->setStatus($result);
                        $PaymentResult->update();
                    }

                } else {
                    // не совпала подпись
                    $PaymentResult->setStatus('badSignature');
                    $PaymentResult->update();
                }


            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

        }
    }

}