<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_ContactNoEvent {

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

            $linkkey = 'contact-'.$x->getId().'-noevent';

            $events = $x->getEvents();
            $events->setLimitCount(1);
            if (!$events->getNext()) {
                $issueIDArray[] = NotifyService::Get()->addNotify(
                $manager,
                $linkkey,
                'Не было связи с '.$x->makeName(false),
                'С контактом #'.$x->getId().' '.$x->makeName(false).' еще нет ни одного события (письма, звонка, встречи). Необходимо связаться с клиентом, иначе зачем он здесь :)',
                false,
                false,
                $x->getId()
                );
            }
        }

        return $issueIDArray;
    }

}