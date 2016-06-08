<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_ManagerNoActions {

    public function process() {
        $issueIDArray = array();

        if (date('D') == 'Sun') {
            return;
        }
        if (date('D') == 'Mon') {
            return;
        }

        $from = DateTime_Object::Now()->addDay(-1)->setFormat('Y-m-d').' 00:00:00';
        $to = DateTime_Object::Now()->addDay(-1)->setFormat('Y-m-d').' 23:59:59';

        $managers = Shop::Get()->getUserService()->getUsersAll();
        $managers->setLevel(2);
        while ($manager = $managers->getNext()) {

            // уведомления слать владельцам
            try {
                $admin = $manager->getManager();
            } catch (Exception $e) {
                continue;
            }

            $ok = false;

            // проверяем делал ли он что-то сегодня
            // звонок, письмо, заказ
            $events = $manager->getEvents();
            $events->setDirection(+1); // out
            $events->addWhere('cdate', $from, '>=');
            $events->addWhere('cdate', $to, '<=');
            $events->setLimitCount(1);
            if ($events->getNext()) {
                $ok = true;
            }

            if (!$ok) {
                $orders = Shop::Get()->getShopService()->getOrdersAll();
                $orders->setAuthorid($manager->getId());
                $orders->addWhere('cdate', $from, '>=');
                $orders->addWhere('cdate', $to, '<=');
                $orders->setLimitCount(1);
                if ($orders->getNext()) {
                    $ok = true;
                }
            }

            if (!$ok) {
                $issueIDArray[] = NotifyService::Get()->addNotify(
                $admin,
                'contact-'.$manager->getId().'-noactions',
                'Менеджер '.$manager->makeName().' вчера ничего не делал. Не создано ни одного заказа, не совершено ни одного звонка или письма.',
                false,
                1, // высокий приоритет
                $manager->getId()
                );
            }

            // проверка на количество уведомлений
            $notify = new XShopNotify();
            $notify->setUserid($manager->getId());
            $notify->setRdate('0000-00-00 00:00:00');
            $cnt = $notify->getCount();
            if ($cnt > 20) {
                $issueIDArray[] = NotifyService::Get()->addNotify(
                $admin,
                'contact-'.$manager->getId().'-noactions-notify',
                'У менеджера '.$manager->makeName().' более '.$cnt.' не сделаных уведомлений от системы и их количество особо не уменьшается. Просим принять меры.',
                false,
                1, // высокий приоритет
                $manager->getId()
                );
            }
        }

        return $issueIDArray;
    }

}