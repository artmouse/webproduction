<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

/**
 * Для отобранных событий иммитировать event2issue.
 */

$events = EventService::Get()->getEventsAll();
$events->setOrder('id', 'DESC');
$events->setType('email');
$events->filterTo('box@webproduction.ua');
$events->filterCdate('2015-09-16', '>=');
//$events->setFrom('slava140193@mail.ru');
//$events->setLimitCount(1);
while ($x = $events->getNext()) {
    print $x->getFrom()."\n";
    print $x->getTo()."\n";
    print $x->getSubject()."\n";
    print "\n";

    try {
        // выбрасываем событие
        $event = Events::Get()->generateEvent('boxEventAddAfter');
        $event->setEvent($x);
        $event->notify();
    } catch (Exception $ex) {
        print_r($ex);
    }
}

print "\n\ndone.\n\n";