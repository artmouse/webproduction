<?php
class report_event extends Engine_Class {

    public function process() {
        // находим все события
        $events = EventService::Get()->getEventsAll($this->getUser());        
        $events->setOrder('cdate', 'DESC');

        $block = Engine::GetContentDriver()->getContent('event-list-block');
        $block->setValue('events', $events);
        $this->setValue('block_event', $block->render());
    }

}