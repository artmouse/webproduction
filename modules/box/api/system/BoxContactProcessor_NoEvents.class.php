<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxContactProcessor_NoEvents {

    public function process() {
        // контакты у которых нет коммуникаций вообще
        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->setActivitydate('0000-00-00 00:00:00');
        return $contacts;
    }

}