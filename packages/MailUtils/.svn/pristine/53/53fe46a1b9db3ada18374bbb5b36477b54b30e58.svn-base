<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2015 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Реализация отправщика почты через обычную php-функцию mail()
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package MailUtils
 */
class MailUtils_SenderMail implements MailUtils_ISender {

    public function send(MailUtils_Letter $letter, $startDate = false) {
        if ($startDate) {
            throw new MailUtils_Exception('MailUtils_SenderMail does not support startDate');
        }

        $content = $letter->make(false); // without subject
        $content = explode("\n\n", $content, 2);

        mail(
            $letter->getEmailTo(),
            $letter->makeSubjectEncoded(),
            $content[1],
            $content[0]
        );

        $logEmails = MailUtils_Config::Get()->getLogEmails();
        foreach ($logEmails as $email) {
            mail(
                $email,
                $letter->makeSubjectEncoded(),
                $content[1],
                $content[0],
                '-f '.$letter->getEmailFrom()
            );
        }
    }

}