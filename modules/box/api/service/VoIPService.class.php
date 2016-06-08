<?php
/**
 * Сервис по работе с VoIP OneBox
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class VoIPService {

    /**
     * Получить VOIP-звонок по ID
     *
     * @param int $callID
     *
     * @return XShopUserVoIP
     */
    public function getCallByID($callID) {
        $x = new XShopUserVoIP($callID);
        if ($x->getId()) {
            return $x;
        }
        throw new ServiceUtils_Exception();
    }

    /**
     * Перевести звонок
     *
     * @param int $callID
     * @param string $transferTo
     *
     * @return string
     */
    public function transferCall($callID, $transferTo) {
        $call = $this->getCallByID($callID);

        $contextIn = Engine::Get()->getConfigFieldSecure('asterisk-ami-context-in');
        if (!$contextIn) {
            $contextIn = 'office-calls';
        }

        $contextOut = Engine::Get()->getConfigFieldSecure('asterisk-ami-context-out');
        if (!$contextOut) {
            $contextOut = 'outgoing-calls';
        }

        $a = array();
        $a['Channel'] = $call->getChannel();
        if (strlen($transferTo) <= 4) {
            $a['Context'] = $contextIn;
        } else {
            $a['Context'] = $contextOut;
        }
        $a['Exten'] = $transferTo;
        $a['Priority'] = '1';

        $result = $this->_amiCommand('Redirect', $a);

        $call->setStatus('transfer');
        $call->update();

        return $result;
    }

    /**
     * Положить трубку, сбросить звонок
     *
     * @param int $callID
     *
     * @return string
     */
    public function hangupCall($callID) {
        $call = $this->getCallByID($callID);

        $a = array();
        $a['Channel'] = $call->getChannel();

        return $this->_amiCommand('Hangup', $a);
    }

    /**
     * Совершить звонок
     *
     * @param string $from
     * @param strong $to
     *
     * @return string
     */
    public function originateCall($from, $to) {
        $contextIn = Engine::Get()->getConfigFieldSecure('asterisk-ami-context-in');
        if (!$contextIn) {
            $contextIn = 'office-calls';
        }

        $contextOut = Engine::Get()->getConfigFieldSecure('asterisk-ami-context-out');
        if (!$contextOut) {
            $contextOut = 'outgoing-calls';
        }

        $a = array();
        $a['Channel'] = 'SIP/'.$from;
        $a['Callerid'] = $from;
        $a['Timeout'] = 20000;
        $a['Exten'] = $to;
        $a['Priority'] = 1;
        $a['Async'] = 'yes';
        if (strlen($to) <= 4) {
            $a['Context'] = $contextIn;
        } else {
            $a['Context'] = $contextOut;
        }

        return $this->_amiCommand('Originate', $a, 500);
    }

    /**
     * Загрузить файл по FTP и записать данные в ShopEvent
     *
     * @param ShopEvent $event
     */
    public function getCallFromFTP(ShopEvent $event) {
        // только звонки
        if ($event->getType() != 'call') {
            throw new ServiceUtils_Exception();
        }

        // получаем путь к файлу по хешу
        $filename = Shop::Get()->getFileService()->makeFilePathByHash($event->getFile());

        if (!file_exists($filename)) {
            // файла еще нет
            // в частности возможен только один вариант - грузить файл по FTP.

            // временный файл
            $tmp = PackageLoader::Get()->getProjectPath().'media/tmp/'.md5($event->getFile());

            // достаем настройки парсера
            try {
                $parser = Engine::Get()->getConfigField('project-box-event-call-ftp');
            } catch (Exception $parserEx) {

            }
            if (!isset($parser)) {
                $parser = Engine::Get()->getConfigField('project-box-event-parser-call');
            }

            $ftpHost = $parser['host'];
            $ftpLogin = $parser['login'];
            $ftpPassword = $parser['password'];
            $ftpPort = $parser['port'];
            $ftpPath = @$parser['path'];
            $ftpPasvMode = @$parser['pasv_mode'];
            if ($ftpPasvMode !== false) {
                $ftpPasvMode = true;
            }
            if (!$ftpPort) {
                $ftpPort = 21;
            }

            $ftp = ftp_connect($ftpHost, $ftpPort, 10);
            if (!$ftp) {
                throw new ServiceUtils_Exception('FTP connection failed');
            }

            ftp_login($ftp, $ftpLogin, $ftpPassword);
            ftp_pasv($ftp, $ftpPasvMode);

            if (!ftp_get($ftp, $tmp, $ftpPath.$event->getFile(), FTP_BINARY)) {
                throw new ServiceUtils_Exception('FTP download '.$ftpPath.$event->getFile().' failed');
            }

            ftp_close($ftp);

            if (filesize($tmp)) {
                // определяем расширение файла
                $ext = @pathinfo($event->getFile(), PATHINFO_EXTENSION);
                if (!$ext) {
                    $ext = 'wav';
                }

                // формируем имя файла
                $name = 'Call record '.$event->getId();
                $name .= ' from '.$event->getFrom();
                $name .=' to '.$event->getTo();
                $name .= ' date '.$event->getCdate();
                $name .= '.'.$ext;

                // создаем файл
                $file = Shop::Get()->getFileService()->addFile(
                    $tmp,
                    $name,
                    'audio/'.$ext // mime формируется автоматически
                );

                // записываем хеш в event
                $event->setFile($file->getFile());
                $event->update();

                // удаляем tmp
                @unlink($tmp);
            } else {
                throw new ServiceUtils_Exception('FTP empty file');
            }
        }

        return Shop::Get()->getFileService()->getFileByHash($event->getFile());
    }


    /**
     * Зарегистрировать или обновить входящий звонок (в XShopUserVoIP).
     * Метод используется сторонними модулями и asterisk ami для того чтобы зарегистировать звонок,
     * а OneBpx мог показать всплывающее окно.
     *
     * Индентификатором звонка для большиства систем рекомендуется использовать $channel -
     * - канал, на который позвонили.
     *
     * @param string $from
     * @param string $to
     * @param string $channel
     * @param string $status
     * @param string $line
     * @param int $duration
     *
     * @return XShopUserVoIP
     */
    public function registerCall($from, $to, $channel, $status, $line, $duration, $rebuildJSON = true) {
        try {
            SQLObject::TransactionStart();

            $voip = new XShopUserVoIP();
            $voip->setFrom($from);
            $voip->setTo($to);
            $voip->setChannel($channel);
            if (!$voip->select()) {
                $voip->setCdate(date('Y-m-d H:i:s'));

                // определяем from и to contactID
                try {
                    $contact = Shop::Get()->getUserService()->findUserByContact($from, 'call');
                    $voip->setContactfromid($contact->getId());
                } catch (Exception $e) {

                }

                try {
                    $contact = Shop::Get()->getUserService()->findUserByContact($to, 'call');
                    $voip->setContacttoid($contact->getId());
                } catch (Exception $e) {

                }

                $voip->insert();
            }

            $voip->setUdate(date('Y-m-d H:i:s'));
            $voip->setStatus($status);
            $voip->setLine($line);
            $voip->setDuration($duration);
            $voip->update();

            SQLObject::TransactionCommit();

            if ($rebuildJSON) {
                $this->rebuildCallJSON();
            }

            return $voip;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Для всех активных юзеров со звонками строим один JSON-файл.
     * Мы берем все звонки, которые сейчас активные, по ним строим все контакты и записываем
     * данные в voip.json.
     */
    public function rebuildCallJSON() {
        $voip = new XShopUserVoIP();
        $voip->setClosed(0);
        $a = array();
        while ($x = $voip->getNext()) {
            if ($x->getContactfromid()) {
                $a[] = $x->getContactfromid();
            }
            if ($x->getContacttoid()) {
                $a[] = $x->getContacttoid();
            }
        }
        $a = array_unique($a);

        // переписываем массив ради того, чтобы убрались ключи
        $b = array();
        foreach ($a as $x) {
            $b[] = (int) $x;
        }

        // формируем JSON-файлик
        $file = PackageLoader::Get()->getProjectPath().'media/notification/voip.json';
        $b = array('userArray' => $b);
        file_put_contents($file, json_encode($b), LOCK_EX);
    }

    /**
     * Закрыть звонок (считаем что он завершился).
     * Звонок будет помечен как closed=1, и всплывающее окно не будет показано.
     *
     * Метод используется внешними модулями, например, binotel.
     *
     * @param string $channel
     */
    public function unregisterCall($channel) {
        $voip = new XShopUserVoIP();
        $voip->filterChannel($channel);
        $rebuid = false;
        while ($x = $voip->getNext()) {
            $x->setClosed(1);
            $x->update();

            $rebuid = true;
        }

        if ($rebuid) {
            $this->rebuildCallJSON();
        }
    }

    /**
     * Массово закрыть все звонки, которые не входят в $nonChannelArray.
     * Внимание! Закрыты будут звонки, которые НЕ входят в $nonChannelArray!
     * Внимание! Если массив $nonChannelArray будет пуст - то закроются все звонки.
     *
     * @param array $nonChannelArray
     */
    public function unregisterCallsNotChannel($nonChannelArray, $rebuildJSON = true) {
        $voip = new XShopUserVoIP();
        if ($nonChannelArray) {
            $voip->addWhereQuery("channel NOT IN (".implode(',', $nonChannelArray).")");
        }
        $voip->filterClosed(0);
        $voip->setClosed(1, true);
        $voip->update(true);

        if ($rebuildJSON) {
            $this->rebuildCallJSON();
        }
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return VoIPService
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
     * Выполнить команду AMI
     *
     * @param array $paramArray
     *
     * @return string
     */
    private function _amiCommand($aciton, $paramArray, $usleep = false) {
        $ami = Engine::Get()->getConfigField('asterisk-ami');

        $host = $ami['host'];
        $port = $ami['port'];
        $login = $ami['login'];
        $password = $ami['password'];

        $ami = new AsteriskAMI($host, $port, $login, $password);
        $ami->connect();
        $data = $ami->command($aciton, $paramArray);
        if ($usleep) {
            usleep($usleep);
        }
        $ami->disconnect();

        return $data;
    }

    private static $_Instance = null;

    private static $_Classname = false;

}