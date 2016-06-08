<?php
class admin_search_block_user extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();
            $query = $this->getValue('query');
            $limit = $this->getValue('limit');

            $users = Shop::Get()->getUserService()->searchUsers($query, $cuser);
            $users->addWhere('typesex', 'company', '<>');
            $users->setLimitCount($limit);

            $userArray = array();
            $userArray = $this->_addUsersToArray($users, $userArray);

            $users = Shop::Get()->getUserService()->searchUsers($query, $cuser);
            $users->setTypesex('company');
            $users->setLimitCount($limit);

            $userArray = $this->_addUsersToArray($users, $userArray);

            $this->setValue('userArray', $userArray);

            $turboSmsLogin =  Shop::Get()->getSettingsService()->getSettingValue('sms-login');
            $turboSmsPass = Shop::Get()->getSettingsService()->getSettingValue('sms-password');
            $turboSmsSender = Shop::Get()->getSettingsService()->getSettingValue('sms-sender');
            if ($turboSmsLogin && $turboSmsPass && $turboSmsSender) {
                $this->setValue('canSMS', true);
            }
        } catch (Exception $e) {

        }

    }

    /**
     * Добавить пользователя в массив
     *
     * @param User $users
     * @param array $a
     * 
     * @return array
     */
    private function _addUsersToArray(User $users, $a) {
        while ($user = $users->getNext()) {
            $logo = false;
            $companyURL = false;
            try {
                if ($user->getTypesex() == 'company') {
                    $companyObject = $user;
                } else {
                    $companyObject = Shop::Get()->getShopService()->getCompanyByName($user->getCompany());
                }

                if ($companyObject->getImage()) {
                    $logo = $companyObject->makeImageThumb(100, 100);
                }
                $companyURL = $companyObject->makeURLEdit();
            } catch (Exception $e) {
            }

            if (!$logo || $user->getImage()) {
                $logo = $user->makeImageThumb(100, 100);
            }

            $a[] = array(
            'name' => $user->makeName(true, 'lfm'),
            'url' => $user->makeURLEdit(),
            'company' => $user->getCompany(),
            'title' => $user->getPost(),
            'emailArray' => $user->getEmailArray(),
            'phoneArray' => $user->getPhoneArray(),
            'image' => $logo,
            'companyURL' => $companyURL
            );
        }

        return $a;
    }
}