<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxContactProcessor_ClientsNow {

    public function process() {
        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhereQuery("id IN (SELECT userid FROM shoporder WHERE issue=0 AND outcoming=0)");
        $contacts->addWhere('level', 1, '<=');

        return $contacts;
    }

}