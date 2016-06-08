<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxContactProcessor_Leads {

    public function process() {
        // контакты у которых нет заказов оплаченных
        $statusIDArray = array(-1);
        $status = Shop::Get()->getShopService()->getStatusAll();
        $status->addWhereQuery("(saled=1 OR payed=1)");
        while ($x = $status->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhereQuery("id NOT IN (SELECT userid FROM shoporder WHERE statusid IN (".implode(',', $statusIDArray)."))");
        $contacts->addWhere('level', 1, '<=');
        $contacts->addWhereQuery("(activitydatein != '0000-00-00 00:00:00' OR activitydateout != '0000-00-00 00:00:00')");
        return $contacts;
    }

}