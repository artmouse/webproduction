<?php
/**
 * KPI processor
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxKPI_EmailMonth {

    public function process(User $user, $direction = false) {
        $cdate = date('Y-m-01').' 00:00:00';

        $events = EventService::Get()->getEventsAll();
        $events->setType('email');
        $events->setFromuserid($user->getId());
        $events->addWhere('cdate', $cdate, '>=');
        if ($direction) {
            $events->setDirection($direction);
        }
        return $events->getCount();
    }

}