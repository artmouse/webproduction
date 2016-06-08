<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxContactProcessor_LeadsCold {

    public function process() {
        $processor = new BoxContactProcessor_Leads();
        $contacts = $processor->process();

        // лиды, которым мы написали, но они не ответили
        $contacts->setActivitydatein('0000-00-00 00:00:00');
        $contacts->addWhere('activitydateout', '0000-00-00 00:00:00', '<>');

        return $contacts;
    }

}