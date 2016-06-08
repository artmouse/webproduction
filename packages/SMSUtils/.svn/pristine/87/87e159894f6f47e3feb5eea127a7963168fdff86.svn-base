<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2013 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Отложенный отправщик SMS через таблицу в базе.
 * Складывает SMS в таблицу в базе, а затем отдельным скриптом в cron'e
 * можно выполнять отправку по очереди.
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 *
 * @copyright WebProduction
 *
 * @package MailUtils
 */
class SMSUtils_SenderQueDB implements SMSUtils_ISender {

    public function __construct($package = 'SQLObject') {
        PackageLoader::Get()->import($package);

        if (!class_exists('SoapClient')) {
            throw new SMSUtils_Exception('SOAPClient not found');
        }
    }

    public function send($sender, $destination, $text) {
        try {
            SQLObject::TransactionStart();

            $que = new SMSUtils_XTurbosmsuaQue();
            $que->setCdate(date('Y-m-d H:i:s'));
            $que->setStatus(0); // не отправлено
            $que->setSender($sender);
            $que->setTo($destination);
            $que->setContent($text);
            $que->insert();

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Выполнить обработку очереди.
     *
     * @param int $limit
     */
    public static function ProcessQue(SMSUtils_ISender $sender, $limit = 40, $claerinterval = 168) {
        $que = new SMSUtils_XTurbosmsuaQue();
        $que->setStatus(0);
        $que->setResult('');
        $que->setLimitCount($limit);

        while ($x = $que->getNext()) {
            $diffdate = DateTime_Object::DiffDay(
                DateTime_Object::Now()->setFormat("Y-m-d H:i:s"), 
                DateTime_Object::FromString($x->getCdate())
            );
            if ($diffdate > 2) {
                $x->setPdate(date('Y-m-d H:i:s'));
                $x->setStatus(1);
                $x->setResult('time-send-over');
                $x->update();
            } else {
                // отправляем sms
                $result = $sender->send($x->getSender(), $x->getTo(), $x->getContent());

                if ($result == "success") {
                    $x->setPdate(date('Y-m-d H:i:s'));
                    $x->setStatus(1);
                }
                // обновляем информацию в базе
                $x->setResult($result);
                $x->update();
            }
        }

        $que = new SMSUtils_XTurbosmsuaQue();
        $que->setStatus(0);
        $que->addWhere('result', '', '<>');
        $que->setLimitCount($limit);
        $que->setOrder('id', 'desc');

        while ($x = $que->getNext()) {
            
            $diffdate = DateTime_Object::DiffDay(
                DateTime_Object::Now()->setFormat("Y-m-d H:i:s"), 
                DateTime_Object::FromString($x->getCdate())
            );           
            if ($diffdate > 2) {
                $x->setPdate(date('Y-m-d H:i:s'));
                $x->setStatus(1);
                $x->setResult('time-send-over');
                $x->update();
            } else {
                // отправляем sms 
                $result = $sender->send($x->getSender(), $x->getTo(), $x->getContent());

                if ($result == "success") {
                    $x->setPdate(date('Y-m-d H:i:s'));
                    $x->setStatus(1);
                } else {
                    $x->setTrycnt($x->getTrycnt() + 1);
                }
                if ($x->getTrycnt() >= 10) {
                    $x->setStatus(1);
                    $result = 'error-done';
                }
                // обновляем информацию в базе
                $x->setResult($result);
                $x->update();
            }
        
        }
        if (is_numeric($claerinterval)) {
            self::ClearQueue($claerinterval);
        }
    }

    /**
     * Очистить отработанную очередь.
     * $inteval указывается в часах и указывает максимальный срок хранения
     * обработанной записи с момента её обработки.
     * Если указать 0, то удалятся все уже отработанные записи очереди.
     *
     * @param int $inteval
     */
    public static function ClearQueue($interval = 168) {
        $interval = (int) $interval;

        try {
            SQLObject::TransactionStart();

            $que = new SMSUtils_XTurbosmsuaQue();

            $date = date('Y-m-d H:i:s', time() - $interval*3600);

            $que->setStatus(1);
            $que->addWhereQuery("pdate <= '{$date}'");
            $que->setLimitCount($interval);
            while ($x = $que->getNext()) {
                $x->delete();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();

            if (PackageLoader::Get()->getMode('debug')) {
                print "Exception: {$e->getMessage()}\n";
            }
        }
    }

}