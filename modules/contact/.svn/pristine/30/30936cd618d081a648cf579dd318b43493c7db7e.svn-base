<?php
class users_addto extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('ok')) {
            try {
                $email = $this->getArgumentSecure('email');
                $phone = $this->getArgumentSecure('phone');

                $clientID = $this->getArgument('clientid');
                $client = Shop::Get()->getUserService()->getUserByID($clientID);

                if ($email) {
                 $tmp = $client->getEmails()."\n".$email;
                 $tmp = trim($tmp);
                 $client->setEmails($tmp);
                 $client->update();
                }

                if ($phone) {
                 $tmp = $client->getPhones()."\n".$phone;
                 $tmp = trim($tmp);
                 $client->setPhones($tmp);
                 $client->update();
                }

                //$this->setValue('urlredirect', $client->makeURLEdit());

                header('Location: '.$client->makeURLEdit());

                $this->setValue('message', 'ok');
            } catch (Exception $ge) {
                $this->setValue('message', 'error');
            }
        }
    }

}