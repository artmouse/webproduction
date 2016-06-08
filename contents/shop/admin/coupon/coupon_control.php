<?php
class coupon_control extends Engine_Class {

    public function process() {

        if ($this->getArgumentSecure('ok')) {
            try {

                $count = $this->getArgumentSecure('count');
                $amount = $this->getArgumentSecure('amount');
                $currencyId = $this->getArgumentSecure('currency');
                $comment = $this->getArgumentSecure('comment');

                if (!$count) {
                    $count = 1;
                }

                $s = '';
                for ($i = 1; $i <= $count; $i++) {
                    $code = CouponService::Get()->generateCoupon(
                        $amount,
                        $currencyId,
                        $comment
                    );

                    $s .= "\n".$code;
                }

                $this->setValue('message', 'ok');
                $this->setValue('codeStr', $s);

            } catch (ServiceUtils_Exception $se) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $se->getErrorsArray());
            }
        }

        if ($this->getArgumentSecure('edit')) {

            try{
                $amount = $this->getArgumentSecure('amount');
                $currencyId = $this->getArgumentSecure('currency');
                $code = $this->getArgumentSecure('code');
                $orderId = $this->getArgumentSecure('orderId');
                $comment = $this->getArgumentSecure('comment');
                $send = $this->getArgumentSecure('send');

                $e = new ServiceUtils_Exception();

                if (!$amount) {
                    $e->addError('amount');
                }

                if (!$code) {
                    $e->addError('code');
                }

                if ($e->getCount()) {
                    throw $e;
                }

                $id = $this->getArgumentSecure('id');
                $code = str_replace('-', '', $code);
                $code = strtolower($code);

                $couponEdit = new XShopCoupon($id);
                if ($couponEdit->getCode() != $code) {
                    try{
                        $couponProduct = Shop::Get()->getShopService()->getProductByCode1c(
                            'discountCoupon-'.$couponEdit->getId()
                        );
                        $couponProduct->setLinkkey($code);
                        $couponProduct->update();
                    } catch (Exception $e) {

                    }

                }
                $couponEdit->setCode($code);
                $couponEdit->setAmount($amount);
                $couponEdit->setCurrencyid($currencyId);
                $couponEdit->setOrderid($orderId);
                $couponEdit->setComment($comment);
                $couponEdit->setSendcoupon($send);

                if ($this->getArgumentSecure('used')) {
                    $couponEdit->setDateused(DateTime_Object::Now());
                } else {
                    $couponEdit->setDateused(false);
                }
                $couponEdit->update();

                $this->setValue('message', 'ok');

            } catch (ServiceUtils_Exception $se) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $se->getErrorsArray());
            }


        }

        if ($this->getArgumentSecure('id')) {
            $this->setValue('edit', true);
            $coupon = new XShopCoupon($this->getArgumentSecure('id'));
            $this->setControlValue('code', $coupon->getCode());
            $this->setControlValue('amount', $coupon->getAmount());
            $this->setControlValue('orderId', $coupon->getOrderid());
            $this->setValue('currencyid', $coupon->getCurrencyid());
            $this->setControlValue('comment', $coupon->getComment());
            $this->setControlValue('send', $coupon->getSendcoupon());
            if ($coupon->getDateused() != '0000-00-00 00:00:00') {
                $this->setValue('used', true);
            }
        }

        $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
        $currencyArray = array();
        while ($x = $currency->getNext()) {
            $currencyArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );

        }
        $currencyArray[] = array(
            'id' => 0,
            'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_percentage')
        );

        $this->setValue('currencyArray', $currencyArray);

    }

}