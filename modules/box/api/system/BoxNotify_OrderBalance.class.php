<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_OrderBalance {

    public function process() {
        if (date('D') == 'Sun') {
            return;
        }
        if (date('D') == 'Sat') {
            return;
        }

        $issueIDArray = array();

        /**
         * Проверка на нулевые заказы
         */

        // все статусы с требованием полной оплаты
        $statusIDArray = array(-1);
        $status = Shop::Get()->getShopService()->getStatusAll();
        $status->setPayed(1);
        while ($x = $status->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        // все заказы
        $orders = Shop::Get()->getShopService()->getOrdersAll();
        $orders->addWhereArray($statusIDArray, 'statusid');
        while ($order = $orders->getNext()) {
            $balance = $order->makeSumBalance();
            $balance = round($balance, 2);

            if ($order->getOutcoming()) {
            	if ($balance <= 0) {
            		continue;
            	}
            } else {
                if ($balance >= 0) {
                	continue;
                }
            }

            try {
                $manager = $order->getManagerOrAuthor();
            } catch (Exception $e) {
                continue;
            }

            $linkkey = 'order-'.$order->getId().'-balance';

            try {
                $clientName = $order->getUser()->makeName(false);
            } catch (Exception $e) {

            }

            $issueIDArray[] = NotifyService::Get()->addNotify(
            $manager,
            $linkkey,
            trim('Оплата заказа '.$order->getName()),
            'Необходима полная оплата в заказе '.$order->makeName().' для '.$clientName.', хотя ее нет.',
            $order->makeURLEdit(),
            false,
            $order->getUserid(),
            $order->getId()
            );
        }

        return $issueIDArray;
    }

}