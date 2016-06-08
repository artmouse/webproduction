<?php
class shop_payment_interkassa extends Engine_Class {

    public function process() {
        try {
            $ikShopID = Shop::Get()->getSettingsService()->getSettingValue('interkassa-shopid');
            $ikSecretKey = Shop::Get()->getSettingsService()->getSettingValue('interkassa-secretkey');

            $this->setValue('ikShopID', $ikShopID);

            $orderID = $this->getArgumentSecure('orderid');
            if ($orderID) {
                $order = Shop::Get()->getShopService()->getOrderByID($orderID);

                $this->setValue('orderID', $order->getId());
                $this->setValue('orderSum', $order->getSum());
                $this->setValue('orderCurrency', $order->getCurrency()->getSymbol());
                $this->setValue('orderCurrencySystem', $order->getCurrency()->getName());
                $host = Engine_URLParser::Get()->getHost();
                $this->setValue('interactionUrl', $host . '/payment/interkassa/');
            }
            
            // Принимаем подтверждение оплаты
            if ($this->getArgumentSecure('ik_sign')) {
                // принимаем платеж
                $orderID = $this->getArgument('ik_pm_no');
                $paymentState = $this->getArgument('ik_inv_st');
                $paymentAmount = $this->getArgument('ik_am');

                $paymentSignHash = $this->getArgument('ik_sign');

                $status_data = $this->getArguments();
                unset($status_data['ik_sign']);
                ksort($status_data, SORT_STRING);
                array_push($status_data, $ikSecretKey);
                $signString = implode(':', $status_data);
                $paymentSignHash2 = base64_encode(md5($signString, true));

                // если все успешно - принимаем деньги за заказ
                $PaymentResult = new XShopPaymentResult();
                $PaymentResult->setOrderid($orderID);
                $PaymentResult->setOrder('id', 'DESC');
                $PaymentResult->setAmount($paymentAmount);
                if (!$PaymentResult->select()) {
                    // не нашли
                    exit();
                }

                // проверка подписи
                if ($paymentSignHash == $paymentSignHash2) {

                    if ($paymentState == 'succes') {
                        // если все успешно - принимаем деньги за заказ

                        Shop::Get()->getShopService()->payOrder(
                            $orderID,
                            $paymentAmount,
                            true // не проверять ACL
                        );
                        $PaymentResult->setStatus('success');
                        $PaymentResult->update();

                    } elseif ($paymentState == 'fail') {
                        $PaymentResult->setStatus('fail');
                        $PaymentResult->update();

                    } else {
                        $PaymentResult->setStatus($paymentState);
                        $PaymentResult->update();
                    }

                } else {
                    // не совпала подпись
                    $PaymentResult->setStatus('badSignature');
                    $PaymentResult->update();
                }

                exit();
            }
        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::GetQuery()->setContentNotFound();
        }
    }

}