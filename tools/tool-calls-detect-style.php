<?php

require(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');
Engine::Get()->enableErrorReporting();
$events = EventService::Get()->getEventCallsAll();
while ($x = $events->getNext()) {
    try {      
        $ctnTo = strlen($x->getTo());
        $ctnFrom = strlen($x->getFrom());
        try {
            $from = Shop::Get()->getUserService()->findUserByContact($x->getFrom(), $x->getType());
            $fromLevel = $from->getEmployer();
        } catch (Exception $ex) {
            $fromLevel = false;
        }
        try {
            $to = Shop::Get()->getUserService()->findUserByContact($x->getTo(), $x->getType());
            $toLevel = $to->getEmployer();
        } catch (Exception $ex) {
            $toLevel = false;
        }

        if ($ctnTo == $ctnFrom) {
            if ($fromLevel == $toLevel) {
                // внутренние
                $x->setDirection(0);
            } elseif ($fromLevel > $toLevel) {
                // исходящее
                $x->setDirection(+1);
            } elseif ($fromLevel < $toLevel) {
                // входящие
                $x->setDirection(-1);
            }
        } elseif ($ctnTo > $ctnFrom) {
            $x->setDirection(+1);
        } elseif ($ctnTo < $ctnFrom) {
            $x->setDirection(-1);
        }
        $x->update();
        print "This event call #".$x->getId()."\n";
    } catch (Exception $ex) {
        
    }
}
print "\n\ndone\n\n";