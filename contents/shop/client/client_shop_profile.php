<?php
class client_shop_profile extends Engine_Class {

    public function process() {
        $user = $this->getUser();

        if ($this->getControlValue('ok')) {
            $bdateYear = $this->getArgumentSecure('bdate_year');
            $bdateMonth = $this->getArgumentSecure('bdate_month');
            $bdateDay = $this->getArgumentSecure('bdate_day');
            if (!$bdateYear) {
                $bdateYear = 0000;
            }
            if (!$bdateMonth) {
                $bdateMonth = 00;
            }
            if (!$bdateDay) {
                $bdateDay = 00;
            }
            $bdate = $bdateYear.'-'.$bdateMonth.'-'.$bdateDay;

            try {
                Shop::Get()->getUserService()->updateUserProfile(
                    $user,
                    $this->getControlValue('email'),
                    $this->getControlValue('password'),
                    $this->getControlValue('name'),
                    $this->getControlValue('phone'),
                    $this->getControlValue('address'),
                    $bdate,
                    $this->getControlValue('phones'),
                    $this->getControlValue('emails'),
                    $this->getControlValue('urls'),
                    $this->getControlValue('time'),
                    '',
                    false, // check
                    false, // commentadmin
                    false, // managerid
                    false, // groupid
                    false, // login
                    false, // company
                    false, // pricelevel
                    false, // describtions
                    false, // tags
                    false, // cdate
                    $this->getControlValue('namelast'),
                    $this->getControlValue('namemiddle'),
                    false, //post
                    $this->getControlValue('typesex')
                );

                $this->setValue('message', 'ok');
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $e->getErrorsArray());
            }
        }

        $this->setValue('used_user_info', Shop::Get()->getSettingsService()->getSettingValue('used-user-info'));

        $this->setControlValue('email', $user->getEmail());
        $this->setControlValue('name', $user->getName());
        $this->setControlValue('namelast', $user->getNamelast());
        $this->setControlValue('namemiddle', $user->getNamemiddle());
        $this->setControlValue('phone', $user->getPhone());
        $this->setControlValue('address', $user->getAddress());

        $bdateArray = explode("-", $user->getBdate());

        $this->setControlValue('bdate_day', $bdateArray[2]);
        $this->setControlValue('bdate_month', $bdateArray[1]);
        $this->setControlValue('bdate_year', $bdateArray[0]);

        $this->setControlValue('phones', $user->getPhones());
        $this->setControlValue('emails', $user->getEmails());
        $this->setControlValue('urls', $user->getUrls());
        $this->setControlValue('time', $user->getTime());
        $this->setValue('parentid', $user->getParentid());
        $this->setControlValue('typesex', $user->getTypesex());
    }

}