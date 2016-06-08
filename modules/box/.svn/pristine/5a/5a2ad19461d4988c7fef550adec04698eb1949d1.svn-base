<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Скрипт запускается и работает вечно:
 * вечный цикл, один сокет.
 *
 * Если запустить с параметром force - то это считается тестовым запуском, без вечных циклов и проверки pid.
 */

$force = @$argv[1];

$pidFile = __FILE__.'.pid';
$pid = @file_get_contents($pidFile);
if ($pid && !$force) {
    $returnProcessArray = array();
    exec('ps aux | grep cron-ami', $returnProcessArray);

    foreach ($returnProcessArray as $process) {
        if (preg_match('/^[\w\d]*\s*('.$pid.')\s+/uis', $process)) {
            print "\n\nProcess already running...\n\n";
            exit();
        }
    }
}

file_put_contents($pidFile, getmypid(), LOCK_EX);

require(dirname(__FILE__).'/../../../packages/PackageLoader/include.php');
require(dirname(__FILE__).'/../../../api/services/ModeService.class.php');

// автоматически определяем режимы работы
ModeService::Get()->autoEnableModes();

// подключем engine
require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$ami = Engine::Get()->getConfigField('asterisk-ami');
$host = $ami['host'];
$port = $ami['port'];
$login = $ami['login'];
$password = $ami['password'];

// подключаемся к ami
$ami = new AsteriskAMI($host, $port, $login, $password);
$ami->connect();

// загружаем обработчики номеров
$numberProcessor = false;
try {
    $numberProcessorClass = Engine::Get()->getConfigField('project-box-event-parser-call-processor');

    if (class_exists($numberProcessorClass)) {
        $numberProcessor = new $numberProcessorClass();
    }
} catch (Exception $e) {

}

$lineProcessor = false;
try {
    $lineProcessorClass = Engine::Get()->getConfigField('project-box-event-parser-call-line-processor');

    if (class_exists($lineProcessorClass)) {
        $lineProcessor = new $lineProcessorClass();
    }
} catch (Exception $e) {

}

while (1) {
    try {
        ModeService::Get()->verbose('SIPpeers');
        $data = $ami->command('SIPpeers', false, 'PeerlistComplete');
        ModeService::Get()->debug($data);

        $phoneArray = array();
        $dataArray = array();

        if (preg_match_all("/ObjectName: (\d+)/", $data, $r)) {
            foreach ($r[1] as $phone) {
                $phoneArray[$phone] = '';
            }
        }

        if (preg_match_all("/ObjectName: ([a-z]+)\-(\d+)/i", $data, $r)) {
            foreach ($r[2] as $phone) {
                $phoneArray[$phone] = '';
            }
        }

        ModeService::Get()->verbose('CoreShowChannels');
        $data = $ami->command('CoreShowChannels', false, 'CoreShowChannelsComplete');
        ModeService::Get()->debug($data);

        $data = str_replace("\r", '', $data);
        $data = explode("\n\n", $data);
        foreach ($data as $x) {
            if (!preg_match("/^Event: CoreShowChannel\n/ius", $x)) {
                continue;
            }

            $channel = false;
            $context = false;
            $state = false;
            $from = false;
            $to = false;
            $duration = false;

            if (preg_match("/Channel: (.+?)\n/ius", $x, $r)) {
                $channel = $r[1];
            }

            if (preg_match("/Context: (.+?)\n/ius", $x, $r)) {
                $context = $r[1];
            }

            if (preg_match("/ChannelStateDesc: (.+?)\n/ius", $x, $r)) {
                $state = $r[1];
            }

            if (preg_match("/ApplicationData: (.+?)\n/ius", $x, $r)) {
                $to = $r[1];
            }

            if (preg_match("/CallerIDnum: (.+?)\n/ius", $x, $r)) {
                $from = $r[1];
            }

            if (preg_match("/Duration: (.+?)\n/ius", $x, $r)) {
                $duration = $r[1];
            }

            if (!$from) {
                continue;
            }

            if (!$to) {
                continue;
            }

            if ($to == '(Outgoing Line)') {
                continue;
            }

            // по channel пытаемся определить линию (line)
            if ($lineProcessor) {
                $line = $lineProcessor->process($from, $channel);
            } else {
                $line = false;
            }

            // в to возможны варианты:
            // входящий в колл-центр SIP/111&SIP/112&SIP/113&SIP/952,,t
            // ApplicationData: SIP/111&SIP/112&SIP/113&SIP/952,,t
            // ApplicationData: SIP/443920200008/0503822127,,Tt
            // ApplicationData: SIP/User-105,,rTt
            // исходящий внутренний SIP/901/689689 - ok
            // входящий внутренний SIP/701,15,tm - ok
            // исходящий на мобильный казахстана SIP/10873/287773770277
            // входящий внешний с мобильного украины 810380503822127 - ок
            // входящий внешний с казахтелекома 87172449793 - ok

            $toArray = array();
            if (preg_match_all("/SIP\/(\d+)\&/ius", $to, $r)) {
                $toArray = $r[1];
            } elseif (preg_match("/SIP\/(\d+),/ius", $to, $r)) {
                $toArray[] = $r[1];
            } elseif (preg_match("/SIP\/([a-z]+)-(\d+),/ius", $to, $r)) {
                $toArray[] = $r[2];
            } elseif (preg_match("/SIP\/(?:.+?)\/(\d+)/ius", $to, $r)) {
                $toArray[] = $r[1];
            } elseif (preg_match("/^queue/ius", $to)) {
                if (preg_match("/ConnectedLineNum: (\d+)\n/ius", $x, $r)) {
                    $toArray[] = $r[1];
                }
            }

            $from = preg_replace("/\D/", '', $from);

            if ($numberProcessor) {
                $from = $numberProcessor->process($from);
            }

            foreach ($toArray as $index => $to) {
                $to = preg_replace("/\D/", '', $to);

                if ($numberProcessor) {
                    $to = $numberProcessor->process($to);
                }

                $toArray[$index] = $to;
            }

            if ($from && $toArray) {
                foreach ($toArray as $to) {
                    $phoneArray[$to] = $from;

                    $dataArray[] = array(
                    'from' => $from,
                    'to' => $to,
                    'channel' => $channel,
                    'state' => $state,
                    'duration' => $duration,
                    'line' => $line,
                    );
                }
            }
        }

        ModeService::Get()->verbose($dataArray);
        ModeService::Get()->verbose($phoneArray);

        /*try {
            SQLObject::TransactionStart();

            $voip = new XShopUserVoIPActive();
            $voip->delete(true);

            foreach ($phoneArray as $number => $tmp) {
                $voip = new XShopUserVoIPActive();
                $voip->setNumber($number);

                try {
                    $contact = Shop::Get()->getUserService()->findUserByContact($number, 'call');
                    $voip->setContactid($contact->getId());
                } catch (Exception $e) {

                }

                $voip->insert();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            print $ge;
        }*/

        $nonArray = array();

        // идентификатор звонка - это channel
        foreach ($dataArray as $x) {
            try {
                VoIPService::Get()->registerCall(
                    $x['from'],
                    $x['to'],
                    $x['channel'],
                    $x['state'],
                    $x['line'],
                    $x['duration']
                );

                // записываем "что поменяли"
                $nonArray[] = "'".$x['channel']."'";
            } catch (Exception $ge) {
                ModeService::Get()->debug($ge);
            }
        }

        // всем что не поменяли - надо поставить closed
        VoIPService::Get()->unregisterCallsNotChannel($nonArray);

    } catch (Exception $e) {
        ModeService::Get()->debug($e);
    }

    // для force-режима - единичный запуск
    if ($force) {
        break;
    }
    
    sleep(1);
}

$ami->disconnect();

print "\n\ndone.\n\n";