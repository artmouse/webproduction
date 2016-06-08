<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$numberProcessor = false;
try {
    $numberProcessorClass = Engine::Get()->getConfigField('project-box-event-parser-call-processor');

    if (class_exists($numberProcessorClass)) {
        $numberProcessor = new $numberProcessorClass();
    }
} catch (Exception $e) {

}

$connection = ConnectionManager::Get()->getConnectionDatabase();
$q = $connection->query("SELECT * FROM cdr");

while ($x = $connection->fetch($q)) {
    $from = $x['src'];
    $to = $x['dstmod'];
    $date = $x['date'];
    $status = $x['disposition'];
    $duration = $x['duration'];

    print 'CDR '.$x['id']."\n";

    if ($numberProcessor) {
        $from = $numberProcessor->process($from);
        $to = $numberProcessor->process($to);
    }

    // внимание! тут старый формат дат без секунд
    $date = DateTime_Object::FromString($date)->setFormat('Y-m-d H:i')->__toString();

    // поиск звонка
    $event = new ShopEvent();
    $event->setType('call');
    $event->setCdate($date);
    $event->setFrom($from);
    $event->setTo($to);
    if ($event->select()) {
        print 'Event '.$event->getId()."\n";

        $event->setStatus($status);
        $event->setDuration($duration);
        $event->update();
    } else {
        print "Event not found\n";
    }

    print "\n";
}

print "\n\ndone.\n\n";