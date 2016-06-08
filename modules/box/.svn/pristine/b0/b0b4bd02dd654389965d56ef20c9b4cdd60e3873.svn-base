<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_ContactNoManager {

    public function process() {
        $issueIDArray = array();

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

        // все контакты у которых нет менеджера
        $contacts = new User();
        $contacts->setManagerid(0);
        $contacts->addWhere('level', 2, '<');
        while ($x = $contacts->getNext()) {
            $linkkey = 'contact-'.$x->getId().'-nomanager';

            foreach ($adminArray as $admin) {
                $issueIDArray[] = NotifyService::Get()->addNotify(
                $admin,
                $linkkey,
                'Нет менеджера у '.$x->makeName(false),
                'У контакта #'.$x->getId().' '.$x->makeName(false).' еще нет менеджера. Просим определить ответственное лицо.',
                false,
                false,
                $x->getId()
                );
            }
        }

        return $issueIDArray;
    }

}