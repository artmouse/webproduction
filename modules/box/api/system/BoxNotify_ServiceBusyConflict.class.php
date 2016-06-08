<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_ServiceBusyConflict {

    public function process() {
        /**
         * Проверка конфликтов бронирование в сетке занятости
         * за все интервалы дат
         */

        // формируем список услуг с сеткой
        $productIDArray = array(-1);

        $issueIDArray = array();

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setDeleted(0);
        $products->setSource('servicebusy');
        while ($x = $products->getNext()) {
            $productIDArray[] = $x->getId();
        }

        // идем по всем заказанным товарам и просто записываем
        // интервал дат, ранее проверяя не было ли пересечений
        $opsArray = array();
        $ops = new ShopOrderProduct();
        $ops->addWhereArray($productIDArray, 'productid');
        while ($op = $ops->getNext()) {

            if (isset($opsArray[$op->getProductid()])) {
                foreach ($opsArray[$op->getProductid()] as $x) {
                    if ($op->getDatefrom() >= $x['from']
                    && $op->getDatefrom() <= $x['to']) {
                        // конфликт наложения

                        try {
                            $order = Shop::Get()->getShopService()->getOrderByID(
                            $op->getOrderid()
                            );

                            $issueIDArray[] = NotifyService::Get()->addNotify(
                            $order->getManager(),
                            'order-'.$order->getId().'-product-servicebusy-conflict-'.$op->getOrderid().'-'.$x['orderid'],
                            'Конфликт в сетке занятости',
                            'С продуктом '.$op->getProductname().' произошел конфликт наложения в сетке занятости. Между заказами '.$order->getId().' и '.$x['orderid'].' в дате '.$op->getDatefrom().'. Необходимо устранить его как можно быстрее.',
                            $order->makeURLEdit(),
                            1, // high priority
                            $order->getUserid()
                            );
                        } catch (Exception $e) {

                        }

                        continue;
                    }
                }
            }

            if (isset($opsArray[$op->getProductid()])) {
                foreach ($opsArray[$op->getProductid()] as $x) {
                    if ($op->getDateto() <= $x['to']
                    && $op->getDateto() >= $x['from']) {
                        // конфликт наложения

                        try {
                            $order = Shop::Get()->getShopService()->getOrderByID(
                            $op->getOrderid()
                            );

                            $issueIDArray[] = NotifyService::Get()->addNotify(
                            $order->getManager(),
                            'order-'.$order->getId().'-product-servicebusy-conflict-'.$op->getOrderid().'-'.$x['orderid'],
                            'С продуктом '.$op->getProductname().' произошел конфликт наложения в сетке занятости. Между заказами '.$order->getId().' и '.$x['orderid'].' в дате '.$op->getDateto().'. Необходимо устранить его как можно быстрее.',
                            $order->makeURLEdit(),
                            1, // high priority
                            $order->getUserid()
                            );
                        } catch (Exception $e) {

                        }

                        continue;
                    }
                }
            }

            $opsArray[$op->getProductid()][] = array(
            'orderid' => $op->getOrderid(),
            'from' => $op->getDatefrom(),
            'to' => $op->getDateto(),
            );

        }

        return $issueIDArray;
    }

}