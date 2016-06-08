<?php
class users_ajax_search_dublicates_namesurname extends Engine_Class {

    public function process() {
        try {
            $name = $this->getArgumentSecure('name');
            $nameLast = $this->getArgumentSecure('namelast');

            $users = Shop::Get()->getUserService()->getUsersAll($this->getUser());
            $users->addWhere('name', $name.'%', 'LIKE');
            $users->addWhere('namelast', $nameLast.'%', 'LIKE');
            $users->setLimitCount(30);
            $a = array();
            while ($x = $users->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'url' => $x->makeURLEdit(),
                );
            }

            echo json_encode($a);
        } catch (Exception $e) {

        }
        exit;
    }

}