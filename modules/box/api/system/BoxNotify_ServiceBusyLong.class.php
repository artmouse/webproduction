<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_ServiceBusyLong {

    public function process() {
        /**
         * Уведомление для администраторов если определенный продукт
         * сетки занятости давно не продавался.
         */

        // получаем контакты администраторов
        $adminArray = array();
        $admins = Shop::Get()->getUserService()->getUsersAll();
        $admins->setLevel(3);
        while ($x = $admins->getNext()) {
            $adminArray[] = $x;
        }

        if (!$adminArray) {
            return;
        }

        $issueIDArray = array();


        // идем по каждому товару и проверяем наличие заказов на последний
        // месяц
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setDeleted(0);
        $products->setSource('servicebusy');
        while ($x = $products->getNext()) {
            $linkkey = 'product-'.$x->getId().'-servicebusy-long';

            $ops = new ShopOrderProduct();
            $ops->setProductid($x->getId());
            $ops->setOrder('dateto', 'DESC');
            $ops->setLimitCount(1);
            if ($op = $ops->getNext()) {
                $diff = DateTime_Differ::DiffMonth('now', $op->getDateto());
                if ($diff >= 1) {
                    try {
                        $issueIDArray[] = NotifyService::Get()->addNotify(
                        $op->getOrder()->getManager(),
                        $linkkey,
                        'Продукт давно не продавался',
                        'Продукт #'.$x->getId().' '.$x->makeName().' не продавался более '.$diff.' мес. Последний заказ '.$op->getOrderid().' для '.$op->getOrder()->getUser()->makeName(false),
                        $x->makeURLEdit()
                        );
                    } catch (Exception $e) {

                    }
                }
            } else {
                foreach ($adminArray as $admin) {
                    try {
                        $issueIDArray[] = NotifyService::Get()->addNotify(
                        $admin,
                        $linkkey,
                        'Продукт не продавался вообще',
                        'Продукт #'.$x->getId().' '.$x->makeName().' не продавался вообще.',
                        $x->makeURLEdit()
                        );
                    } catch (Exception $e) {

                    }
                }
            }
        }

        return $issueIDArray;
    }

}