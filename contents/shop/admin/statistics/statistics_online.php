<?php
class statistics_online extends Engine_Class {

    public function process() {

        if ($kickID = $this->getArgumentSecure('kick')) {
            try {
                Shop::Get()->getUserService()->kickUser($kickID);
                $this->setValue('message', 'kick');
            } catch (Exception $e) {

            }
        }

        if ($banID = $this->getArgumentSecure('ban')) {
            try {
                Shop::Get()->getUserService()->banUser($banID);
                $this->setValue('message', 'ban');
            } catch (Exception $e) {

            }
        }

        $authes = new XUserAuth();
        $authes->setOrder('adate', 'DESC');
        $u = array();
        while ($auth = $authes->getNext()) {
            try {
                $x = Shop::Get()->getUserService()->getUserByID($auth->getUserid());
            } catch (Exception $e) {
                continue;
            }

            $a['login'] = $x->getLogin();
            $a['first_name'] = $x->getName();
            $a['last_name'] = $x->getNamelast();
            $a['middle_name'] = $x->getNamemiddle();
            $a['position'] = $x->getPost();
            $a['email'] = $x->getEmail();
            $a['url'] = $x->makeURLEdit();
            $a['id'] = $x->getId();
            $a['ip'] = $auth->getIp();
            $a['sid'] = $auth->getSid();
            $a['sdate'] = $auth->getSdate();
            $a['adate'] = $auth->getAdate();

            $u[] = $a;
        }
        $this->setValue('usersArray', $u);
    }

}