<?php
class event_rating extends Engine_Class {

    public function process() {
        try {
            $event = new ShopEvent($this->getArgument('eventid'));
            if (!$event->getId()) {
                throw new ServiceUtils_Exception();
            }

            $rating = $this->getArgument('rating', 'int');

            if ($rating <= 0) {
                $rating = 0;
            }
            if ($rating >= 5) {
                $rating = 5;
            }

            $event->setRating($rating);
            $event->update();

        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::GetQuery()->setContentNotFound();
        }
    }

}