<?php
class user_unsubscribe extends Engine_Class {

    public function process() {
        try {
            $userID = $this->getArgument('code');
            $email = $this->getArgument('email');

            $user = Shop::Get()->getUserService()->getUserByID($userID);
            $emailArray = $user->getEmailArray();

            if (in_array($email, $emailArray)) {
            	$user->setDistribution(0);
            	$user->update();
            }
        } catch (Exception $e) {

        }
    }

}