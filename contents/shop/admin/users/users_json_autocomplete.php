<?php
class users_json_autocomplete extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');

            $users = Shop::Get()->getUserService()->searchUsers($query, $this->getUser());
            $users->setLimitCount(10);
            $a = array();
            while ($x = $users->getNext()) {
                $name = $x->makeName();
                if ($x->getLogin()) {
                    $name .= ' @'.$x->getLogin();
                }

                $a[] = array(
                'id' => $x->getId(),
                'name' => trim('#'.$x->getId().' - '.$name),
                );
            }
            echo json_encode($a);
            exit();
        } catch (Exception $e) {

        }
    }

}