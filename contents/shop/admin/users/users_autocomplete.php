<?php
class users_autocomplete extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');

            $users = Shop::Get()->getUserService()->searchUsers($query, $this->getUser());
            $users->setLimitCount(10);
            $a = array();
            while ($x = $users->getNext()) {
                $name = htmlspecialchars($x->getName());
                if ($x->getLogin()) {
                    $name .= ' @'.$x->getLogin();
                }

                $a[] = array(
                'id' => $x->getId(),
                'name' => trim($name),
                );
            }
            $this->setValue('usersArray', $a);
        } catch (Exception $e) {

        }
    }

}