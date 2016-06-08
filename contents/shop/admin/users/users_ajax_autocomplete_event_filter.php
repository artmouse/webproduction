<?php

class users_ajax_autocomplete_event_filter extends Engine_Class {

    public function process() {
        try {
            
            $from = $this->getArgumentSecure('from');
            $email = new XShopUserEmail();
            $email->setLimitCount(10);
            $email->addWhere('email', '%' . $from . '%', 'LIKE');
            while ($x = $email->getNext()) {
                $a[] = array(
                    'from' => $x->getEmail(),
                );
            }
            
            $phone = new XShopUserPhone();
            $phone->setLimitCount(10);
            $phone->addWhere('phone', '%' . $from . '%', 'LIKE');
            while ($p = $phone->getNext()) {
                $a[] = array(
                    'from' => $p->getPhone(),
                );
            }
            echo json_encode($a);
            exit;
        } catch (Exception $e) {
            throw $e;
        }
    }
}