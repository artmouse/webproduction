<?php

class Shop_NotificationService extends ServiceUtils_AbstractService {

    /**
     * Отправка уведомления о новом комментарии к заказу
     *
     * @param ShopOrder $order
     * @param User $user
     * @param string $comment
     * @param array $excludeNotifyUserArray
     */
    public function orderEmailNotification(ShopOrder $order, $user, $comment, $excludeNotifyUserArray = false) {
        $notifyArray = $this->getOrderUserNotifyArray($order, $comment);

        if (!$excludeNotifyUserArray) {
            $excludeNotifyUserArray = array();
        }

        // формируем список email
        $emailArray = array();
        foreach ($notifyArray as $x) {
            // исключение своего емейла
            if ($user && $x->getId() == $user->getId()) {
                continue;
            }

            // у юзера не установлена галочка "Присылать каждое уведомление на email"
            if (!$x->getNotify_email_one()) {
                continue;
            }

            // пропускаем заданных юзеров
            $skip = false;
            foreach ($excludeNotifyUserArray as $tmp) {
                if ($tmp->getId() == $x->getId()) {
                    $skip = true;
                    break;
                }
            }
            if ($skip) {
                continue;
            }

            if ($x->getEmail()) {
                $emailArray[] = $x->getEmail();
            }
        }

        // исключение дубликатов
        $emailArray = array_unique($emailArray);

        if (!$emailArray) {
            return;
        }

        $host = Engine::Get()->getProjectURL();

        // форматирование комментария для письма
        $comment = Shop::Get()->getShopService()->formatCommentForEmail($comment);

        // письмо в текстовом формате
        $text = '';
        if ($user) {
            $text .= $user->makeName(false, 'lfm').":\n";
        } else {
            $text .= "OneBox:\n";
        }

        $text .= $comment;
        $text .= "\n\n";
        $text .= '----------------------------------------'."\n";
        $text .= $order->makeName()."\n";
        $text .= $host.$order->makeURLEdit()."\n";
        $text .= "\n";
        try {
            $text .= 'Клиент: '.$order->getUser()->makeName(false)."\n";
        } catch (Exception $managerEx) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $managerEx;
            }
        }
        try {
            $text .= 'Менеджер: '.$order->getManager()->makeName(false)."\n";
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        if (!$order->getIssue()) {
            $text .= "Сумма: ".$order->getSum().' '.$order->getCurrency()->getName()."\n";
        }
        try {
            $parent = $order->getParent();
            if ($parent->getParentid() == 0) {
                $text .= 'Проект: '.$parent->makeName()."\n";
            }
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        try {
            $text .= "Бизнес-процесс: ".$order->getCategory()->getName()."\n";
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        try {
            $text .= "Этап: ".$order->getStatus()->getName()."\n";
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        try {
            $text .= "Источник: ".$order->getSource()->getName()."\n";
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        if ($order->getComments()) {
            $text .= "Комментарий:\n".$order->getComments()."\n";
        }

        $subject = '';
        try {
            $subject .= Engine::Get()->getConfigField('project-branding').' ';
        } catch (Exception $nameEx) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $nameEx;
            }
        }
        $subject .= '#'.$order->getId().' '.$order->getNumber(true).' '.$order->getName();
        $subject = str_replace('  ', ' ', $subject);
        $subject = trim($subject);

        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('box-parser-email');
        if (!$emailFrom) {
            $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
        }
        foreach ($emailArray as $emailTo) {
            $letter = new MailUtils_Letter($emailFrom, $emailTo, $subject, $text);
            $letter->send();
        }
    }

    /**
     * Проверить уведомления на валидность и удалить неправильные
     */
    public function processNotificationValid() {
        ModeService::Get()->verbose("Validate notifications...");

        $notifications = new ShopNotification();
        while ($notofication = $notifications->getNext()) {
            try{
                $notofication->getOrder();
                $notofication->getComment();
            } catch (Exception $enotifacation) {
                $notofication->delete();
            }
        }
    }

    /**
     * Удалить уведомления для пользователя по заказу
     *
     * @param User $user
     * @param ShopOrder $order
     */
    public function deleteNotification(User $user, ShopOrder $order) {
        $x = new ShopNotification();
        $x->setUserid($user->getId());
        $x->setOrderid($order->getId());
        $x->delete(true);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $this->buildNotificationCache($user);
        }
    }

    /**
     * Удалить все уведомления для пользователя
     *
     * @param User $user
     */
    public function deleteAllNotification(User $user) {
        $x = new ShopNotification();
        $x->setUserid($user->getId());
        $x->delete(true);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $this->buildNotificationCache($user);
        }
    }

    /**
     * Получить уведомления для пользователя
     *
     * @param User $user
     *
     * @return ShopNotification
     */
    public function getNotificationsByUser(User $user) {
        $x = new ShopNotification();
        $x->setUserid($user->getId());
        $x->setOrder('id', 'DESC');
        return $x;
    }

    /**
     * Построить кеш уведомлений.
     * Кеш записывается в JSON-файлы.
     *
     * @param User $user
     *
     * @return array
     */
    public function buildNotificationCache(User $user) {
        $cachNotificationContent = Engine::GetContentDriver()->getContent('shop-admin-notification-block');
        $cachNotificationContent->setValue('user', $user);
        $cachNotificationContent = $cachNotificationContent->render();

        $resultArray = array(
            'notificationList' => $cachNotificationContent
        );

        $file = PackageLoader::Get()->getProjectPath().'media/notification/notification-'.$user->getId().'.json';
        file_put_contents($file, json_encode($resultArray), LOCK_EX);

        return $resultArray;
    }

    /**
     * Добавить уведомления всем причастным пользователям о новом комментарии к заказу
     *
     * @param ShopOrder $order
     * @param CommentsAPI_XComment $comment
     */
    public function addNotification(ShopOrder $order, CommentsAPI_XComment $comment, $user) {
        $userArray = $this->getOrderUserNotifyArray($order, $comment);

        foreach ($userArray as $xuser) {
            if ($user) {
                if ($xuser->getId() == $user->getId()) {
                    continue;
                }
            }

            $x = new ShopNotification();
            $x->setUserid($xuser->getId());
            $x->setOrderid($order->getId());
            $x->setCommentid($comment->getId());
            $x->insert();

            if (Engine::Get()->getConfigFieldSecure('project-box')) {
                $this->buildNotificationCache($xuser);
            }
        }
    }

    /**
     * Отправить группированные уведомления пользователю $user
     *
     * @param User $user
     */
    public function orderEmailNotificationGroup(User $user) {
        $notifications = Shop::Get()->getShopService()->getNotificationsByUser($user);
        $notificationArray = array();
        while ($notification = $notifications->getNext()) {
            try {
                $comment = $notification->getComment();

                $commentArray = array();
                $commentArray['text'] = htmlspecialchars($comment->getContent());

                try {
                    $commentUser = Shop::Get()->getUserService()->getUserByID(
                        $comment->getId_user()
                    );

                    $commentArray['user'] = $commentUser->makeName(true, 'lfm');
                } catch (Exception $userEx) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $userEx;
                    }
                }

                $order = $notification->getOrder();
                if (!isset($notificationArray[$order->getId()])) {
                    $notificationArray[$order->getId()] = array(
                        'id' => $order->getId(),
                        'number' => $order->getNumber(true),
                        'name' => $order->getName(),
                        'url' => $order->makeURLEdit()
                    );
                }

                $notificationArray[$order->getId()]['commentArray'][] = $commentArray;
            } catch (ServiceUtils_Exception $se) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $se;
                }
            }
        }

        // письмо в текстовом формате
        $text = '';
        $host = Engine::Get()->getProjectURL();

        foreach ($notificationArray as $notification) {
            $text .= trim(
                str_replace(
                    '  ',
                    ' ',
                    '#'.$notification['id'].' '.$notification['number'].' '.$notification['name']
                )
            );
            $text .= ":\n\n";

            foreach ($notification['commentArray'] as $comment) {
                $commentText = Shop::Get()->getShopService()->formatCommentForEmail($comment['text']);

                if (isset($comment['user'])) {
                    $text .= $comment['user'].":\n";
                } else {
                    $text .= "OneBox:\n";
                }

                $text .= $commentText;
                $text .= "\n\n";
            }

            $text .= $host.$notification['url']."\n";
            $text .= '----------------------------------------'."\n\n";

        }

        if (!$text) {
            return false;
        }

        $subject = '';
        try {
            $subject .= Engine::Get()->getConfigField('project-branding').' ';
        } catch (Exception $nameEx) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $nameEx;
            }
        }
        $subject .= 'Уведомления';
        $subject = str_replace('  ', ' ', $subject);
        $subject = trim($subject);

        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('box-parser-email');
        if (!$emailFrom) {
            $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
        }

        $emailTo = $user->getEmail();
        if ($emailTo) {
            $letter = new MailUtils_Letter($emailFrom, $emailTo, $subject, $text);
            $letter->send();
        }
    }

    /**
     * Получить список notification-емейлов,
     * на которые будет выполняться отправка писем.
     *
     * @return array
     */
    public function getNotificationEmailArray($emailKey = 'email-orders') {
        $orderEmails = Shop::Get()->getSettingsService()->getSettingValue($emailKey);
        return $this->_extractEmailArray($orderEmails);
    }

    /**
     * Получить список notification-емейлов
     *
     * @param string $text
     *
     * @return array
     */
    protected function _extractEmailArray($text) {
        $text = str_replace(array("\r", "\n", "\t"), ' ', $text);
        $text = preg_replace("/([\s\,\;]+)/ius", ' ', $text);
        $orderEmailsArray = explode(' ', $text);
        $a = array();
        foreach ($orderEmailsArray as $x) {
            $x = trim($x);
            if (Checker::CheckEmail($x)) {
                $a[] = $x;
            }
        }
        return $a;
    }

    /**
     * Обновить способы уведомлений пользователя
     *
     * @param User $user
     * @param bool $notify_email_one
     * @param bool $notify_email_group
     * @param bool $notify_sms
     */
    public function updateUserNotifications(User $user, $notify_email_one,
                                            $notify_email_group, $notify_sms) {
        try {
            SQLObject::TransactionStart();

            // fire event
            $event = Events::Get()->generateEvent('shopUserEditBefore');
            $event->setUser($user);
            $event->notify();

            $user->setNotify_email_one($notify_email_one);
            $user->setNotify_email_group($notify_email_group);
            $user->setNotify_sms($notify_sms);
            $user->update();

            // fire event
            $event = Events::Get()->generateEvent('shopUserEditAfter');
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Сформировать список юзеров, которым надо отправить уведомление.
     * Комментарий нужен чтобы определять юзеров в тексте.
     *
     * @param ShopOrder $order
     * @param string $comment
     */
    public function getOrderUserNotifyArray(ShopOrder $order, $comment) {
        // формируем список всех, кому нужно это уведомление
        $userArray = array();
        try {
            $manager = $order->getManager();
            $userArray[$manager->getId()] = $manager;
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

        try {
            $author = $order->getAuthor();
            $userArray[$author->getId()] = $author;
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

        // все менеджеры заказа
        $oes = new XShopOrderEmployer();
        $oes->setOrderid($order->getId());
        while ($oe = $oes->getNext()) {
            try {
                $tmp = Shop::Get()->getUserService()->getUserByID($oe->getManagerid());
                $userArray[$tmp->getId()] = $tmp;
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }

        // все остальные наблюдатели
        /*$users = Shop::Get()->getUserService()->getUsersManagers();
        $users->setLevel(2);
        while ($u = $users->getNext()) {
            if ($u->isAllowed('notify-order-category-'.$order->getCategoryid())) {
                $userArray[$u->getId()] = $u;
            }
        }*/

        // парсим комментарий на предмет юзеров,
        // которым надо отправить временные уведомления
        if (preg_match_all("/\[(?:.+?)\#(\d+)\]/ius", $comment, $r)) {
            foreach ($r[1] as $userID) {
                try {
                    $userArray[$userID] = Shop::Get()->getUserService()->getUserByID($userID);
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }
        }

        // убираем заблокированных и клиентов
        foreach ($userArray as $index => $x) {
            if (!$x->getEmployer() || $x->getLevel() <= 1) {
                unset($userArray[$index]);
            }
        }

        return $userArray;
    }


    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_NotificationService
     */
    public static function Get() {
        if (!self::$_Instance) {
            $classname = self::$_Classname;
            if ($classname) {
                self::$_Instance = new $classname();
            } else {
                self::$_Instance = new self();
            }
        }
        return self::$_Instance;
    }

    /**
     * Задать класс сервиса.
     * override-метод.
     *
     * @param string $classname
     */
    public static function Set($classname) {
        self::$_Classname = $classname;
        self::$_Instance = null;
    }

    /**
     * Подменяемый объект сервиса
     *
     * @var Shop_NotificationService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}