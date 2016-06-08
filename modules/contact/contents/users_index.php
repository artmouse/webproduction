<?php
class users_index extends Engine_Class {

    public function process() {
        $users = Shop::Get()->getUserService()->getUsersAll();
        $users->setOrder('id', 'DESC');

        $canUserAdd = $this->getUser()->isAllowed('users-add');
        $this->setValue('canUserAdd', $canUserAdd);

        $list = Engine::GetContentDriver()->getContent('contact-list');
        $list->setValue('users', $users);
        $this->setValue('block_users', $list->render());
    }

}