<?php
/**
 * KPI processor
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxKPI_OrderSaleBrandMarginMonth {

    public function process(User $user, $brandID = false) {
        // получаем статусы заказов saled=1
        $status = Shop::Get()->getShopService()->getStatusAll();
        $status->setSaled(1);
        $statusIDArray = array(-1);
        while ($x = $status->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        // получаем все заказы юзера за текущий месяц
        $cdate = date('Y-m-01').' 00:00:00';
        $orders = Shop::Get()->getShopService()->getOrdersAll();
        $orders->setManagerid($user->getId());
        $orders->addWhere('cdate', $cdate, '>=');
        $orders->addWhereArray($statusIDArray, 'statusid');
        $orderIDArray = array(-1);
        while ($x = $orders->getNext()) {
            $orderIDArray[] = $x->getId();
        }

        // валюта системы
        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

        // все товары этого бренда
        $productIDArray = array(-1);
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setBrandid($brandID);
        while ($x = $products->getNext()) {
            $productIDArray[] = $x->getId();
        }

        // ищем все orderproduct'ы в этих заказах
        $ops = new ShopOrderProduct();
        $ops->filterProductid($productIDArray);
        $ops->filterOrderid($orderIDArray);

        $result = 0;
        while ($x = $ops->getNext()) {
            try {
                $margin = Shop::Get()->getCurrencyService()->convertCurrency(
                    $x->getProductprice(),
                    $x->getCurrency(),
                    $currencySystem
                );

                $margin -= Shop::Get()->getCurrencyService()->convertCurrency(
                    $x->getProduct()->getPricebase(),
                    $x->getProduct()->getCurrency(),
                    $currencySystem
                );

                $result += $x->getProductcount() * $margin;
            } catch (Exception $marginEx) {

            }
        }

        return round($result, 2);
    }

}