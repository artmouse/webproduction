<?php
class users_ajax_autocomplete_custom_field_select2 extends Engine_Class {

    /**
     * Этот код написал Максим М ради извращений с profidm
     *
     * @deprecated
     */
    public function process() {
        try {
            $searchTerm = $this->getArgument('name');
            $searchTerm = str_replace(' ', '%', $searchTerm);
            $searchKey = $this->getArgument('key');

            $users = Shop::Get()->getUserService()->getUsersAll($this->getUser());

            $customField = new XShopCustomField();
            $customField->setKey($searchKey);
            $customField->setObjecttype(get_class($users));
            $customField->addWhere('value', '%'.$searchTerm.'%', 'LIKE');
            $customField->setGroupByQuery('objectid');

            $usersIdArray = array();
            $usersValueArray = array();
            while ($c = $customField->getNext()) {
                $usersIdArray[] = $c->getObjectid();
                $usersValueArray[$c->getObjectid()] = $c->getValue();
            }

            $users->addWhereArray($usersIdArray);
            $users->setLimitCount(10);

            while ($x = $users->getNext()) {
                $customFieldsArray = array();

                $customField = new XShopCustomField();
                $customField->setObjecttype(get_class($x));
                $customField->setObjectid($x->getId());
                while ($userCustomField = $customField->getNext()) {
                    $customFieldsArray[$userCustomField->getKey()] = $userCustomField->getValue();
                }

                $a[] = array(
                    'id' => $x->getId(),
                    'label' => $usersValueArray[$x->getId()].' ('.$x->makeName(false).')',
                    'name' => $x->makeName(false),
                    'searchField' => $usersValueArray[$x->getId()],
                    'emailArray' => $x->getEmailArray(),
                    'email' => @$x->getEmailArray()[0],
                    'phone' => @$x->getPhoneArray()[0],
                    'skype' => $x->getSkype(),
                    'whatsapp' => $x->getWhatsapp(),
                    'customFields' => $customFieldsArray
                );
            }

            $a[] = array(
                'id' => 0,
                'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_dobavit_').$searchTerm
            );


            echo json_encode($a);
            exit;
        } catch (Exception $e) {
            throw $e;
        }

    }

}