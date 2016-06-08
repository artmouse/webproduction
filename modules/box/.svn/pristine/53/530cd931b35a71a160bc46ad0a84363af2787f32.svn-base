<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxContactProcessor_ClientsPermanent {

    public function process() {
        // контакты с заказами в статусах оплачен/продан
        $statusIDArray = array(-1);
        $status = Shop::Get()->getShopService()->getStatusAll();
        $status->addWhereQuery("(saled=1 OR payed=1)");
        while ($x = $status->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        // с которыми за последний год было больше 2х заказов
        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhereQuery("(SELECT COUNT(id) FROM shoporder WHERE outcoming=0 AND shoporder.userid=users.id AND shoporder.cdate >= NOW()-INTERVAL 1 YEAR AND shoporder.statusid IN (".implode(',', $statusIDArray)."))>2");
        $contacts->addWhere('level', 1, '<=');
        return $contacts;
    }

}