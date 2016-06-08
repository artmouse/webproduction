<?php
class users_ajax_info extends Engine_Class {

    public function process() {
        $a = array();
        $userID = $this->getArgumentSecure('id');

        try {
            $user = Shop::Get()->getUserService()->getUserByID($userID);
            $a['name'] = $user->getName();
            $a['namelast'] = $user->getNamelast();
            $a['namemiddle'] = $user->getNamemiddle();
            $a['email'] = $user->getEmail();
            $a['phone'] = $user->getPhone();
            $a['address'] = $user->getAddress();
            echo json_encode($a);
            exit();
        } catch (Exception $e) {

        }
    }

}