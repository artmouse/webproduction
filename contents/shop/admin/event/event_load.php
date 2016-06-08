<?php
class event_load extends Engine_Class {

    public function process() {
        try {
            $event = EventService::Get()->getEventByID(
                $this->getArgument('id')
            );

            $file = VoIPService::Get()->getCallFromFTP($event);

            $this->setValue('fileSound', $file->makeURL());
            $this->setValue('id', $event->getId());

        } catch (Exception $ge) {
            print $ge;

            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentID(500);
        }
    }

}