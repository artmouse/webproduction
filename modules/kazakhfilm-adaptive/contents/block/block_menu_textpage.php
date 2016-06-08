<?php
class block_menu_textpage extends Engine_Class {

    public function process() {
        $this->setValue('bookingUrl',Engine::GetLinkMaker()->makeURLByContentID('booking'));
        $this->setValue('guestbookUrl',Engine::GetLinkMaker()->makeURLByContentID('shop-guestbook'));
        $this->setValue('contentID',Engine::Get()->getRequest()->getContentID());
    }

}