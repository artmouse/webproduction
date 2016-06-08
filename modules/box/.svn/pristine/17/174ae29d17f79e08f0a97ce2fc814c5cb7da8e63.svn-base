<?php
/**
 * Автоматическое уведомление про день рождение юзера.
 * Создает задачи и отправляет поздравляшки.
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 *
 * @copyright WebProduction
 * 
 * @package OneBox
 */
class BoxNotify_Birthday {

    public function process() {

        $tpl = Shop_SettingsService::Get()->getSettingValue('letter-shop-happy-birthday');
        
        if (!$tpl) {
            $tpl = @file_get_contents(PackageLoader::Get()->getProjectPath().'/media/mail-templates/birthday.html');
        }
        
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('email-orders');
        $companyName = Shop::Get()->getSettingsService()->getSettingValue('shop-company');

        $issueIDArray = array();

        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhere('bdate', '0000-00-00', '!=');
        while ($contact = $contacts->getNext()) {
            if (!Checker::CheckDate($contact->getBdate())) {
                continue;
            }

            $dateOriginal = DateTime_Object::FromString($contact->getBdate())->setFormat('m-d')->__toString();
            $dateNow = date('m-d');
            $dateBefore1 = DateTime_Object::Now()->addDay(+1)->setFormat('m-d')->__toString();
            $dateBefore10 = DateTime_Object::Now()->addDay(+7)->setFormat('m-d')->__toString();

            if ($dateOriginal != $dateNow && $dateOriginal != $dateBefore1 && $dateOriginal != $dateBefore10) {
                continue;
            }

            print "Birthday ".$contact->makeName()."\n";

            // сегодня у контакта ДР
            $manager = false;

            try {
                $manager = $contact->getManager();
            } catch (Exception $e) {

            }

            if (!$manager) {
                try {
                    $manager = $contact->getAuthor();
                } catch (Exception $e) {

                }
            }

            if ($manager) {
                $issueIDArray[] = NotifyService::Get()->addNotify(
                    $manager,
                    'contact-'.$contact->getId().'-birthday',
                    'День рождения у '.$contact->makeName(false),
                    date('Y').'-'.$dateOriginal.' у '.$contact->makeName(false).
                    ' День Рождения! Рекомендуем позвонить и поздравить его.',
                    false, // url
                    DateTime_Object::Now()->__toString(), // priority or date,
                    $contact->getId()
                );
            }

            // поздравления только в 9 утра в день рождения
            if ($dateOriginal == $dateNow && $tpl && $contact->getEmail() && date('H') == 9) {
                $name = trim($contact->getName().' '.$contact->getNamemiddle());
                if (!$name) {
                    $name = $contact->getCompany();
                }

                $message = $tpl;
                $message = str_replace('#name#', $name, $message);
                $message = str_replace('#company#', $companyName, $message);

                Shop::Get()->getUserService()->sendEmail(
                    $emailFrom,
                    $contact->getEmail(),
                    'Happy birthday from '.$companyName.'!',
                    $message,
                    'text',
                    false, // fileArray
                    Shop::Get()->getShopService()->getMailTemplate() // wrap in design
                );
            }
        }

        return $issueIDArray;
    }

}