<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxContactProcessor_SuppliersActive {

    public function process() {
        // контакты с заказами в статусах оплачен/продан
        // у которых есть продукты с датами больше NOW

        $statusIDArray = array(-1);
        $status = Shop::Get()->getShopService()->getStatusAll();
        $status->addWhereQuery("(saled=1 OR payed=1)");
        while ($x = $status->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        // все заказы в этих статусах
        $contactIDArray = array(-1);
        $orders = Shop::Get()->getShopService()->getOrdersAll();
        $orders->addWhereArray($statusIDArray, 'statusid');
        $orders->addWhereQuery("EXISTS (SELECT * FROM shoporderproduct WHERE shoporderproduct.orderid=shoporder.id AND dateto > NOW())");
        $orders->setOutcoming(1);
        while ($x = $orders->getNext()) {
            $contactIDArray[] = $x->getUserid();
        }
        $contactIDArray = array_unique($contactIDArray);

        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhereArray($contactIDArray, 'id');
        //$contacts->addWhere('level', 1, '<=');

        return $contacts;
    }

}