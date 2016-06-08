<?php

class users_ajax_search_dublicates_email extends Engine_Class {

    public function process() {
        try {
            $email = $this->getArgumentSecure('email');
            $emailArray = explode(',', $email);

            $a = array();
            foreach ($emailArray as $email) {
                try {
                    $users = Shop::Get()->getUserService()->getUsersByEmail(
                        $email,
                        $this->getUser()
                    );

                    while ($x = $users->getNext()) {
                        $a[] = array(
                        'id' => $x->getId(),
                        'email' => $email,
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