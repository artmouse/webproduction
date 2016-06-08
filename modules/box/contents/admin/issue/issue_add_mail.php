<?php
class issue_add_mail extends Engine_Class {

    public function process() {
        try {
            $event = EventService::Get()->getEventByID(
                $this->getArgumentSecure('eventid')
            );

            if ($this->getArgumentSecure('ok')) {
                try {
                    $parentid = substr($this->getArgument('parentid'), 1);
                    $issue = Shop_ShopService::Get()->getOrderByID($parentid);

                    Shop::Get()->getShopService()->addOrderEmail(
                        $issue,
                        $event->getFromContact(),
                        $event->getContent(),
                        $event->getAttachmentFileIDArray()
                    );

                    header('Location: '.$issue->makeURLEdit());
                } catch (Exception $ex) {
                    $this->setValue('message', 'error');
                }
            }

            try {
                $eventID = $this->getArgument('eventid');
                $events = EventService::Get()->getEventsAll();
                $events->setId($eventID);

                $block = Engine::GetContentDriver()->getContent('event-list-block');
                $block->setValue('events', $events);
                $block->setValue('showhidden', true);
                $block->setValue('noFilter', true);
                $this->setValue('block_event', $block->render());
            } catch (Exception $eventEx) {

            }
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
    }

}