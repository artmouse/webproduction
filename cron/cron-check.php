<?php

$cronDayFile = 'cron-day.php';
$cronHourFile = 'cron-hour.php';
$cronMinuteFile = 'cron-minute.php';

$notification = false;
$message = '';

if (file_exists(dirname(__FILE__).'/'.$cronDayFile.'.pid')) {

    $returnProcessArray = array();
    exec('ps ux | grep '.$cronDayFile, $returnProcessArray);

    if (count($returnProcessArray) <= 2) {
        $notification = true;
        $message.= "\ncron-day";

        @unlink(dirname(__FILE__).'/'.$cronDayFile.'.pid');
    }
}

if (file_exists(dirname(__FILE__).'/'.$cronHourFile.'.pid')) {

    $returnProcessArray = array();
    exec('ps ux | grep '.$cronHourFile, $returnProcessArray);

    if (count($returnProcessArray) <= 2) {
        $notification = true;
        $message.= "\ncron-hour";

        @unlink(dirname(__FILE__).'/'.$cronHourFile.'.pid');
    }
}

if (file_exists(dirname(__FILE__).'/'.$cronMinuteFile.'.pid')) {

    $returnProcessArray = array();
    exec('ps ux | grep '.$cronMinuteFile, $returnProcessArray);

    if (count($returnProcessArray) <= 2) {
        $notification = true;
        $message.= "\ncron-minute";

        @unlink(dirname(__FILE__).'/'.$cronMinuteFile.'.pid');
    }
}

if ($notification) {
    require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');
    LogService::Get()->add($message, 'cron');
    $message = "Host: ".Engine::Get()->getConfigFieldSecure('project-host')."\n".$message;
    mail("monitoring@amazino.com", "CRON FATAL", $message);

}

print "\n\ndone.\n\n";