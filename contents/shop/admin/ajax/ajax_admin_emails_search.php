<?php
class ajax_admin_emails_search extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('query');

            $a = array();

            $users = Shop::Get()->getUserService()->getUsersByEmail(
                $query,
                $this->getUser()
            );

            while ($user = $users->getNext()) {
                $emailArray = $user->getEmailArray();

                foreach ($emailArray as $email) {
                    $a[] = array(
                        'email' => $email,
                    );
                }

            }

        } catch (Exception $e) {

        }

        echo json_encode($a);
        exit;

    }

}