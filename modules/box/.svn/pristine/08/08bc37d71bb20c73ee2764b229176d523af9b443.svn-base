<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxContactProcessor_Clients {

    public function process() {
        // контакты с заказами в статусах оплачен/продан
        $statusIDArray = array(-1);
        $status = Shop::Get()->getShopService()->getStatusAll();
        $status->addWhereQuery("(saled=1 OR payed=1)");
        while ($x = $status->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhereQuery("id IN (SELECT userid FROM shoporder WHERE outcoming=0 AND statusid IN (".implode(',', $statusIDArray)."))");
        //$contacts->addWhere('level', 1, '<=');

        return $contacts;
    }

}