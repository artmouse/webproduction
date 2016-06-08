<?php

/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class CouponService {

    /**
     * Сгенерировать новый промо-код.
     * Метод вернет отформатированный кол.
     *
     * @param float $amount
     * @param int $currencyID
     * @param string $comment
     * @return string
     */
    public function generateCoupon($amount, $currencyID, $comment = false) {
        $ex = new ServiceUtils_Exception();

        if ($amount <= 0) {
            $ex->addError('minus');
        }

        if (!$currencyID && $amount > 100) {
            $ex->addError('100percent');
        }

        if ($ex->getCount()) {
            throw $ex;
        }

        try {
            SQLObject::TransactionStart();

            while (1) {
                $code = md5(uniqid(microtime(true), true));
                $code = substr($code, 0, 16);

                $coupon = new XShopCoupon();
                $coupon->setCode($code);
                if (!$coupon->select()) {
                	break;
                }
            }

            $coupon->setAmount($amount);
            $coupon->setCurrencyid($currencyID);
            $coupon->setComment($comment);
            $coupon->insert();

            SQLObject::TransactionCommit();

            $code = substr_replace($code, '-', 4, 0);
            $code = substr_replace($code, '-', 9, 0);
            $code = substr_replace($code, '-', 14, 0);
            $code = strtoupper($code);

            $couponProduct = Shop::Get()->getShopService()->addProduct('Использование скидочного купона');
            $couponProduct->setCode1c('discountCoupon-'.$coupon->getId());
            if ($currencyID) {
                $couponProduct->setCurrencyid($currencyID);
                $couponProduct->setPrice($amount*(-1));
            }
            $couponProduct->setLinkkey($code);
            $couponProduct->setHidden(1);
            $couponProduct->update();

            return $code;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * @return CouponService
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private static $_Instance = null;

}