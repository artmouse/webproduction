<?php

class BoxProcessor_AllWhoTurnToUs {

    public function process() {
        $users = Shop::Get()->getUserService()->getUsersAll();
        $users->addWhereQuery("`users`.`id` IN (SELECT `userid` FROM `shoporder`)");
        $a = array(-1);
        while ($user = $users->getNext()) {
            try {
                if (!in_array($user->getId(), $a)) {
                    $a[] = $user->getId();
                }
                $company = Shop::Get()->getShopService()->getCompanyByName($user->getCompany());
                if (!in_array($company->getId(), $a)) {
                    $a[] = $company->getId();
                }
                $employers = Shop::Get()->getUserService()->getUsersAll();
                $employers->setCompany($company);
                while ($employer = $employers->getNext()) {
                    if (!in_array($employer->getId(), $a)) {
                        $a[] = $employer->getId();
                    }
                }
            } catch (Exception $exc) {
                
            }
        }
        $contacts = Shop::Get()->getUserService()->getUsersAll();
        $contacts->addWhereArray($a, 'id');

        return $contacts;
    }

}