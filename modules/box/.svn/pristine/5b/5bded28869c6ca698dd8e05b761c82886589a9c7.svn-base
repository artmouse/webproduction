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

// поиск звонка
$event = new ShopEvent();
$event->setType('call');
$event->addWhere('content', 'SMS:%', 'LIKE');
while ($x = $event->getNext()) {
    print $x->getId()."\n";

    $x->setType('sms');
    $x->update();
}

print "\n\ndone.\n\n";