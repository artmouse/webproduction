<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_Meeting {

    public function process() {
        /**
         * Временно отключенный функционал.
         * Переделать на уведомления по почте.
         *
         * @todo
         */

        return;

        $issueIDArray = array();

        $day = date('Ymd');
        $from = DateTime_Object::Now()->setFormat('Y-m-d H').':00:00';
        $to = DateTime_Object::Now()->setFormat('Y-m-d').' 23:59:59';

        $events = new ShopEvent();
        $events->setType('meeting');
        $events->addWhere('cdate', $from, '>=');
        $events->addWhere('cdate', $to, '<=');
        while ($x = $events->getNext()) {
            // поиск автора
            try {
                $from = Shop::Get()->getUserService()->findUserByContact($x->getFrom(), 'meeting');
                $to = Shop::Get()->getUserService()->findUserByContact($x->getTo(), 'meeting');

                $time = DateTime_Formatter::TimeISO8601($x->getCdate());
                $location = $x->getLocation();
                if ($location) {
                    $location = "($location)";
                }

                if ($from->isManager()) {
                    // создаем напоминание
                    $issueIDArray[] = NotifyService::Get()->addNotify(
                    $from,
                    'contact-'.$to->getId().'-meeting'.'-'.$day,
                    'Встреча с '.$to->makeName(false),
                    'У вас сегодня встреча с '.$to->makeName(false).' в '.$time.' '.$location,
                    false,
                    1, // high
                    $to->getId()
                    );
                }

                if ($to->isManager()) {
                    // создаем напоминание
                    $issueIDArray[] = NotifyService::Get()->addNotify(
                    $to,
                    'contact-'.$from->getId().'-meeting'.'-'.$day,
                    'Встреча с '.$from->makeName(false),
                    'У вас сегодня встреча с '.$from->makeName(false).' в '.$time.' '.$location,
                    false,
                    1, // high
                    $from->getId()
                    );
                }
            } catch (Exception $e) {

            }
        }

        return $issueIDArray;
    }

}