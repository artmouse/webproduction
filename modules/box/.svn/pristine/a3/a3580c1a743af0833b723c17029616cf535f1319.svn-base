<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

// автоматическая простановка менеджера
// на основе последней коммуникации с контактом
$contacts = new User();
$contacts->setManagerid(0);
while ($x = $contacts->getNext()) {
    try {
        $events = $x->getEvents(false, 'to');
        $events->setOrder('cdate', 'DESC');
        $events->setLimitCount(1);
        if ($e = $events->getNext()) {
            $user = Shop::Get()->getUserService()->findUserByContact($e->getFrom(), $e->getType());

            $x->setManagerid($user->getId());
            $x->update();

            print 'Contact = '.$x->makeName()."\n";
            print 'Manager = '.$user->makeName()."\n";
            print "\n";
        }
    } catch (Exception $e) {

    }
}

$contacts = new User();
$contacts->setManagerid(0);
while ($x = $contacts->getNext()) {
    try {
        $events = $x->getEvents(false, 'from');
        $events->setOrder('cdate', 'DESC');
        $events->setLimitCount(1);
        if ($e = $events->getNext()) {
            $user = Shop::Get()->getUserService()->findUserByContact($e->getTo(), $e->getType());

            $x->setManagerid($user->getId());
            $x->update();

            print 'Contact = '.$x->makeName()."\n";
            print 'Manager = '.$user->makeName()."\n";
            print "\n";
        }
    } catch (Exception $e) {

    }
}

print "\n\ndone.\n\n";