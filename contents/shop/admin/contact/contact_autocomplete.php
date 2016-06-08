<?php
class contact_autocomplete extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgumentSecure('name');
            $type = $this->getArgumentSecure('type');

            if (!$type) {
                $type = 'email';
            }

            $contacts = Shop::Get()->getUserService()->searchUsers($query);

            if ($type == 'email') {
                $contacts->addWhereQuery("(email <> '' OR emails <> '')");
            } elseif ($type == 'phone') {
                $contacts->addWhereQuery("(phone <> '' OR phones <> '')");
            }

            $a = array();
            while ($x = $contacts->getNext()) {
                if ($type == 'email') {
                	$ea = $x->getEmailArray();
                } elseif ($type == 'phone') {
                    $ea = $x->getPhoneArray();
                }

                foreach ($ea as $v) {
                    $a[] = array(
                    'name' => $x->makeName(),
                    'value' => $v,
                    );
                }
            }

            echo json_encode($a);
        } catch (Exception $e) {

        }

        exit();
    }

}