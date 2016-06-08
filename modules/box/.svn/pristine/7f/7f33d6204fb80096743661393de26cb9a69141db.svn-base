<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxContactProcessor_ClientsActive {

    public function process() {
        $processor = new BoxContactProcessor_Clients();
        $contacts = $processor->process();

        // с которыми недавно были события
        // @todo: переделать на "активные проекты"
        $from = DateTime_Object::Now()->addMonth(-1)->__toString();
        $contacts->addWhere('activitydate', $from, '>=');

        return $contacts;
    }

}