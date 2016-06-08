<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_UnknownSkype {

    public function process() {
        /**
         * Поиск емейлов которых вообще нет в контактах.
         *
         * Идем письмам, которые отправили мы, и проверяем поле to.
         * Мы должны знать куда отправляли письмо.
         */

        $issueIDArray = array();

        $type = 'skype';

        // загружаем список ignore емейлов
        $ignoreArray = array();
        $ignores = new XShopEventIgnore();
        $ignores->addWhereQuery("(spam=1 OR notify=1 OR unknown=1)");
        while ($x = $ignores->getNext()) {
            $ignoreArray[$x->getAddress()] = $x->getAddress();
        }

        // строим список "наш skype" - "кто менеджер"
        $skypeArray = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $a = $x->getSkypeArray();
            foreach ($a as $skype) {
                $skypeArray[$skype] = $x;
            }
        }

        // идем по всем "to"
        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $q = $connection->query("SELECT `to`, `from`, COUNT(*) AS cnt FROM shopevent WHERE `type`='{$type}' GROUP BY `to`");
        while ($x = $connection->fetch($q)) {
            $from = $x['from'];
            $to = $x['to'];
            $cnt = $x['cnt'];

            if (!$from) {
                continue;
            }

            if (!$to) {
                continue;
            }

            // пропускаем ignore
            if (isset($ignoreArray[$to])) {
                continue;
            }

            // пытаемся найти контакт по полю to
            try {
                $toContact = Shop::Get()->getUserService()->findUserByContact($to, $type);

                // если это удалось - пропускаем проверку
                continue;
            } catch (Exception $e) {

            }

            // пытаемся найти контакт по полю from
            try {
                // находим менеджера
                $manager = @$skypeArray[$from];
                if (!$manager) {
                    continue;
                }

                // from найден
                // to не найден

                $content = $manager->makeName(false, 'fl');
                $content .= ', Вы обращались в skype ('.$cnt.' шт.) на ранее неизвестный адрес '.$to.'. Необходимо создать новый контакт с таким телефоном или добавить контакт в существующую карточку контакта.';
                $content .= "\n";
                $content .= "Чтобы посмотреть звонки нажмите на эту ссылку:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/shop/report/event/?from=$from&to=$to\n";
                $content .= "\n";
                $content .= "Чтобы создать новый контакт нажмите на эту ссылку:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/shop/users/add/?skypes=$to\n";
                $content .= "\n";
                $content .= "Чтобы добавить адрес в уже существующий контакт нажмите на эту ссылку:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/shop/users/addto/?skype=$to\n";
                $content .= "\n";
                $content .= "Если вы ошиблись или это неправильный адрес:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/ignore/add/?address=$to\n";
                $content .= "\n";

                $priority = 0;
                if ($cnt > 100) {
                    $priority = 1;
                }

                // создаем напоминание менеджеру
                $issueIDArray[] = NotifyService::Get()->addNotify(
                $manager,
                $type.'-'.md5($to),
                'Неизвестный skype '.$to,
                $content,
                false,
                $priority
                );
            } catch (Exception $e) {
                // если это не удалось - то письмо от неизвестного менеджера на неизвестный
                // и пока не знаем что с ним делать

                // @todo
            }
        }

        return $issueIDArray;
    }

}