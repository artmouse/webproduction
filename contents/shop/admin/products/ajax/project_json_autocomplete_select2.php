<?php
class project_json_autocomplete_select2 extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');
            $cuser = $this->getUser();

            $orders = Shop::Get()->getShopService()->searchOrders($query, $cuser);
            $orders->setLimitCount(10);
            $a = array();

            while ($x = $orders->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName()
                );
            }

            // выдача результатов
            echo json_encode($a);
            exit;
        } catch (Exception $e) {
            throw $e;
        }
    }

}