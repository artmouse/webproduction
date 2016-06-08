<?php
class user_permission_json extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
            $this->getArgument('id')
            );

            $acl = Shop::Get()->getUserService()->getACLPermissions();
            $a = array();
            foreach ($acl as $x) {
                if ($user->isAllowed($x['key'])) {
                	$a[] = $x['key'];
                }
            }

            echo json_encode($a);
            exit();
        } catch (Exception $ge) {

        }
        exit();
    }

}