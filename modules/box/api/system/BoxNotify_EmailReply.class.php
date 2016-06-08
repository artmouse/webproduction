<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_EmailReply {

    public function process() {
        $issueIDArray = array();

        $limit = DateTime_Object::Now()->addDay(-7)->__toString();

        // На все in письма должен быть reply в 4х часов.
        $from = DateTime_Object::Now()->addHour(-4)->__toString();
        $events = new ShopEvent();
        $events->setType('email');
        $events->setDirection(-1);
        $events->setReplyid(0);
        $events->addWhere('cdate', $from, '<=');
        $events->addWhere('cdate', $limit, '>=');
        while ($x = $events->getNext()) {
            try {
                $client = Shop::Get()->getUserService()->findUserByContact($x->getFrom(), 'email');

                // пропускаем письма от своих
                if ($client->isAdmin()) {
                    continue;
                }

                /*// проверяем чтобы у клиента были заказы
                if (!$client->getOrders()->select()) {
                    continue;
                }*/

                $manager = Shop::Get()->getUserService()->findUserByContact($x->getTo(), 'email');

                $diff = DateTime_Differ::DiffHour('now', $x->getCdate());

                $issueIDArray[] = NotifyService::Get()->addNotify(
                $manager,
                'contact-'.$client->getId().'-event-email-noreply-'.$x->getId(),
                'Нет ответа на письмо',
                'Более '.$diff.' часов нет ответа на письмо с темой '.$x->getSubject().' от '.$client->makeName().'. Срочно ответьте клиенту.',
                $x->makeURL(),
                false,
                $client->getId()
                );
            } catch (Exception $e) {

            }
        }

        /*// на все out - проверка в течении 10 дней на ответ
        $from = DateTime_Object::Now()->addDay(10)->__toString();
        $events = new ShopEvent();
        $events->setType('email');
        $events->setDirection(+1);
        $events->setReplyid(0);
        $events->addWhere('cdate', $from, '<=');
        $events->addWhere('cdate', $limit, '>=');
        while ($x = $events->getNext()) {
            try {
                $client = Shop::Get()->getUserService()->findUserByContact($x->getTo(), 'email');
                $manager = Shop::Get()->getUserService()->findUserByContact($x->getFrom(), 'email');

                $diff = DateTime_Differ::DiffDay('now', $x->getCdate());

                $issueIDArray[] = NotifyService::Get()->addNotify(
                $manager,
                'event-email-noreply-'.$x->getId(),
                'Более '.$diff.' дней от клиента '.$client->makeName().' нет ответа на ваше письмо с темой '.$x->getSubject().'. Рекомендуем повторить письмо клиенту.',
                $client->makeURLHistory(),
                0 // auto
                );
            } catch (Exception $e) {

            }
        }*/

        return $issueIDArray;
    }

}