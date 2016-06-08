<?php
class users_add extends Engine_Class {

    public function process() {

        if ($this->getArgumentSecure('id')) {

            Engine::Get()->getRequest()->setContentNotFound();
            return;
        }
        try {

            if ($this->getControlValue('ok') || $this->getControlValue('okClear')) {
                try {
                    SQLObject::TransactionStart();

                    $name =  trim($this->getControlValue('name'));
                    $namelast = trim($this->getControlValue('namelast'));
                    $company =  trim($this->getControlValue('company'));

                    $phones = trim($this->getControlValue('phones'));
                    $phones = str_replace(",", "\n", $phones);
                    $phoneArray = explode("\n", $phones);
                    $a = array();
                    foreach ($phoneArray as $key => $p) {
                        $p = trim($p);
                        if (strlen($p) >= 10) {
                            $p = substr($p, -10);
                        }
                        if (!in_array($p, $a)) {
                            $a[$key] = trim($p);
                        } else {
                            unset($phoneArray[$key]);
                        }
                    }
                    $phone = trim($phoneArray[0]);
                    unset($phoneArray[0]);
                    $phones = implode("\n", $phoneArray);

                    $emails = trim($this->getControlValue('emails'));
                    $emails = str_replace(",", "\n", $emails);
                    $emailArray = explode("\n", $emails);
                    $email = trim($emailArray[0]);
                    unset($emailArray[0]);
                    $emails = implode("\n", $emailArray);

                    $skype =  trim($this->getControlValue('skype'));
                    $jabber =  trim($this->getControlValue('jabber'));
                    $whatsapp = trim($this->getControlValue('whatsapp'));
                    $typesex = trim($this->getControlValue('typesex'));

                    $bdate = false;
                    $bdate_day = trim($this->getControlValue('bdate_day'));
                    $bdate_month = trim($this->getControlValue('bdate_month'));
                    $bdate_year = trim($this->getControlValue('bdate_year'));

                    if (!$bdate_year) {
                        $bdate_year = 1000;
                    }
                    if ($bdate_month && $bdate_day && $bdate_year) {
                        $bdate = $bdate_year.'-'.$bdate_month.'-'.$bdate_day;
                    }

                    if ($bdate && Checker::CheckDate($bdate)) {
                        $bdate = DateTime_Object::FromString($bdate)->setFormat('Y-m-d')->__toString();
                    }

                    $isCompany = ($typesex == 'company');

                    $ex = new ServiceUtils_Exception();

                    if (empty($name) && empty($company) && empty($namelast)) {
                        $ex->addError('noname');
                    }

                    $url = trim($this->getControlValue('urls'));
                    if (!empty($url)) {

                        if (!preg_match_all('/\./ius', trim($this->getControlValue('urls')), $r)) {

                            $ex->addError('nosite');

                        }

                    }

                    if (empty($phone) && empty($email) &&
                        empty($skype) && empty($jabber) &&
                        empty($whatsapp) && !$isCompany) {
                        $ex->addError('nocontact');
                    }
                    if (Shop::Get()->getSettingsService()->getSettingValue('user-add-source-field')) {
                        if (!$this->getArgumentSecure('sourceid')) {
                            $ex->addError('nosourceid');
                        }
                    }
                    if ($ex->getCount()) {
                        throw $ex;
                    }

                    $user = Shop::Get()->getUserService()->addUserClient(
                        $name,
                        $namelast,
                        trim($this->getControlValue('namemiddle')),
                        $typesex,
                        trim($this->getControlValue('company')),
                        trim($this->getControlValue('post')),
                        $email,
                        $phone,
                        trim($this->getControlValue('address')),
                        trim($this->getControlValue('commentadmin'))
                    );



                    // дописываем остальные не добавленные поля.
                    Shop::Get()->getUserService()->updateUserProfile(
                        $user,
                        $email,
                        false,
                        trim($this->getControlValue('name')),
                        $phone,
                        trim($this->getControlValue('address')),
                        $bdate,
                        $phones,
                        $emails,
                        trim($this->getControlValue('urls')),
                        trim($this->getControlValue('time')),
                        trim($this->getControlValue('parentid')),
                        false, // не выполнять проверки
                        $this->getControlValue('commentadmin'),
                        $this->getControlValue('managerid'),
                        $this->getArgumentSecure('group', 'array'),
                        $this->getControlValue('login'),
                        $company,
                        $this->getControlValue('pricelevel'),
                        $this->getArgumentSecure('distribution'),
                        $this->getControlValue('tags'),
                        date("y-m-d H:i:s"),
                        $this->getControlValue('namelast'),
                        $this->getControlValue('namemiddle'),
                        $this->getControlValue('post'),
                        $this->getControlValue('typesex'),
                        $skype,
                        $jabber,
                        $whatsapp,
                        $this->getArgumentSecure('employer'),
                        $this->getArgumentSecure('allowreferal'),
                        $this->getArgumentSecure('discount'),
                        $this->getArgumentSecure('sourceid'),
                        $this->getArgumentSecure('contractorid'),
                        $this->getArgumentSecure('code1c')
                    );

                    $image = $this->getControlValue('avatarimage');
                    $image = @$image['tmp_name'];

                    if ($image) {
                        Shop::Get()->getShopService()->updateUserAvatarImage($user, $image);
                        $user->update();
                    }

                    // доп поля
                    $fields = new XShopContactField();
                    $fields->addWhereArray(array(0), 'groupid');
                    $fields->setHidden(0);
                    while ($x = $fields->getNext()) {
                        $key = $x->getIdkey();
                        if (!$key) {
                            $key = $x->getId();
                        }

                        $value = $this->getArgumentSecure('custom_'.$key);

                        $tmp = new XShopCustomField();
                        $tmp->setObjecttype(get_class($user));
                        $tmp->setObjectid($user->getId());
                        $tmp->setKey($key);
                        if ($tmp->select()) {
                            $tmp->setValue($value);
                            $tmp->update();
                        } else {
                            $tmp->setValue($value);
                            $tmp->insert();
                        }
                    }

                    $callComment = $this->getArgumentSecure('callcomment');
                    $callFrom = $this->getArgumentSecure('callfrom');
                    $callTo = $this->getArgumentSecure('callto');
                    $callDate = $this->getArgumentSecure('calldate');

                    if ($callComment && $callFrom && $callTo && $callDate) {
                        EventService::Get()->addCallComment(
                            $callFrom,
                            $callTo,
                            $callDate,
                            $callComment,
                            $this->getControlValue('projectid'),
                            $this->getControlValue('workflowid')
                        );
                    }

                    SQLObject::TransactionCommit();

                    $this->setValue('message', 'ok');

                    if ($this->getControlValue('ok')) {
                        $this->setValue('urlredirect', $user->makeURLEdit());
                    }

                } catch (ServiceUtils_Exception $addEx) {
                    SQLObject::TransactionRollback();

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $addEx;
                    }

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $addEx->getErrorsArray());
                }

            }

            $arrayDay = array();
            for ($i = 1; $i <= 31; $i++) {
                $arrayDay[] = $i;
            }
            $this->setValue('arrayDay', $arrayDay);

            $arrayMonth = array();
            for ($i = 1; $i <= 12; $i++) {
                $date = DateTime_Formatter::DatePhoneticMonthRus(DateTime_Object::Now()->setFormat('Y-'.$i));
                $date = explode(' ', $date);
                $arrayMonth[] = array (
                    'num' => $i,
                    'name' => $date[1]
                );
            }

            $this->setValue('arrayMonth', $arrayMonth);

            $managers = Shop::Get()->getUserService()->getUsersManagers();
            $a = array();
            while ($x = $managers->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                );
            }
            $this->setValue('managerArray', $a);
            // устанавливаем менеджером текущего пользователя
            $this->setControlValue('managerid', Shop::Get()->getUserService()->getUser()->getId());

            if (Engine::Get()->getConfigFieldSecure('project-box')) {
                $this->setValue('box', true);
                // юридические лица                
                $contractors = Shop::Get()->getShopService()->getContractorsActive();
                $this->setValue('contractorArray', $contractors->toArray());
                try {
                    $contractorid = Shop::Get()->getShopService()->getContractorDefault();
                    $this->setControlValue('contractorid', $contractorid->getId());
                } catch (Exception $exc) {
                    
                }
                // источники
                $sources = Shop::Get()->getShopService()->getSourceAll();
                $this->setValue('sourceArray', $sources->toArray());
            }

            // скидки
            $discountArray = array();
            $discount = Shop::Get()->getShopService()->getDiscountAll();
            while ($x = $discount->getNext()) {
                $discountArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName()
                );
            }
            $this->setValue('discountArray', $discountArray);

            // дерево групп
            $this->setValue('groupArray', $this->_makeGroupArray());

            // доп поля
            $customFieldArray = array();
            $fields = new XShopContactField();
            $fields->addWhereArray(array(0), 'groupid');
            $fields->setHidden(0);
            $fields->setOrder('type', 'DESC');
            while ($x = $fields->getNext()) {
                $key = $x->getIdkey();
                if (!$key) {
                    $key = $x->getId();
                }

                $customFieldArray[$key] = array(
                    'name' => $x->getName(),
                    'type' => $x->getType(),
                    'value' => $this->getArgumentSecure('custom_'.$key),
                );
            }
            $this->setValue('customFieldArray', $customFieldArray);
        } catch (Exception $ge) {
            LogService::Get()->add($ge);
            Engine::Get()->getRequest()->setContentServerError();
            return;
        }

    }

    /**
     * Получить массив груп
     *
     * @return array
     */
    private function _makeGroupArray() {
        $group = Shop::Get()->getUserService()->makeUserGroupTree();
        $a = array();
        foreach ($group as $x) {
            // пропускаем группы с логикой
            if ($x->getLogicclass()) {
                continue;
            }

            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'selected' => $x->getId() == $this->getArgumentSecure('groupid'),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('groupid' => $x->getId())),
                'parentid' => $x->getParentid(),
                'count' => $x->getCnt(),
                'level' => $x->getField('level'),
            );
        }
        return $a;
    }

}