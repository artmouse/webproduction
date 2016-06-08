<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class BoxContactProcessor_RecommendActive {

    public function process() {
        $tmp = Shop::Get()->getUserService()->getUsersAll();
        $tmp->addWhere('parentid', 0, '>');
        $a = array(-1);
        while ($x = $tmp->getNext()) {
            // проверка на платежи
            try {
                $payments = PaymentService::Get()->getPaymentsAll();
                $payments->setClientid($x->getId());
                if (!$payments->select()) {
                    continue;
                }
            } catch (Exception $e) {

            }

            $a[] = $x->getParentid();
        }
        $a = array_unique($a);

        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhereArray($a, 'id');

        return $contacts;
    }

}