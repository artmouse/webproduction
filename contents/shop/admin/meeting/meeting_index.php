<?php

class meeting_index extends Engine_Class {

    public function process() {
        try {
            $id = $this->getArgumentSecure('id');

            $event = new ShopEvent();
            $event->setId($id);
            if (!$event = $event->getNext()) {
                throw new Exception;
            }

            if (!$event->getType() === 'meeting') {
                throw new Exception;
            }

            //параметры для выбора участников одной встречи
            $cdate = $event->getCdate();
            $from = $event->getFrom();

            $event = new ShopEvent();
            $event->setCdate($cdate);
            $event->setFrom($from);
            $event1 = clone $event;

            //получить всех участников встречи
            $x = $event->getNext();
            $userid = $x->getFromuserid();
            $user = Shop::Get()->getUserService()->getUserByID($userid);
            $fromuserid = $user->makeName();
            $meetingArray['fromuserid'] = $fromuserid;
            $meetingArray['cdate'] = $x->getCdate();
            $meetingArray['content'] = nl2br($x->getContent());
            $meetingArray['location'] = $x->getLocation();

            while ($x = $event1->getNext()) {
                $userid = $x->getTouserid();
                $user = Shop::Get()->getUserService()->getUserByID($userid);
                $touserid[] = $user->makeName();
            }

            $meetingArray['touserid'] = $touserid;

            $this->setValue('meetingArray', $meetingArray);
        } catch (Exception $e) {
            $this->setValue('message', 'error');
        }
    }

}
