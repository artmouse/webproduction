<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxContactProcessor_RecommendAll {

    public function process() {
        // контакты, которые кого либо рекомендовали хоть раз

        $tmp = Shop::Get()->getUserService()->getUsersAll();
        $tmp->addWhere('parentid', 0, '>');
        $a = array(-1);
        while ($x = $tmp->getNext()) {
            $a[] = $x->getParentid();
        }
        $a = array_unique($a);

        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhereArray($a, 'id');

        return $contacts;
    }

}