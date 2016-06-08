<?php
/**
 * Анализ телефонных номеров на правильность формата
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class BoxNotify_IncorrectPhone {

    public function process() {
        $issueIDArray = array();

        $phones = new XShopUserPhone();
        $phones->innerJoinTable('users', 'users.id='.$phones->getTablename().'.userid');
        $phones->addWhereQuery('(users.authorid>0 or users.managerid>0)');
        while ($x = $phones->getNext()) {
            $phone = $x->getPhone();

            $ok = true;

            if (preg_match("/^0800/", $phone)) {
                continue;
            }

            if (preg_match("/^8(\d{6,})/", $phone)) {
                $ok = false;
            }

            if (preg_match("/^0(\d{6,})/", $phone)) {
                $ok = false;
            }

            if (strlen($phone) > 4 && strlen($phone) <= 7) {
                $ok = false;
            }

            if ($ok) {
                continue;
            }

            try {
                $contact = Shop::Get()->getUserService()->getUserByID($x->getUserid());

                // пропускаем удаленные контакты
                if ($contact->getDeleted()) {
                    continue;
                }

                $manager = $contact->getManagerOrAuthor();

                $text = 'Номер телефона '.$phone.' в контакте '.$contact->makeName(false);
                $text .= ' записан в некорректном формате. Просим исправить формат номер на полный.';

                $issueID = NotifyService::Get()->addNotify(
                    $manager,
                    'contact-'.$contact->getId().'-phone-format-'.$phone,
                    'Некорректный формат номера '.$phone. ' в '.$contact->makeName(false),
                    $text,
                    false,
                    false,
                    $contact->getId()
                );

                $issueIDArray[] = $issueID;
            } catch (Exception $e) {

            }
        }

        return $issueIDArray;
    }

}