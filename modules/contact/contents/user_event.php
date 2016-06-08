<?php
class user_event extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
                $this->getArgument('id')
            );

            if (!Shop::Get()->getUserService()->isUserViewAllowed($user, $this->getUser())) {
                throw new ServiceUtils_Exception('user');
            }

            Engine::GetHTMLHead()->setTitle($user->makeName());

            $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
            $menu->setValue('selected', 'event');
            $menu->setValue('userid', $user->getId());
            $this->setValue('menu', $menu->render());

            // находим все события от или на юзера
            $events = $user->getEvents();

            $block = Engine::GetContentDriver()->getContent('event-list-block');
            $block->setValue('events', $events);
            $block->setValue('user', $user);
            $this->setValue('block_event', $block->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();

        }
    }

}