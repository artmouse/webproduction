<?php

/**
 * Cмарт обработчик
 *
 * @copyright WebProduction
 * @author Igor Kalamurda <i.kalamurda@webproduction.ua>
 * @package OneBox
 */
class BoxContactProcessor_ClientsLoyal {

    public function process() {
        // контакты с заказами в статусах оплачен/продан
        $statusIDArray = array(-1);
        $status = Shop::Get()->getShopService()->getStatusAll();
        $status->addWhereQuery("(saled=1 OR payed=1)");
        while ($x = $status->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        //client loyal более одной покупки за все время.
        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhereQuery(
            "(SELECT COUNT(id) FROM shoporder WHERE outcoming=0
            AND shoporder.userid=users.id  AND shoporder.statusid IN (".implode(',', $statusIDArray)."))>1"
        );

        return $contacts;
    }

}