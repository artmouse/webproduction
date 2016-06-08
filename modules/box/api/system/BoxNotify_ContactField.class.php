<?php
/**
 * Если у контакта нет телефона или емейла,
 * то создавать уведомление.
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_ContactField {

    public function process() {
        $issueIDArray = array();

        // все контакты у которых есть менеджер
        $contacts = new User();
        $contacts->addWhere('managerid', 0, '>');
        $contacts->addWhere('typesex', 'company', '!=');
        while ($x = $contacts->getNext()) {
            if (PackageLoader::Get()->getMode('debug')) {
                print "contact#".$x->getId()."\n";
            }

            try {
                $manager = $x->getManager();
            } catch (Exception $e) {
                continue;
            }

            $linkkey = 'contact-'.$x->getId().'-contacts';

            if (!$x->getEmailArray() && !$x->getPhoneArray()) {
                $text = 'Контакт #'.$x->getId().' '.$x->makeName(false).' не содержит email или телефона.';
                $text .= 'Обязательно укажите контактные данные.';

                $issueIDArray[] = NotifyService::Get()->addNotify(
                    $manager,
                    $linkkey,
                    'Нет контактов у '.$x->makeName(false),
                    $text,
                    false, // no URL
                    false, // priority
                    $x->getId()
                );
            }
        }

        return $issueIDArray;
    }

}