<?php

require(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');
Engine::Get()->enableErrorReporting();
$events = EventService::Get()->getEventCallsAll();
while ($x = $events->getNext()) {
    
    if (!$x->getFromuserid()) {
        try {
            $from = Shop::Get()->getUserService()->findUserByContact($x->getFrom(), $x->getType());
            $x->setFromuserid($from->getId());
            $x->update();
            print "This event call #".$from->getId()."\n";
        } catch (Exception $ex) {

        }
    }
    if (!$x->getTouserid()) {
        try {
            $to = Shop::Get()->getUserService()->findUserByContact($x->getTo(), $x->getType());
            $x->setTouserid($to->getId());
            $x->update();
            print "This users call #".$to->getId()."\n";
        } catch (Exception $ex) {

        }
    }
}
print "\n\ndone\n\n";