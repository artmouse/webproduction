<?php
class event_view extends Engine_Class {

    public function process() {
        try {
            $event = EventService::Get()->getEventByID(
            $this->getArgument('id')
            );

            PackageLoader::Get()->import('CommentsAPI');
            $key = 'event-'.$event->getId();

            // добавляем комментарий
            if ($this->getArgumentSecure('ok')) {
                try {
                    $text = $this->getControlValue('postcomment');

                    $object = CommentsAPI::Get()->addComment(
                    $key,
                    $text,
                    $this->getUser()->getId()
                    );

                    $event->setContent(trim($event->getContent()."\n".$text));
                    $event->update();
                } catch (Exception $e) {

                }
            }

            $comments = CommentsAPI::Get()->getComments($key);
            $block = Engine::GetContentDriver()->getContent('comment-block');
            $block->setValue('comments', $comments);
            $this->setValue('block_comment', $block->render());

            $events = new ShopEvent();
            $events->setId($event->getId());

            $block = Engine::GetContentDriver()->getContent('event-list-block');
            $block->setValue('events', $events);
            $block->setValue('noFilter', true);
            $this->setValue('block_event', $block->render());
        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}