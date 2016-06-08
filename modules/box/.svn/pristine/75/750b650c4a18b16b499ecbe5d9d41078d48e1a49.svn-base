<?php
/**
 * KPI processor
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxKPI_OrderSaleProductCountMonth {

    public function process(User $user, $productID = false) {
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

        // ищем все orderproduct'ы в этих заказах
        $ops = new ShopOrderProduct();
        $ops->setProductid($productID);
        $ops->filterOrderid($orderIDArray);

        $result = 0;
        while ($x = $ops->getNext()) {
            $result += $x->getProductcount();
        }

        return round($result, 2);
    }

}