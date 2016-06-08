<?php
class admin_search_block_event extends Engine_Class {

    public function process() {
return;
        $query = $this->getValue('query');
        $limit = $this->getValue('limit');

        $eventArray = array();

        try {
            $events = EventService::Get()->searchEvents($query);
            $events->setLimitCount($limit);
            while ($event = $events->getNext()) {
                $eventArray[] = array(
                'id' => $event->getId(),
                'name' => $event->makeName(),
                'url' => $event->makeURL()
                );
            }
        } catch (ServiceUtils_Exception $se) {

        }

        $this->setValue('eventArray', $eventArray);
    }
}