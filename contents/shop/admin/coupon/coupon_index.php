<?php
class coupon_index extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('ok')) {
            $arguments = $this->getArguments();
            foreach ($arguments as $key => $item) {
                if (!strpos($key, 'check')) {
                    try{
                        $id = str_replace('check', '', $key);
                        $coup = new XShopCoupon($id);
                        try {
                            $product = Shop::Get()->getShopService()->getProductByCode1c('discountCoupon-'.$id);
                            $product->delete();
                        } catch (Exception $e) {

                        }
                        $coup->delete();
                    } catch (Exception $e) {

                    }

                }

                if (!strpos($key, 'used')) {
                    try{
                        $id = str_replace('used', '', $key);
                        $coup = new XShopCoupon($id);
                        $coup->setDateused(DateTime_Object::Now());
                        $coup->update();
                    } catch (Exception $e) {

                    }

                }
            }
        }

        $coupone = new XShopCoupon();
        $coupone->setOrder('id', 'DESC');
        $a = array();
        while ($c = $coupone->getNext()) {
            try {
                $code = $c->getCode();
                $code = substr_replace($code, '-', 4, 0);
                $code = substr_replace($code, '-', 9, 0);
                $code = substr_replace($code, '-', 14, 0);

                $dateUsed = $c->getDateused();
                if (!Checker::CheckDate($dateUsed)) {
                    $dateUsed = false;
                }
                $order = false;
                if ($c->getOrderid()) {
                    try {
                        $order = Shop::Get()->getShopService()->getOrderByID($c->getOrderid());

                    } catch (Exception $e) {

                    }
                }


                $a[] = array(
                'id' => $c->getId(),
                'code' => strtoupper($code),
                'date' => $dateUsed,
                'amount' => $c->getAmount(),
                'comment' => $c->getComment(),
                'orderid' => $c->getOrderid(),
                'orderUrl' => $order ? $order->makeURLEdit():false,
                'currencyid' => !$c->getCurrencyid() ?  '%' : 
                    Shop::Get()->getCurrencyService()->getCurrencyByID($c->getCurrencyid())->getName(),
                'send' => $c->getSendcoupon()
                );
            } catch (Exception $e) {

            }

        }

        $this->setValue('couponArray', $a);

    }

}