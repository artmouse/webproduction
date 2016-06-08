<?php
/**
 * Для всех неопознанных звонков создать уведомления
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_UnknownPhone {

    public function process() {
        /**
         * Поиск звонков которых вообще нет в контактах.
         *
         * Идем звонкам, которые отправили мы, и проверяем поле to.
         * Мы должны знать куда отправляли письмо.
         */

        $issueIDArray = array();

        $type = 'call';

        // загружаем список ignore емейлов
        $ignoreArray = array();
        $ignores = new XShopEventIgnore();
        $ignores->addWhereQuery("(spam=1 OR notify=1 OR unknown=1)");
        while ($x = $ignores->getNext()) {
            $ignoreArray[$x->getAddress()] = $x->getAddress();
        }

        // строим список "наш емейл" - "кто менеджер"
        $phoneArray = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $a = $x->getPhoneArray();
            foreach ($a as $phone) {
                $phoneArray[$phone] = $x;
            }
        }

        $countLimit = Engine::Get()->getConfigFieldSecure('box-notify-unknownphone-limit');
        if (!$countLimit) {
            $countLimit = 1;
        }

        // идем по всем "to"
        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $query = "SELECT `to`, `from`, COUNT(*) AS cnt FROM shopevent WHERE `type`='{$type}'";
        $query .= " AND (`status`='ANSWER' OR `status`='') AND cdate >= NOW() - INTERVAL 1 MONTH GROUP BY `to`";
        $q = $connection->query(
            $query
        );
        while ($x = $connection->fetch($q)) {
            $from = $x['from'];
            $to = $x['to'];
            $cnt = $x['cnt'];

            if ($cnt < $countLimit) {
                continue;
            }

            if (!$from) {
                continue;
            }

            if (!$to) {
                continue;
            }

            // пропускаем ignore
            if (!empty($ignoreArray[$to])) {
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
                $manager = @$phoneArray[$from];
                if (!$manager) {
                    continue;
                }

                // from найден
                // to не найден

                $content = $manager->makeName(false, 'fl');
                $content .= ', Вы сделали звонки ('.$cnt.' шт.) на ранее неизвестный номер '.$to.'.';
                $content .= ' Необходимо создать новый контакт с таким телефоном или добавить контакт';
                $content .= ' в существующую карточку контакта.';
                $content .= "\n";
                $content .= "Чтобы посмотреть звонки нажмите на эту ссылку:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/shop/report/event/?from=$from&to=$to\n";
                $content .= "\n";
                $content .= "Чтобы создать новый контакт нажмите на эту ссылку:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/shop/users/add/?phones=$to\n";
                $content .= "\n";
                $content .= "Чтобы добавить телефон в уже существующий контакт нажмите на эту ссылку:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/shop/users/addto/?phone=$to\n";
                $content .= "\n";
                $content .= "Если вы ошиблись или это неправильный номер:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/ignore/add/?address=$to\n";
                $content .= "\n";

                $priority = 0;
                if ($cnt > 10) {
                    $priority = 1;
                }

                // создаем напоминание менеджеру
                $issueIDArray[] = NotifyService::Get()->addNotify(
                    $manager,
                    $type.'-'.md5($to),
                    'Неизвестный номер телефона '.$to,
                    $content,
                    false,
                    $priority
                );
            } catch (Exception $e) {

            }
        }

        // идем по всем "from"
        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $query = "SELECT `from`, `to`, COUNT(*) AS cnt FROM shopevent WHERE `type`='{$type}' AND ";
        $query .= "(`status`='ANSWER' OR `status`='') AND cdate >= NOW() - INTERVAL 1 MONTH GROUP BY `from`";
        $q = $connection->query(
            $query
        );
        while ($x = $connection->fetch($q)) {
            $from = $x['from'];
            $to = $x['to'];
            $cnt = $x['cnt'];

            if ($cnt < $countLimit) {
                continue;
            }

            if (!$from) {
                continue;
            }

            if (!$to) {
                continue;
            }

            // пропускаем ignore
            if (!empty($ignoreArray[$from])) {
                continue;
            }

            // пытаемся найти контакт по полю from
            try {
                $fromContact = Shop::Get()->getUserService()->findUserByContact($from, $type);

                // если это удалось - пропускаем проверку
                continue;
            } catch (Exception $e) {

            }

            // пытаемся найти контакт по полю from
            try {
                // находим менеджера
                $manager = @$phoneArray[$to];
                if (!$manager) {
                    continue;
                }

                // to найден
                // from не найден

                $content = $manager->makeName(false, 'fl');
                $content .= ', было получено звонков ('.$cnt.' шт.) от ранее неизвестного номер '.$from.'.';
                $content .= ' Необходимо создать новый контакт с таким телефоном или добавить контакт';
                $content .= ' в существующую карточку контакта.';
                $content .= "\n";
                $content .= "Чтобы посмотреть звонки нажмите на эту ссылку:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/shop/report/event/?from=$from&to=$to\n";
                $content .= "\n";
                $content .= "Чтобы создать новый контакт нажмите на эту ссылку:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/shop/users/add/?phones=$from\n";
                $content .= "\n";
                $content .= "Чтобы добавить телефон в уже существующий контакт нажмите на эту ссылку:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/shop/users/addto/?phone=$from\n";
                $content .= "\n";
                $content .= "Если вы ошиблись или это неправильный номер:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/ignore/add/?address=$from\n";
                $content .= "\n";

                $priority = 0;
                if ($cnt > 10) {
                    $priority = 1;
                }

                // создаем напоминание менеджеру
                $issueIDArray[] = NotifyService::Get()->addNotify(
                    $manager,
                    $type.'-'.md5($from),
                    'Неизвестный номер телефона '.$from,
                    $content,
                    false,
                    $priority
                );
            } catch (Exception $e) {

            }
        }

        return $issueIDArray;
    }

}