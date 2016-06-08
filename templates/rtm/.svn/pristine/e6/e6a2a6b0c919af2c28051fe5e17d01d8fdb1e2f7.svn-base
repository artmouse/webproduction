<?php
class shop_payment_portmone extends Engine_Class {

    public function process() {

        if (!$this->_init()) {
            $this->setValue('fail', 1);
            return;
        }

        if ($this->getArgumentSecure('success')) {

            if ( $this->_successPayment() ) {
                $this->setValue('success', 1);
            }

        } else if ($this->getArgumentSecure('fail')) {

            $this->_failPayment();
            $this->setValue('fail', 1);

        } else if ($this->getArgumentSecure('orderid')) {
            $this->setValue('order', $this->_getOrderAsArray());


            $this->setValue('payee_id', $this->_payee_id);

        }
    }

    /**
     *
     * Проводим инициализацию всех необходимых параметров
     *
     * @return bool
     */
    private function _init() {
        $this->_payee_id = Shop::Get()->getSettingsService()->getSettingValue('portmone-payee-id');

        $this->_orderId = $this->getArgumentSecure('orderid');

        $this->_login = Shop::Get()->getSettingsService()->getSettingValue('portmone-login');

        $this->_password = Shop::Get()->getSettingsService()->getSettingValue('portmone-password');

        if ($this->_payee_id && $this->_orderId && $this->_login && $this->_password) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Формируем кнопку оплатить
     * @return array|bool
     */
    private function _getOrderAsArray() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID( $this->_orderId );

            $amount = $this->_getAmount($order);
            if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $h = 'https://';
            } else {
                $h = 'http://';
            }
            $h .= Engine::Get()->getProjectHost();

            $a = array (
                'shop_order_number' => $order->getId(),
                'bill_amount' => $amount,
                'description' => 'Оплата заказа № '.$order->getId(),
                'success_url' => $h.Engine::GetLinkMaker()->makeURLByContentIDParams('shop-payment-portmone', array(
                        'success' => 1,
                        'orderid' => $order->getId()
                    )),
                'failure_url' => $h.Engine::GetLinkMaker()->makeURLByContentIDParams('shop-payment-portmone',  array(
                        'fail' => 1,
                        'orderid' => $order->getId()
                    ))
            );

            $this->_addPaymentResult($order, $amount);

            return $a;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Получаем сумму заказа
     * @param $order
     * @return mixed
     */
    private function _getAmount($order) {
        try{
            $amount = $order->getSum();

            if ($order->getDeliveryid() && $order->getDelivery()->getPaydelivery()) {
                $amount += $order->getDeliveryprice();
            }
            return $amount;
        } catch (Exception $e) {

        }
    }

    /**
     * Создаем платеж в нашем магазине
     * @param $order
     * @param $amount
     * @return int
     */
    private function _addPaymentResult($order, $amount) {
        $sign = new XShopPaymentResult();
        $sign->setAmount($amount);
        $sign->setOrderid($order->getId());
        $sign->setStatus('sent');
        if (!$sign->select()) {
            $sign->insert();
        }
        return $sign->getId();
    }

    /**
     *
     * @param $orderId
     * @return bool
     */
    private function _successPayment() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID( $this->_orderId);
            $amount = $this->_getAmount($order);
            $sign = new XShopPaymentResult();
            $sign->setAmount($amount);
            $sign->setOrderid($order->getId());
            $sign->setStatus('sent');
            if ($sign->select() && $this->_checkPayment()) {

                Shop::Get()->getShopService()->payOrder(
                    $this->_orderId,
                    $amount,
                    true // не проверять ACL
                );

                $sign->setStatus('success');
                $sign->update();
                return true;

            }
            return false;
        } catch (Exception $e) {
            print $e;
            return false;
        }

    }

    /**
     *
     * @param $orderId
     */
    private function _failPayment() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID($this->_orderId);
            $amount = $this->_getAmount($order);
            $sign = new XShopPaymentResult();
            $sign->setAmount($amount);
            $sign->setOrderid($order->getId());
            $sign->setStatus('sent');
            if ($sign->select()) {
                $sign->setStatus('fail');
                $sign->update();
            }
        } catch (Exception $e) {

        }

    }

    /**
     * Проверяем успешно ли прошел платеж
     * @return bool
     * @throws ServiceUtils_Exception
     */
    private function _checkPayment() {
        $url = 'https://www.portmone.com.ua/gateway/';
        $params = array(
            'method' => 'result',
            'payee_id' => $this->_payee_id,
            'login' => $this->_login,
            'password' => $this->_password,
            'shop_order_number' => $this->_orderId,
            'status' => 'PAYED',
            'start_date' => date('d.m.Y'),
            'end_date' => date('d.m.Y')
        );

        $xml = new SimpleXMLElement($this->_getHtmlTextByUrl($url, $params));

        $order = Shop::Get()->getShopService()->getOrderByID($this->_orderId);
        $amount = $this->_getAmount($order);

        if (!is_object($xml) || !is_object($xml->portmoneresult) || !is_object($xml->portmoneresult->orders)) {
            throw new ServiceUtils_Exception('Bad xml response.');
        }
        foreach ($xml->portmoneresult->orders as $order) {
            if (is_object($order)) {
                if ( $order->status == 'PAYED' &&
                    $order->shop_order_number == $this->_orderId &&
                    $order->bill_amount == $amount ) {
                    return true;
                }
            }
        }
        return false;

    }

    /**
     * @param $url
     * @param $params
     * @return mixed
     */
    private function _getHtmlTextByUrl($url, $params) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params) );
        $file = curl_exec($ch);
        return $file;
    }


    private $_login = false; // логин магазина

    private $_password = false; // пароль магазина

    private $_payee_id = false; // идентификатор торговой точки

    private $_orderId = 0;

}