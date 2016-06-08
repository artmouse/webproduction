<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

$force = @$argv[1];

$pidFile = __FILE__.'.pid';
$pidDate = @file_get_contents($pidFile);
if (!$force) {
    if ($pidDate > date('Y-m-d H:i:s', time() - 60*45)) {
        print "\n\nProcess already running...\n\n";
        exit();
    }
}

file_put_contents($pidFile, date('Y-m-d H:i:s'), LOCK_EX);

require(dirname(__FILE__).'/../packages/PackageLoader/include.php');
require(dirname(__FILE__).'/../api/services/ModeService.class.php');

// автоматически определяем режимы работы
ModeService::Get()->autoEnableModes();

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

print 'Running cron-minute for '.Engine::Get()->getProjectHost()."\n";

// генерируем событие
try {
    $event = Events::Get()->generateEvent('afterCronMinute');

    // показываем что будем запускать
    $a = $event->getObserverArray();
    foreach ($a as $object) {
        ModeService::Get()->verbose('Observer '.get_class($object));
    }

    $event->notify();
} catch (Exception $e) {
    print $e;
}

@unlink($pidFile);

print "\n\ndone.\n\n";