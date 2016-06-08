<?php

/**
 * Cмарт обработчик
 *
 * @copyright WebProduction
 * @author Igor Kalamurda <i.kalamurda@webproduction.ua>
 * @package OneBox
 */
class BoxContactProcessor_ClientsHot {

    public function process() {
        // контакты с заказами в статусах оплачен/продан
        $statusIDArray = array(-1);
        $status = Shop::Get()->getShopService()->getStatusAll();
        $status->addWhereQuery("(saled=1 OR payed=1)");
        while ($x = $status->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        //Clients hot Клиенты из последним заказом до одного месяца
        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhereQuery(
            "id IN (SELECT userid FROM shoporder WHERE outcoming=0 AND
            shoporder.cdate >= NOW()-INTERVAL 1 MONTH AND statusid IN (".implode(',', $statusIDArray)."))"
        );

        return $contacts;
    }

}