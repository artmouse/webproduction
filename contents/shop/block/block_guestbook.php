<?php
class block_guestbook extends Engine_Class {

    public function process() {
        $this->setValue(
            'response',
            Shop::Get()->getSettingsService()->getSettingValue('response')
        );

        // количество отображаемых отзывов
        $maxcount = Shop::Get()->getSettingsService()->getSettingValue('response-maxcount');
        if ($maxcount <= 0) {
            return;
        }

        try {
            $guestbook = Shop::Get()->getGuestBookService()->getGuestBookAll();
            $guestbook->setOrder('cdate', "DESC");
            $guestbook->setLimitCount($maxcount);
            $guestbook->setDone(1);
            $a = array();
            while ($x = $guestbook->getNext()) {
                $name = $x->getName();
                $login = "";
                $color = 'gray';

                try {
                    $user = Shop::Get()->getUserService()->getUserByID($x->getUserid());

                    if (!$name) {
                        $name = htmlspecialchars($user->getName());
                        $login = htmlspecialchars($user->getLogin());
                    }

                    $color = $user->makeColor();
                } catch (Exception $e) {

                }

                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $name,
                    'login' => $login,
                    'date' => DateTime_Formatter::DateTimePhonetic($x->getCdate()),
                    'response' => htmlspecialchars($x->getText()),
                    'color' => $color
                );
            }
            $this->setValue('guestbookArray', $a);

            try {
                $page = Shop::Get()->getTextPageService()->getTextPageByLogicclass('shop-guestbook');
                $this->setValue('gurl', $page->getUrl());
            } catch (Exception $te) {

            }
        } catch(Exception $e) {

        }
    }

}