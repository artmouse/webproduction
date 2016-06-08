<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_ContactLongEvent {

    public function process() {
        $issueIDArray = array();

        // все контакты у которых есть менеджер
        $contacts = new User();
        $contacts->addWhere('managerid', 0, '>');
        while ($x = $contacts->getNext()) {
            try {
                $manager = $x->getManager();
            } catch (Exception $e) {
                continue;
            }

            $linkkey = 'contact-'.$x->getId().'-long';

            $events = $x->getEvents();
            $events->setOrder('cdate', 'DESC');
            $events->setLimitCount(1);
            if ($e = $events->getNext()) {
                $diff = DateTime_Differ::DiffDay('now', $e->getCdate()) ;
                if ($diff > 30) {
                    $issueIDArray[] = NotifyService::Get()->addNotify(
                    $manager,
                    $linkkey,
                    'Давно не было связи с '.$x->makeName(false),
                    'С контактом #'.$x->getId().' '.$x->makeName(false).' более '.$diff.' д. не было никаких коммуникаций. Необходимо связаться с контактом и предложить ему что-то или обсудить возможное сотрудничество, напомнить о себе.',
                    false,
                    false,
                    $x->getId()
                    );
                }
            }
        }

        return $issueIDArray;
    }

}