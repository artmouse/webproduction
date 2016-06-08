<?php
/**
 * Сервис по обработке событий и всего что с ним связано.
 * Событие в терминологии OneBox - это звонок/письмо/skype/viber/whatsapp,
 * в общем что происходит между контактами.
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class EventService {

    /**
     * Получить все события
     *
     * @return ShopEvent
     */
    public function getEventsAll($user = false) {

        $x = new ShopEvent();

        if ($user) {
            // накладываем ACL
            if ($user->getLevel() >= 3) {
                return $x;
            }
            $userID = $user->getId();

            $whereArray = array();

            // фильтр по менеджеру
            $managers = Shop::Get()->getUserService()->getUsersManagers();
            $managerIDArray = array($userID); // свои видно всегда
            while ($m = $managers->getNext()) {
                if ($user->isAllowed('users-manager-'.$m->getId().'-history')) {
                    $managerIDArray[] = $m->getId();
                }
            }
            if ($user->isAllowed('users-manager-0-history')) {
                $managerIDArray[] = 0;
            }
            $whereArray[] = 'touserid IN ('.implode(',', $managerIDArray)
                .') OR fromuserid IN ('.implode(',', $managerIDArray).') ';

            $x->addWhereQuery("(".implode(' AND ', $whereArray).")");
        }

        return $x;
    }

    /**
     * Получить все события-звонки
     *
     * @return ShopEvent
     */
    public function getEventCallsAll() {
        $x = $this->getEventsAll();
        $x->filterType('call');
        $x->setOrder('id', 'DESC');
        return $x;
    }

    /**
     * Поиск событий.
     * Внимание, метод может искать очень долго, если событий миллионы.
     *
     * @param string $query
     *
     * @return ShopEvent
     */
    public function searchEvents($query) {
        $query = trim($query);
        if (strlen($query) < 5 && !is_numeric($query)) {
            throw new ServiceUtils_Exception();
        }

        $events = $this->getEventsAll();
        $events->setHidden(0);
        $events->setOrder('id', 'DESC');
        $connection = $events->getConnectionDatabase();

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        foreach ($a as $part) {
            $w = array();

            if (is_numeric($part)) {
                $w[] = $events->getTablename().".id = '$part'";
            }

            $w[] = $events->getTablename().".from LIKE '%$part%'";
            $w[] = $events->getTablename().".to LIKE '%$part%'";
            $w[] = $events->getTablename().".subject LIKE '%$part%'";
            $w[] = $events->getTablename().".content LIKE '%$part%'";

            $events->addWhereQuery("(".implode(' OR ', $w).")");
        }

        return $events;
    }

    /**
     * Получить событие по номеру
     *
     * @param int $eventID
     *
     * @return ShopEvent
     */
    public function getEventByID($eventID) {
        $x = new ShopEvent($eventID);
        if ($x->getId()) {
            return $x;
        }
        throw new ServiceUtils_Exception();
    }

    /**
     * Проверить, есть ли парсер на этот почтовый ящик
     *
     * @param string $email
     *
     * @return bool
     */
    public function checkEmailParser($email) {
        try {
            $mailboxArray = Engine::Get()->getConfigField('project-box-event-parser-imap');
            foreach ($mailboxArray as $mailbox) {
                if ($mailbox['username'] == $email) {
                    return true;
                }
            }
        } catch (Exception $e) {

        }

        return false;
    }

    /**
     * Получить настройки email-парсера.
     * Метод вернет массив аккаунтов, которые нужно парсить.
     *
     * Внимание! Этот метод заменяет старый конфиг
     * project-box-event-parser-imap
     * Теперь чтобы получить настройки парсинга используейте ТОЛЬКО getEmailParserArray()
     *
     * @return array
     */
    public function getEmailParserArray() {
        // прочитать из таблицы shopeventimapconfig настройки IMAP парсинга почты
        // Внимание! Мы дописываем настройки! То что прописано в engine.mode.php все равно
        // остается и будет работать!
        $a = array();
        $imapConfig = new XShopEventIMAPConfig();
        while ($x = $imapConfig->getNext()) {
            $a[] = array (
                'host' => $x->getHost(),
                'username' => $x->getUsername(),
                'password' => $x->getPassword(),
                'port' => $x->getPort(),
                'name' => $x->getEmail(),
            );
        }

        $imapArray = Engine::Get()->getConfigFieldSecure('project-box-event-parser-imap');
        if (!$imapArray) {
            $imapArray = array();
        }
        $imapArray = array_merge($a, $imapArray);
        return $imapArray;
    }

    /**
     * Запустить IMAP-парсера.
     * Используется пакет IMAP.
     */
    public function processEmailParsers() {
        PackageLoader::Get()->import(dirname(__FILE__).'/../../packages/IMAP/include.php');

        // все активные почтовые ящики
        $mailboxeArray = $this->getEmailParserArray();
        foreach ($mailboxeArray as $mailbox) {
            ModeService::Get()->verbose('Parsing mailbox');
            ModeService::Get()->verbose($mailbox);

            if (empty($mailbox['username'])) {
                continue;
            }
            if (empty($mailbox['password'])) {
                continue;
            }
            if (empty($mailbox['host'])) {
                continue;
            }

            if (empty($mailbox['name'])) {
                $mailbox['name'] = $mailbox['username'];
            }

            try {
                $imap = new IMAP(
                    $mailbox['host'],
                    $mailbox['username'],
                    $mailbox['password'],
                    @$mailbox['port'],
                    @$mailbox['optionString']
                );

                $imap->connect();

                usleep(1000000 / rand(1, 1000)); // issue #63748 - smart timeout

                $emailCurrent = $mailbox['username'];
                if (!Checker::CheckEmail($emailCurrent)) {
                    $emailCurrent = false;
                }

                // читаем список ящиков
                $list = $imap->getMailboxArray();
                print_r($list);
                foreach ($list as $mailboxRef) {
                    if (preg_match("/Drafts$/ius", $mailboxRef)) {
                        continue;
                    }
                    /*if (preg_match("/Trash$/ius", $mailboxRef)) {
                    continue;
                    }*/
                    if (preg_match("/Junk$/ius", $mailboxRef)) {
                        continue;
                    }
                    if (preg_match("/Notes$/ius", $mailboxRef)) {
                        continue;
                    }

                    ModeService::Get()->verbose($mailbox['username']);
                    ModeService::Get()->verbose($mailboxRef);

                    usleep(1000000 / rand(1, 1000)); // issue #63748 - smart timeout

                    try {
                        $uidsArray = $imap->getMessageArray($mailboxRef);
                        ModeService::Get()->debug($uidsArray);
                    } catch (Exception $uidEx) {
                        ModeService::Get()->debug('No UIDs');
                        ModeService::Get()->debug($uidEx);
                        continue;
                    }

                    // читаем UID последнего сообщения
                    $lastUIDObject = new XShopEventEmailUID();
                    $lastUIDObject->setImap($mailbox['name'].'/'.$mailboxRef);
                    if (!$lastUIDObject->select()) {
                        $lastUIDObject->insert();
                    }

                    // максимальный UID в этой сесии
                    $uidMax = 0;

                    $index = 0;

                    foreach ($uidsArray as $uid) {
                        // пропускаем уже пройденные ранее UIDы
                        if ($uid < $lastUIDObject->getUid()) {
                            continue;
                        }

                        // вычисляем максимальный UID в этой сессии
                        if ($uid >= $uidMax) {
                            $uidMax = $uid;
                        }

                        // читаем сообщение
                        $this->processEmailParserMessage(
                            $imap,
                            $uid,
                            $mailboxRef,
                            true, // check
                            $emailCurrent
                        );

                        if ($index >= 100) {
                            $index = 0;

                            usleep(1000000 / rand(0, 1000)); // issue #63748 - smart timeout

                            if ($uidMax > 0) {
                                $lastUIDObject->setUid($uidMax);
                                $lastUIDObject->update();
                            }
                        }

                        $index++;
                    }

                    // записываем последний UID (максимальный)
                    if ($uidMax > 0) {
                        $lastUIDObject->setUid($uidMax);
                        $lastUIDObject->update();
                    }

                }
                $imap->disconnect();
            } catch (Exception $imapEx) {
                LogService::Get()->add(array('exception parse: '.$mailbox['host'].' / '.$mailbox['username']), 'imap');
                print_r($imapEx);
            }
        }
    }

    /**
     * Новый парсер звонков.
     * Который переписывает из CDR и event.
     *
     * Разработан на замену FTP-парсеру звонков.
     */
    public function processCallCDR() {
        ModeService::Get()->verbose('Process CDRs to ShopEvent...');

        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $q = $connection->query(
            "SELECT
            `source`,
            `destination`,
            `session`,
            `pickup`,
            `date`,
            `duration`,
            `filename`
            FROM cdr ORDER BY id DESC LIMIT 500"
        );

        while ($x = $connection->fetch($q)) {
            // кто звонит
            $from = $x['source'];

            // на какой номер
            $channel = $x['destination'];

            $session = $x['session'];
            $pickup = $x['pickup'];
            $date = @$x['date'];

            if (preg_match("/^\d+$/ius", $pickup)) {
                // если пикап это цифры - то это явно принятый звонок
                $to = $pickup;
                $status = 'ANSWER';
            } else {
                // иначе to - это канал
                $to = $channel;

                // а в поле пикап записан статус
                $status = $pickup;
            }

            $duration = (int) @$x['duration'];
            $file = $x['filename'];

            if ($file) {
                $file = '/'.substr($file, 0, 8).'/'.$file;
            }

            // добавляем звонок
            try {
                $this->addCall(
                    $from,
                    $to,
                    $date,
                    $file,
                    $status,
                    $channel,
                    $session,
                    $duration
                );
            } catch (Exception $ge) {
                print $ge;
            }
        }
    }

    /**
     * Добавить звонок
     *
     * @param $from
     * @param $to
     * @param $date
     * @param bool $file
     * @param bool $status
     * @param bool $channel
     * @param bool $session
     * @param bool $duration
     *
     * @return ShopEvent
     *
     * @throws ServiceUtils_Exception
     */
    public function addCall(
        $from, $to, $date, $file = false,
        $status = false, $channel = false, $session = false, $duration = false,
        $direction = false
    ) {
        $from = str_replace('+', '', $from);
        $to = str_replace('+', '', $to);
        $channel = str_replace('+', '', $channel);

        $duration = (int) @$duration;

        // проверка, чтобы было все что нужно
        // и не вставлялить пустые записи по тупому
        $ex = new ServiceUtils_Exception();
        if (!$from) {
            $ex->addError('from');
        }
        if (!$to) {
            $ex->addError('to');
        }
        if (!Checker::CheckDate($date)) {
            $ex->addError('date');
        }
        if ($ex->getCount()) {
            throw $ex;
        }

        // формат с секундами, это важно (так как не правильно проверим есть запись звонка или нет)
        $date = DateTime_Object::FromString($date)->setFormat('Y-m-d H:i:s')->__toString();

        // приводим в порядок форматы номеров
        $from = $this->formatCallNumber($from);
        $to = $this->formatCallNumber($to);
        $channel = $this->formatCallNumber($channel);

        try {
            SQLObject::TransactionStart();

            $call = new ShopEvent();
            $call->setType('call');
            $call->setCdate($date);
            $call->setFrom($from);
            $call->setTo($to);
            $call->setSession($session);
            if (!$call->select()) {
                $call->setFile($file);
                $call->setDuration($duration);
                $call->setStatus($status);
                $call->setChannel($channel);
                $call->setDirection($direction);
                $call->insert();

                // определяем параметры события
                EventService::Get()->processEventParameters($call);

                // выбрасываем событие
                $event = Events::Get()->generateEvent('boxEventAddAfter');
                $event->setEvent($call);
                $event->notify();
            }

            SQLObject::TransactionCommit();

            return $call;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Привести формат номера в правильный.
     * Процессор задается в engine.mode.php
     *
     * @param string $phone
     *
     * @return string
     */
    public function formatCallNumber($phone) {
        if ($this->_numberProcessorCache) {
            return $this->_numberProcessorCache->process($phone);
        }

        try {
            $numberProcessorClass = Engine::Get()->getConfigField('project-box-event-parser-call-processor');

            if (class_exists($numberProcessorClass)) {
                $numberProcessor = new $numberProcessorClass();
                $this->_numberProcessorCache = $numberProcessor;
                return $numberProcessor->process($phone);
            }
        } catch (Exception $e) {

        }

        return $phone;
    }

    /**
     * Читаем письмо с UID
     *
     * @param IMAP $imap
     * @param int $uid
     * @param string $mailboxRef
     *
     * @return ShopEvent
     */
    public function processEmailParserMessage(IMAP $imap, $uid, $mailboxRef, $check = true, $emailCurrent = false) {
        ModeService::Get()->verbose("Read message $uid...");

        $headerArray = $imap->getMessage($mailboxRef, $uid, true);

        if ($check) {
            if ($headerArray['spam']) {
                return;
            }

            // защита от авто-ответов
            // issue #38889
            if ($headerArray['autosubmitted']) {
                return;
            }

            if ($headerArray['mailerdaemon']) {
                return;
            }
        }

        $date = $headerArray['date'];
        $messageID = $headerArray['messageid'];
        $subject = $headerArray['subject'];
        $from = $headerArray['from'];
        $toArray = $headerArray['to'];

        // если передан емейл который парсим, то специально дописываем его в to.
        // это необходимо, так как бывает что письмо не специально попало в ящик,
        // и его заголовки to не содержат ящика, но письмо запарсить надо.
        if ($emailCurrent && $emailCurrent != $from) {
            $toArray[] = $emailCurrent;
            $toArray = array_unique($toArray);
        }

        // issue #61139 - do not parser future dates, yet.
        if ($date > DateTime_Object::Now()->addDay(+1)->__toString()) {
            return;
        }

        if ($check) {
            if ($this->_ignoredEmails === false) {
                $ignoredEmailsArray = array();
                $ignoredEmails = new XShopEventIgnore();
                $ignoredEmails->setSpam(1);
                while ($ignoredEmail = $ignoredEmails->getNext()) {
                    $ignoredEmailsArray[] = $ignoredEmail->getAddress();
                }
                $this->_ignoredEmails = $ignoredEmailsArray;
            }

            if (in_array($from, $this->_ignoredEmails)) {
                ModeService::Get()->verbose("Skip - ignored email from");
                return;
            }
        }

        if (!$toArray) {
            ModeService::Get()->verbose("Skip - no <TO> section or email letter maybe already parsed.");
            return;
        }

        ModeService::Get()->verbose($headerArray);

        // issue #55659
        // если это письмо от box@...
        $boxParser = Shop::Get()->getSettingsService()->getSettingValue('box-parser-email');
        if ($boxParser && $boxParser == $from) {
            // получается оно лежит в чьем-то inbox.
            // такое письмо надо пропускать
            ModeService::Get()->verbose("Skip - from box@");
            return;
        }

        // проверка есть ли такие письма, может не стоит их и парсить
        $parsedEmail = false;
        foreach ($toArray as $index => $to) {
            $email = new ShopEvent();
            $email->setType('email');
            $email->setFrom($from);
            $email->setTo($to);
            $email->setCdate($date);
            $email->setSubject($subject);
            if ($email->select()) {
                unset($toArray[$index]);
                $parsedEmail = $email;
                ModeService::Get()->verbose("Email already parsed - event#{$email->getId()}");
            }
        }

        if (!$toArray) {
            return $parsedEmail;
        }

        $return = false;

        $messageArray = $imap->getMessage($mailboxRef, $uid);

        // через сколько секунд делать sleepы?
        $sleepStep = 10;
        $sleepTime = 1;

        $saveDir = Shop::Get()->getFileService()->getMediaPath();

        // письмо получено.
        // сохраняем его в базу для каждого $to
        foreach ($toArray as $to) {
            try {
                SQLObject::TransactionStart();

                $email = new ShopEvent();
                $email->setType('email');
                $email->setFrom($from);
                $email->setTo($to);
                $email->setCdate($date);
                $email->setSubject($subject);
                $email->setMailbox($messageArray['mailbox']);
                $email->setSubjectgroup($messageArray['subjectgroup']);
                $email->setContent($messageArray['text']);
                $email->insert();

                if (!$return) {
                    $return = $email;
                }

                ModeService::Get()->verbose("Add event#{$email->getId()}");

                foreach ($messageArray['file'] as $attachment) {
                    // пропускаем пустые файлы
                    if (!$attachment['content']) {
                        continue;
                    }

                    if (!$attachment['name']) {
                        $attachment['name'] = 'Attachment for email '.$email->getId();

                        if ($attachment['type'] == 'text/html') {
                            $attachment['name'] = 'HTML content email '.$email->getId();
                        }
                    }

                    $att = Shop::Get()->getFileService()->addFileByContent(
                        $attachment['content'],
                        $attachment['name'],
                        $attachment['type'],
                        false, // user
                        'event-'.$email->getId(),
                        true // check doublicates
                    );
                }

                // определяем параметры события
                $this->processEventParameters($email);

                // выбрасываем событие
                $event = Events::Get()->generateEvent('boxEventAddAfter');
                $event->setEvent($email);
                $event->notify();

                SQLObject::TransactionCommit();
            } catch (ConnectionManager_Exception $ce) {
                ModeService::Get()->debug($ce);
                throw $ce;
            } catch (Exception $e) {
                SQLObject::TransactionRollback();
                ModeService::Get()->debug($e);
            }

            $this->_sleepCounter ++;
            if ($this->_sleepCounter > $sleepStep) {
                $this->_sleepCounter = 0;
                sleep($sleepTime);
            }
        }

        return $return;
    }

    /**
     * Для события посчитать оно in или out
     * и посчитать hidden или нет
     *
     * @param Event $event
     */
    public function processEventParameters(ShopEvent $event) {
        ModeService::Get()->verbose("Check parameters for event#".$event->getId());

        // определение пометок к звонку
        if (!$event->getContent() && $event->getType() == 'call') {
            // отступы погрешности
            $minuteFrom = DateTime_Object::FromString($event->getCdate())->addMinute(-15)->__toString();
            $minuteTo = DateTime_Object::FromString($event->getCdate())->addMinute(+15)->__toString();

            // поиск подходящей пометки
            $voipComment = new XShopUserVoIP();
            $voipComment->setFrom($event->getFrom());
            $voipComment->setTo($event->getTo());
            $voipComment->addWhere('cdate', $minuteFrom, '>=');
            $voipComment->addWhere('cdate', $minuteTo, '<=');
            $voipComment->setLimitCount(1);
            if ($x = $voipComment->getNext()) {
                $event->setContent($x->getComment());
                $event->update();
            }
        }

        // по полю channel определяем источник
        if (!$event->getSourceid()) {
            try {
                $source = $this->getSourceByAddress($event->getChannel());
                $event->setSourceid($source->getId());
                $event->update();
            } catch (Exception $sourceEx) {

            }
        }

        // issue #57560 - event cdate bugfix
        $cdate = $event->getCdate();
        if ($cdate > date('Y-m-d H:i:s')) {
            $cdate = false;
        }

        // определяем контакт from
        try {
            $from = Shop::Get()->getUserService()->findUserByContact($event->getFrom(), $event->getType());
            $fromLevel = $from->getEmployer();

            // записываем дату активности
            if ($cdate && $from->getActivitydate() < $event->getCdate()) {
                $from->setActivitydate($event->getCdate());
                $from->setActivitydateout($event->getCdate());
                $from->update();
            }

            // company activity
            try {
                $company = Shop::Get()->getShopService()->getCompanyByName($from->getCompany());

                if ($cdate && $company->getActivitydate() < $event->getCdate()) {
                    $company->setActivitydate($event->getCdate());
                    $company->setActivitydateout($event->getCdate());
                    $company->update();
                }
            } catch (Exception $companyEx) {

            }

            // записываем юзера
            $event->setFromuserid($from->getId());
        } catch (Exception $e) {
            $from = false;
            $fromLevel = false;
        }

        // определяем контакт to
        try {
            $to = Shop::Get()->getUserService()->findUserByContact($event->getTo(), $event->getType());
            $toLevel = $to->getEmployer();

            // записываем дату активности
            if ($cdate && $to->getActivitydate() < $event->getCdate()) {
                $to->setActivitydate($event->getCdate());
                $to->setActivitydatein($event->getCdate());
                $to->update();
            }

            // company activity
            try {
                $company = Shop::Get()->getShopService()->getCompanyByName($to->getCompany());

                if ($cdate && $company->getActivitydate() < $event->getCdate()) {
                    $company->setActivitydate($event->getCdate());
                    $company->setActivitydatein($event->getCdate());
                    $company->update();
                }
            } catch (Exception $companyEx) {

            }

            // записываем юзера
            $event->setTouserid($to->getId());
        } catch (Exception $e) {
            $to = false;
            $toLevel = false;
        }

        // определяем reply-параметры
        if ($event->getType() == 'email') {
            if (!$event->getReplyid()) {
                if ($event->getFrom() == $event->getTo()) {
                    // Если письмо самому себе - то replied = cdate
                    $event->setReplyid($event->getId());
                    $event->setReplydate($event->getCdate());
                    $event->update();
                } else {
                    // Иначе ищем после него любое письмо с таким же
                    // subject group, где from-to изменены местами
                    $tmp = new ShopEvent();
                    $tmp->setLimitCount(1);
                    $tmp->setOrder('cdate', 'ASC');
                    $tmp->setType('email');
                    $tmp->addWhere('cdate', $event->getCdate(), '>=');
                    $tmp->setSubjectgroup($event->getSubjectgroup());
                    // @todo: учитывать всего менеджера
                    $tmp->setFrom($event->getTo());
                    $tmp->setTo($event->getFrom());
                    if ($xtmp = $tmp->getNext()) {
                        $event->setReplyid($xtmp->getId());
                        $event->setReplydate($xtmp->getCdate());
                        $event->update();
                        unset($xtmp);
                    }
                    unset($tmp);
                }
            }
        }

        // ничего не нашли - скорее всего спам
        // и такие события считаем входящими
        if (!$from && !$to) {
            $event->setDirection(-1);
            // звонки и встречи не могут быть скрытыми
            if ($event->getType() == 'call' || $event->getType() == 'meeting' || $event->getType() == 'skype') {
                $event->setHidden(0);
            } else {
                $event->setHidden(1);
            }
            $event->update();

            return;
        }
        if (!$event->getDirection()) {
            if ($fromLevel == $toLevel) {
                // внутренние
                $event->setDirection(0);
            } elseif ($fromLevel > $toLevel) {
                // исходящее
                $event->setDirection(+1);
            } elseif ($fromLevel < $toLevel) {
                // входящие
                $event->setDirection(-1);
            }
        }
        if ($event->getType() == 'call') {
            $ctnTo = strlen($event->getTo());
            $ctnFrom = strlen($event->getFrom());

            if ($ctnTo == $ctnFrom) {
                // проверка нужна для того чтобы определить какой звонок
                // при если количество одинаково
                if ($fromLevel == $toLevel) {
                    // внутренние
                    $event->setDirection(0);
                } elseif ($fromLevel > $toLevel) {
                    // исходящее
                    $event->setDirection(+1);
                } elseif ($fromLevel < $toLevel) {
                    // входящие
                    $event->setDirection(-1);
                }
            } elseif ($ctnTo > $ctnFrom) {
                $event->setDirection(+1);
            } elseif ($ctnTo < $ctnFrom) {
                $event->setDirection(-1);
            }
        }
        if ($event->getType() == 'email') {
            // если from не найден, а to найден - скорее всего спам
            if (!$from && $to) {
                $event->setHidden(1);
            } else {
                $event->setHidden(0);
            }
        } elseif ($event->getType() == 'call') {
            // звонки не бывают скрытыми
            $event->setHidden(0);
            // @todo: прятать zero-calls
        } elseif ($event->getType() == 'sms') {
            // sms не бывают скрытыми
            $event->setHidden(0);
        } elseif ($event->getType() == 'skype') {
            // skype не бывает скрытым
            $event->setHidden(0);
        } elseif ($event->getType() == 'jabber') {
            // если from не найден, а to найден - скорее всего спам
            if (!$from && $to) {
                $event->setHidden(1);
            } else {
                $event->setHidden(0);
            }
        } elseif ($event->getType() == 'whatsapp') {
            // если from не найден, а to найден - скорее всего спам
            if (!$from && $to) {
                $event->setHidden(1);
            } else {
                $event->setHidden(0);
            }
        } elseif ($event->getType() == 'viber') {
            // если from не найден, а to найден - скорее всего спам
            if (!$from && $to) {
                $event->setHidden(1);
            } else {
                $event->setHidden(0);
            }
        }

        $event->update();
    }

    /**
     * Проверяем все hidden события, возможно какое-то станет не hidden
     * и в нем что-то изменится
     */
    public function processEventParametersAll($all = false) {
        ModeService::Get()->verbose('Process event parameters...');

        // за какой период обрабатывать звонки?
        $day = Engine::Get()->getConfigFieldSecure('project-box-event-parser-check-day');
        if (!$day) {
            $day = 5;
        }

        $events = new ShopEvent();
        $events->setOrder('id', 'DESC');
        if (!$all) {
            $events->addWhereQuery("cdate > NOW() - INTERVAL {$day} DAY");
        }
        $events->addWhereQuery("(fromuserid=0 OR touserid=0)");
        $index = 0;
        while ($x = $events->getNext()) {
            $this->processEventParameters($x);

            $index ++;
            if ($index > 100) {
                $index = 0;
                usleep(1000000 / rand(1, 1000)); // issue #63748 - smart timeout
            }
        }
    }

    /**
     * Добавить заметку к звонку
     *
     * @param int $callID
     * @param string $comment
     */
    public function addCallComment($callID, $comment) {
        try {
            SQLObject::TransactionStart();

            $comment = trim($comment);
            if (!$comment) {
                throw new ServiceUtils_Exception();
            }

            $voip = new XShopUserVoIP($callID);
            if (!$voip->getId()) {
                throw new ServiceUtils_Exception();
            }

            $voip->setComment($comment);
            $voip->update();

            // пытаемся найти звонок сразу
            $call = new ShopEvent();
            $call->setType('call');
            $call->setFrom($voip->getFrom());
            $call->setTo($voip->getTo());
            $call->addWhere('cdate', DateTime_Object::Now()->addMinute(-2)->__toString(), '>=');
            $call->setLimitCount(1);
            if ($x = $call->getNext()) {
                $x->setContent($comment);
                $x->update();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить источник по адресу.
     * В качестве адреса может быть email или номер телефона.
     *
     * @param string $address
     *
     * @return ShopSource
     */
    public function getSourceByAddress($address) {
        $address = trim($address);
        if (!$address) {
            throw new ServiceUtils_Exception();
        }

        $source = new ShopSource();
        $source->setAddress($address);
        if ($source->select()) {
            return $source;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Убрать из темы письма лишние обозначения,
     * типа Re/Fwd/CC/...
     *
     * @param string $subject
     *
     * @return unknown
     */
    public function parseSubjectGroup($subject) {
        // @todo после рефакторинга закопать

        return preg_replace(
            "/^(\[?(Fw|Re|Fwd|Ответ|Ha|Rcpt)\s*((\[\s*\d+\s*\])|(\(\s*\d+\s*\)))?\s*:\s*)+/usi",
            '',
            trim($subject, ' ]')
        );
    }

    private $_sleepCounter = 0;

    private $_ignoredEmails = false;

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return EventService
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
     * @var EventService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

    /**
     * Кеш объекта обработчика.
     * Чтобы постоянно не создавать объект
     *
     * @var object
     */
    private $_numberProcessorCache;

}