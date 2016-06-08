<?php
class user_search extends Engine_Class {

    public function process() {
        $a = array();
        $status = false;
        $errorsArray = array();

        try {
            $query = $this->getArgumentSecure('query');

            if ($query) {
                $users = Shop::Get()->getUserService()->searchUsers($query, $this->getUser());
                $users->setLimitCount(50);
            } else {
                $users = Shop::Get()->getUserService()->getUsersAll($this->getUser());
                $users->setOrder('name', 'ASC');
                $users->setLimitCount(50);
            }

            try {
                if ($this->getArgument('companyonly') == 1) {
                	$users->setTypesex('company');
                }
            } catch (Exception $companyEx) {

            }

            while ($x = $users->getNext()) {
                $a['all'][] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                );

                if ($x->getLevel() >= 2) {
                    $a['users'][] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    );
                } else {
                    $a['clients'][] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    );
                }
            }
            $status = 'success';
        } catch (Exception $e) {
            $status = 'error';
            $errorsArray = array();
        }

        $json = array(
        'status' => $status,
        'result' => $a,
        'errors' => $errorsArray
        );

        echo json_encode($json);
        exit();
    }

}