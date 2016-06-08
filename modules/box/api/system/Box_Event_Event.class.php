<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class Box_Event_Event extends Events_Event {

    /**
     * @param ShopEvent $user
     */
    public function setEvent(ShopEvent $event) {
        $this->_event = $event;
    }

    /**
     * @return ShopEvent
     */
    public function getEvent() {
        return $this->_event;
    }

    private $_event;

}