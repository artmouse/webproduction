<?php
class users_ajax_autocomplete_select2 extends Engine_Class {

    /**
     * Этот код написал Максим М ради извращений с profidm
     *
     * @deprecated
     */
    public function process() {
        try {
            $searchTerm = $this->getArgument('name');
            $onlyCompany = $this->getArgumentSecure('onlyCompany');
            $onlyPerson = $this->getArgumentSecure('onlyPerson');
            $noAdd = $this->getArgumentSecure('noAdd');

            $a = array();
            if ($searchTerm) {
                $users = Shop::Get()->getUserService()->searchUsers($searchTerm);
            } else {
                $users = Shop::Get()->getUserService()->getUsersAll();
            }

            if ($onlyCompany) {
                $users->addWhere('typesex', 'company', '=');
            } elseif ($onlyPerson) {
                $users->addWhere('typesex', 'company', '!=');
            }

            $users->setLimitCount(10);

            while ($x = $users->getNext()) {
                $groupsArray = array();
                $groups = $x->getGroups();
                while ($group = $groups->getNext()) {
                    $groupsArray[$group->getId()] = $group->getName();
                }

                $sourceAddress = false;
                try {
                    $sourceAddress = $x->getSource()->getAddress();
                } catch (Exception $esource) {

                }
                $email = $x->getEmailArray();
                $phone = $x->getPhoneArray();
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(false, true, false),
                    'nameFirst' => $x->getName(),
                    'nameLast' => $x->getNamelast(),
                    'nameMiddle' => $x->getNamemiddle(),
                    'emailArray' => $email,
                    'phoneArray' => $phone,
                    'email' => @$email[0],
                    'phone' => @$phone[0],
                    'skype' => $x->getSkype(),
                    'whatsapp' => $x->getWhatsapp(),
                    'typesex' => $x->getTypesex(),
                    'company' => $x->getCompany(),
                    'post' => $x->getPost(),
                    'groups' => $groupsArray,
                    'source' => $sourceAddress
                );
            }

            if (!$noAdd) {
                $a[] = array(
                    'id' => 0,
                    'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_dobavit_').$searchTerm
                );
            }


            echo json_encode($a);
            exit;
        } catch (Exception $e) {
            throw $e;
        }

    }

}