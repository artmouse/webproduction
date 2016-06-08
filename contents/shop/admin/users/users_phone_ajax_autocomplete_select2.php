<?php
class users_phone_ajax_autocomplete_select2 extends Engine_Class {

    public function process() {
        try {
            $phone = $this->getArgument('phone');
            $phone = preg_replace("/\D/","", $phone);
            $users = Shop::Get()->getUserService()->getUsersAll();
            $users->addWhere('phone', '%'.$phone.'%', 'LIKE');
            $users->setLimitCount(10);

            while ($x = $users->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(false),
                    'email' => $x->getEmail(),
                    'phone' => $x->getPhone(),
                    'skype' => $x->getSkype(),
                    'whatsapp' => $x->getWhatsapp(),
                );
            }

            echo json_encode($a);
            exit;
        } catch (Exception $e) {
            throw $e;
        }

    }

}