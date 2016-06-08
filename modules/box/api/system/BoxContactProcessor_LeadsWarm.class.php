<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxContactProcessor_LeadsWarm {

    public function process() {
        $processor = new BoxContactProcessor_Leads();
        $contacts = $processor->process();

        // которым мы написали и они ответили
        $contacts->addWhere('activitydatein', '0000-00-00 00:00:00', '<>');
        $contacts->addWhere('activitydateout', '0000-00-00 00:00:00', '<>');

        /*// с которыми были коммуникации за последние пол года
        // но не было за последние 2 недели
        $from = DateTime_Object::Now()->addMonth(-6)->__toString();
        $contacts->addWhere('activitydateout', $from, '>=');

        $to = DateTime_Object::Now()->addDay(-10)->__toString();
        $contacts->addWhere('activitydateout', $to, '<=');*/

        return $contacts;
    }

}