<?php
/**
 * Для всех событий type=call проводим форматирование номеров.
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$calls = EventService::Get()->getEventCallsAll();
while ($x = $calls->getNext()) {
    print "call#".$x->getId()."\n";

    $from = EventService::Get()->formatCallNumber($x->getFrom());
    $to = EventService::Get()->formatCallNumber($x->getTo());

    $x->setFrom($from);
    $x->setTo($to);
    $x->update();
}

print "\n\ndone.\n\n";