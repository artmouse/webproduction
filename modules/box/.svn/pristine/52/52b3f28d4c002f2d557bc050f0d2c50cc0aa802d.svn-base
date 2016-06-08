<?php
class voip_call_save extends Engine_Class {

    public function process() {
        try {
            $callID = $this->getArgument('callid');
            $comment = $this->getArgument('comment');

            EventService::Get()->addCallComment(
                $callID,
                $comment
            );
        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}