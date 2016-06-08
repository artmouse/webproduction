<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_OrderEmpty {

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

        // все статусы с требованием содержимого
        $statusIDArray = array(-1);
        $status = Shop::Get()->getShopService()->getStatusAll();
        $status->setNeedcontent(1);
        while ($x = $status->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        // все заказы
        $orders = Shop::Get()->getShopService()->getOrdersAll();
        $orders->addWhereArray($statusIDArray, 'statusid');
        while ($order = $orders->getNext()) {
            if ($order->getOrderProducts()->getCount() > 0) {
                continue;
            }

        	try {
        	    $manager = $order->getManagerOrAuthor();
        	} catch (Exception $e) {
        	    continue;
        	}

        	$linkkey = 'order-'.$order->getId().'-content';

            try {
                $clientName = $order->getUser()->makeName(false);
            } catch (Exception $e) {
                $clientName = '<?>';
            }

            $issueIDArray[] = NotifyService::Get()->addNotify(
            $manager,
            $linkkey,
            trim('Содержимое заказа '.$order->getName()),
            'Заказ '.$order->makeName().' для '.$clientName.' пуст. Укажите содержимое заказа и его подробности.',
            $order->makeURLEdit(),
            1, // высокий приоритет
            $order->getUserid(),
            $order->getId()
            );
        }

        return $issueIDArray;
    }

}