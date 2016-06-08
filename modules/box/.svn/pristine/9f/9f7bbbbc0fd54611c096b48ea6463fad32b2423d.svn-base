<?php
/**
 * Создаем уведомления на неизвестные емейлы за последний месяц
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxNotify_UnknownEmail {

    public function process() {
        /**
         * Поиск емейлов которых вообще нет в контактах.
         *
         * Идем письмам, которые отправили мы, и проверяем поле to.
         * Мы должны знать куда отправляли письмо.
         */

        $issueIDArray = array();

        $type = 'email';

        // загружаем список ignore емейлов
        $ignoreArray = array();
        $ignores = new XShopEventIgnore();
        $ignores->addWhereQuery("(spam=1 OR notify=1 OR unknown=1)");
        while ($x = $ignores->getNext()) {
            $ignoreArray[$x->getAddress()] = $x->getAddress();
        }

        // строим список "наш емейл" - "кто менеджер"
        $emailArray = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $a = $x->getEmailArray();
            foreach ($a as $email) {
                $emailArray[$email] = $x;
            }
        }

        // идем по всем "to"
        $query = "SELECT
             `to`, `from`, COUNT(*) AS cnt
         FROM shopevent
            WHERE
            `type`='{$type}'
            AND cdate >= NOW() - INTERVAL 1 MONTH
            AND touserid=0
        GROUP BY `to`";

        $countLimit = Engine::Get()->getConfigFieldSecure('box-notify-unknownemail-limit');
        if (!$countLimit) {
            $countLimit = 1;
        }

        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $q = $connection->query($query);
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
                $manager = @$emailArray[$from];
                if (!$manager) {
                    continue;
                }

                // from найден
                // to не найден

                $content = $manager->makeName(false, 'fl');
                $content .= ', Вы написали письма ('.$cnt.' шт.) на ранее неизвестный email '.$to.'. ';
                $content .= 'Необходимо создать новый контакт с таким email ';
                $content .= 'или добавить контакт в существующую карточку контакта.';
                $content .= "\n";
                $content .= "Чтобы посмотреть письма нажмите на эту ссылку:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/shop/report/event/?from=$from&to=$to\n";
                $content .= "\n";
                $content .= "Чтобы создать новый контакт нажмите на эту ссылку:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/shop/users/add/?emails=$to\n";
                $content .= "\n";
                $content .= "Чтобы добавить email в уже существующий контакт нажмите на эту ссылку:\n";
                $content .= Engine::Get()->getProjectURL()."/admin/shop/users/addto/?email=$to\n";
                $content .= "\n";
                $content .= "Если вы ошиблись или это неправильный email:\n";
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
                    'Неизвестный email '.$to,
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