<?php
/**
 * KPI processor
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxKPI_CallDay {

    public function process(User $user, $direction = false) {
        $cdate = date('Y-m-d').' 00:00:00';

        $events = EventService::Get()->getEventsAll();
        $events->setType('call');
        $events->setFromuserid($user->getId());
        $events->addWhere('cdate', $cdate, '>=');
        if ($direction) {
            $events->setDirection($direction);
        }
        return $events->getCount();
    }

}