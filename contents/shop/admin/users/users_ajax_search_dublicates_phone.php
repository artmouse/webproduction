<?php

class users_ajax_search_dublicates_phone extends Engine_Class {

    public function process() {
        try {
            $phone = $this->getArgumentSecure('phone');
            $phoneArray = explode(',', $phone);

            $a = array();
            foreach ($phoneArray as $phone) {
                try {
                    $users = Shop::Get()->getUserService()->getUsersByPhone(
                        $phone,
                        $this->getUser()
                    );

                    while ($x = $users->getNext()) {
                        $a[] = array(
                        'id' => $x->getId(),
                        'phone' => $phone,
                        'url' => $x->makeURLEdit(),
                        );
                    }
                } catch (Exception $e) {

                }
            }

            echo json_encode($a);
        } catch (Exception $ge) {

        }
        exit();
    }

}