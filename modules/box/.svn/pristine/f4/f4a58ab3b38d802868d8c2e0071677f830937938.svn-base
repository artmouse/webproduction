<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxContactProcessor_LeadsHot {

    public function process() {
        $processor = new BoxContactProcessor_Leads();
        $contacts = $processor->process();

        /*// с которыми были коммуникации за последние 2 недели
        $from = DateTime_Object::Now()->addDay(-10)->__toString();
        $contacts->addWhere('activitydateout', $from, '>=');*/

        // с которыми были встречи в последний месяц

        $from = DateTime_Object::Now()->addDay(-10)->__toString();

        $meetings = new ShopEvent();
        $meetings->setType('meeting');
        $meetings->addWhere('cdate', $from, '>=');
        $a = array(-1);
        while ($x = $meetings->getNext()) {
            $a[] = str_replace('contact-', '', $x->getFrom());
            $a[] = str_replace('contact-', '', $x->getTo());
        }
        $a = array_unique($a);

        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhereArray($a, 'id');

        return $contacts;
    }

}