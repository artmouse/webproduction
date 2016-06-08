<?php
class shop_admin_change_password extends Engine_Class {

    public function process() {
        
        try {
            $cuser = $this->getUser();
            
            if ($this->getArgumentSecure('ok')) {
                
                if (!$this->getArgumentSecure('oldpass')) {
                    throw new Exception('oldpass');
                }
                
                if (!$this->getArgumentSecure('newpass')) {
                    throw new Exception('newpassempty');
                }
                
                if (strlen($this->getArgumentSecure('newpass')) < 6) {
                    throw new Exception('smallpass');
                }

                if ($this->getArgumentSecure('newpass') != $this->getArgumentSecure('repeatpass')) {
                    throw new Exception('passnoteq');
                }
                
                $passold = Shop_UserService::Get()->createHash($this->getArgumentSecure('oldpass'));
                if ($passold != $cuser->getPassword()) {
                    throw new Exception('oldpassnotcorrect');
                } else {
                    $newpass = Shop_UserService::Get()->createHash($this->getArgumentSecure('newpass'));
                    $cuser->setPassword($newpass);
                    $cuser->update();
                }
                
                $this->setValue('message', 'ok');
            }
        } catch (Exception $ex) {
            $this->setValue('message', $ex->getMessage());
        }
        
    }

}