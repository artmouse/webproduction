<?php
class users_control extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
                $this->getArgument('id')
            );
        } catch (Exception $ex) {
            $ex->setCode(404);
            throw $ex;
        }

        if (!Shop::Get()->getUserService()->isUserViewAllowed($user, $this->getUser())) {
            $this->setValue('redirectUrl', '/admin/shop/users/');
            $this->setValue('message', 'access');
            return;
            //throw new ServiceUtils_Exception('user');
        }

        $canEdit = Shop::Get()->getUserService()->isUserChangeAllowed($user, $this->getUser());
        $this->setValue('canEdit', $canEdit);

        // комментарии
        PackageLoader::Get()->import('CommentsAPI');
        $commentKey = 'shop-user-control-'.$user->getId();

        // custom fields
        // old style @deprecated
        try {
            $customFieldArray = Engine::Get()->getConfigField('project-box-customfield-user');
        } catch (Exception $e) {
            $customFieldArray = array();
        }

        $groups = $user->getGroups();
        $groupIDArray = array(0);
        while ($x = $groups->getNext()) {
            $groupIDArray[] = $x->getId();
        }

        $contactType = 'company';
        if ($user->getTypesex() == 'man' || $user->getTypesex() == 'woman' || !$user->getTypesex()) {
            $contactType = 'person';
        }

        $contactTypeArray = array(
            '',
            'all',
            $contactType
        );

        $fields = new XShopContactField();
        $fields->addWhereArray($groupIDArray, 'groupid');
        $fields->addWhereArray($contactTypeArray, 'typecontact');
        $fields->filterType('system', '!=');
        $fields->setHidden(0);
        while ($x = $fields->getNext()) {
            $key = $x->getIdkey();
            if (!$key) {
                $key = $x->getId();
            }

            $customFieldArray[$key] = array(
                'name' => $x->getName(),
                'type' => $x->getType(),
            );
        }

        // какие поля надо скрыть?
        $fields = new XShopContactField();
        $fields->addWhereArray($groupIDArray, 'groupid');
        $fields->addWhereArray($contactTypeArray, 'typecontact');
        $fields->setHidden(1);
        $hideArray = array();
        while ($x = $fields->getNext()) {
            $hideArray[$x->getIdkey()] = 1;
        }
        $this->setValue('fieldHideArray', $hideArray);

        if ($canEdit && $this->getControlValue('ok')) {
            try {
                SQLObject::TransactionStart();

                if (Shop::Get()->getSettingsService()->getSettingValue('user-add-source-field')) {
                    if (!$this->getArgumentSecure('sourceid')) {
                        throw new ServiceUtils_Exception('nosourceid');
                    }
                }

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

                $bdate_day = trim($this->getControlValue('bdate_day'));
                $bdate_month = trim($this->getControlValue('bdate_month'));
                $bdate_year = trim($this->getControlValue('bdate_year'));

                if (!$bdate_year) {
                    $bdate_year = 1000;
                }
                $bdate = false;
                if ($bdate_month && $bdate_day && $bdate_year) {
                    $bdate = $bdate_year.'-'.$bdate_month.'-'.$bdate_day;
                }
                if ($bdate && Checker::CheckDate($bdate)) {
                    $bdate = DateTime_Object::FromString($bdate)->setFormat('Y-m-d')->__toString();
                }

                Shop::Get()->getUserService()->updateUserProfile(
                    $user,
                    $email,
                    false,
                    $this->getControlValue('name'),
                    $phone,
                    $this->getControlValue('address'),
                    $bdate,
                    $phones,
                    $emails,
                    $this->getControlValue('urls'),
                    $this->getControlValue('time'),
                    $this->getControlValue('parentid'),
                    false, // не выполнять проверки
                    $this->getControlValue('commentadmin'),
                    $this->getControlValue('managerid'),
                    $this->getArgumentSecure('group', 'array'),
                    $this->getControlValue('login'),
                    $this->getControlValue('company'),
                    $this->getControlValue('pricelevel'),
                    $this->getArgumentSecure('distribution'),
                    $this->getControlValue('tags'),
                    $this->getControlValue('cdate'),
                    $this->getControlValue('namelast'),
                    $this->getControlValue('namemiddle'),
                    $this->getControlValue('post'),
                    $this->getControlValue('typesex'),
                    $this->getControlValue('skype'),
                    $this->getControlValue('jabber'),
                    $this->getControlValue('whatsapp'),
                    $this->getArgumentSecure('employer'),
                    (int) $this->getArgumentSecure('allowreferal'),
                    $this->getControlValue('discount')
                );

                $image = $this->getControlValue('avatarimage');
                if ($image) {
                    try {
                        $image = @$image['tmp_name'];
                        Shop::Get()->getShopService()->updateUserAvatarImage($user, $image);
                    } catch (Exception $imageEx) {

                    }
                }

                if ($this->getControlValue('deleteimage')) {
                    $file = MEDIA_PATH.'/shop/'.$user->getImage();
                    @unlink($file);
                    $user->setImage('');
                }

                $user->setContractorid($this->getControlValue('contractorid'));
                $user->setSourceid($this->getControlValue('sourceid'));
                $user->setCode1c($this->getControlValue('code1c'));
                $user->update();

                // сохранение дополнительных полей
                foreach ($customFieldArray as $key => $x) {
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

                // сохранение друзей
                // друзья которые выбраны в селекте
                $clientIDArray = array();
                if ($this->getArgumentSecure('friendslist')) {
                    $clientIDArray = explode(',', $this->getArgumentSecure('friendslist'));

                    $userId = $this->getArgument('id');

                    // удаляем друзей
                    $link = new XShopUserLink();
                    $link->setUser1id($userId);
                    $link->setUser2id($userId);
                    $link->setWhereSeparator('OR');
                    while ($x = $link->getNext()) {
                        $x->delete();
                    }

                    // перезаписываем из селекта
                    foreach ($clientIDArray as $item) {
                        $link = new XShopUserLink();
                        $link->setUser1id($userId);
                        $link->setUser2id($item);
                        $link->insert();
                    }
                }

                try {
                    $userDo = $this->getUser();

                    CommentsAPI::Get()->addComment(
                        'shop-history-user-update'.$user->getId(),
                        Shop::Get()->getTranslateService()->getTranslateSecure('translate_edit_by_user').
                        ' #'.$user->getId().' '.$user->makeName(),
                        $userDo->getId()
                    );
                } catch (Exception $e) {

                }

                SQLObject::TransactionCommit();

                $this->setValue('message', 'ok');
            } catch (ServiceUtils_Exception $e) {
                SQLObject::TransactionRollback();

                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }

                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $e->getErrorsArray());
            }
        }

        Engine::GetHTMLHead()->setTitle($user->makeName());
        $this->setValue('userid', $user->getId());
        $this->setValue('login', $user->getLogin());
        $this->setControlValue('emails', implode("\n", $user->getEmailArray()));
        $this->setControlValue('phones', implode("\n", $user->getPhoneArray()));
        $this->setControlValue('name', $user->getName());
        $this->setControlValue('address', $user->getAddress());
        $this->setControlValue('distribution', $user->getDistribution());
        $this->setControlValue('employer', $user->getEmployer());
        $this->setControlValue('level', $user->getLevel());
        $this->setControlValue('allowreferal', $user->getAllowreferal());
        $this->setControlValue('tags', $user->getTags());
        $this->setControlValue('sourceid', $user->getSourceid());
        $this->setValue('srcimage', $user->getImage());
        $this->setValue('avatarimage', $user->makeImageThumb(200, 200));
        
        try {
            $companyimg = Shop::Get()->getShopService()->getCompanyByName($user->getCompany());
            if (!$user->getImage() && $companyimg->getImage()) {
                $this->setValue('avatarimage', $companyimg->makeImageThumb(200, 200));
            }
        } catch (Exception $exc) {
            
        }

        $bdate = $user->getBdate();
        if ($bdate != "0000-00-00" && date("m-d", strtotime($bdate)) == date("m-d")) {
            $this->setValue('birthday', true);
        }

        if ($bdate == "0000-00-00") {
            $bdate = '';
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
        $bdateEdit = explode('-', $bdate);

        if ($bdateEdit[0] == '1000') {
            $bdateEdit[0] = '';
        }

        if ($bdateEdit[0]) {
            $this->setControlValue('bdate_year', $bdateEdit[0]);
        }

        if (@$bdateEdit[1]) {
            $this->setControlValue('bdate_month', $bdateEdit[1]);
        }

        if (@$bdateEdit[2]) {
            $this->setControlValue('bdate_day', $bdateEdit[2]);
        }

        if (preg_match('/1000/ius', $bdate)) {
            $bdate = DateTime_Object::FromString($bdate)->setFormat('m-d')->__toString();
        }
        $this->setControlValue('bdate', $bdate);

        $cdate = $user->getCdate();
        if ($cdate == "0000-00-00") {
            $cdate = '';
        }
        if (trim($cdate) == "0000-00-00 00:00:00") {
            $cdate = date("Y-m-d H:i:s");
        }
        $this->setControlValue('cdate', $cdate);

        $this->setControlValue('urls', $user->getUrls());
        $urlsArray = explode("\n", $user->getUrls());
        $this->setValue('urlsArray', $urlsArray);

        $this->setControlValue('time', $user->getTime());
        $this->setControlValue('parentid', $parentid = $user->getParentid());

        try {
            $recomendUser = Shop::Get()->getUserService()->getUserByID($parentid);

            $this->setControlValue('parent_href', $recomendUser->makeURLEdit());
            $this->setControlValue('parentname', $recomendUser->makeName());
        }catch(Exception $e){

        }
        $this->setControlValue('commentadmin', $user->getCommentadmin());
        $this->setControlValue('managerid', $user->getManagerid());

        // группы в которых есть юзер
        $groups = $user->getGroups();
        $a = array();
        while ($x = $groups->getNext()) {
            $a[$x->getId()] = array(
                'id' => $x->getId(),
                'name' => $x->makeNamePath(),
            );
        }
        $this->setValue('contactGroupArray', $a);

        $company = $user->getCompany();

        if ($company && $user->getTypesex() != 'company') {
            $companyNameArray = explode(',', $company);
            $companyArray = array();

            foreach ($companyNameArray as $tmpCompanyName) {
                $tmpCompanyName = trim($tmpCompanyName);

                try {
                    $existCompany = Shop::Get()->getShopService()->getCompanyByName($tmpCompanyName);

                    $companyArray[] = array(
                        'name' => $existCompany->makeName(),
                        'url' => $existCompany->makeURLEdit()
                    );

                } catch (Exception $companyEx) {

                }
            }

            $this->setValue('companyArray', $companyArray);
        }

        $this->setControlValue('company', $company);

        $this->setControlValue('post', $user->getPost());
        $this->setControlValue('pricelevel', $user->getPricelevel());
        $this->setControlValue('discount', $user->getDiscountid());
        if ($user->getDiscountid()) {
            try{
                $discount = Shop::Get()->getShopService()->getDiscountByID($user->getDiscountid());
                $this->setControlValue('discountName', $discount->getName());
            } catch (Exception $ed) {

            }
        }
        $this->setControlValue('code1c', $user->getCode1c());
        $this->setControlValue('contractorid', $user->getContractorid());
        $this->setControlValue('namelast', $user->getNamelast());
        $this->setControlValue('namemiddle', $user->getNamemiddle());
        $this->setControlValue('typesex', $user->getTypesex());

        $this->setValue('real_namelast', $user->getNamelast());
        $this->setValue('real_name', $user->getName());
        $this->setValue('real_namemiddle', $user->getNamemiddle());
        $this->setValue('real_company', $user->getCompany());
        $this->setValue('real_post', str_replace(',', ', ', $user->getPost()));

        // интеграция с картами
        if ($user->getAddress()) {
            PackageLoader::Get()
            ->registerJSFile('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false');
            $this->setValue('address', $user->getAddress());
        }

        // ---
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        $a = array();
        while ($x = $managers->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
            );
        }
        $this->setValue('managerArray', $a);

        // дерево групп
        $this->setValue('groupArray', $this->_makeGroupArray($groupIDArray));

        $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
        $menu->setValue('selected', 'edit');
        $menu->setValue('userid', $user->getId());
        $this->setValue('menu', $menu->render());

        $block = Engine::GetContentDriver()->getContent('user-block-statistic');
        $block->setValue('user', $user);
        $this->setValue('block_statistic', $block->render());

        $this->setValue('emailArray', $user->getEmailArray());

        $canSmsPhonesArray = array();
        foreach ($user->getPhoneArray() as $phone) {
            $canSmsPhonesArray[$phone] = strlen($phone) >= 10 ? true : false;
        }
        $this->setValue('phoneArray', $user->getPhoneArray());
        $this->setValue('canSmsPhonesArray', $canSmsPhonesArray);

        $turboSmsLogin =  Shop::Get()->getSettingsService()->getSettingValue('sms-login');
        $turboSmsPass = Shop::Get()->getSettingsService()->getSettingValue('sms-password');
        $turboSmsSender = Shop::Get()->getSettingsService()->getSettingValue('sms-sender');
        if ($turboSmsLogin && $turboSmsPass && $turboSmsSender) {
            $this->setValue('canSMS', true);
        }

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $this->setValue('box', true);

            // voip originate
            $this->setValue('canOriginate', !!Engine::Get()->getConfigFieldSecure('asterisk-ami'));
            $this->setValue('canOriginate', true);

            if ($user->getTypesex() == 'company') {
                $block = Engine::GetContentDriver()->getContent('user-block-company');
                $block->setValue('company', $user);
                $this->setValue('block_company', $block->render());
            }

            /*$block = Engine::GetContentDriver()->getContent('user-block-charts');
            $block->setValue('user', $user);
            $this->setValue('block_charts', $block->render());*/

            if ($user->getEmployer()) {
                $block = Engine::GetContentDriver()->getContent('user-block-workflow');
                $block->setValue('user', $user);
                $this->setValue('block_workflow', $block->render());
            }

            // дополнительные поля
            try {
                $customFieldArray = Engine::Get()->getConfigField('project-box-customfield-user');
            } catch (Exception $e) {
                $customFieldArray = array();
            }

            $groups = $user->getGroups();
            $groupIDArray = array(0);
            while ($x = $groups->getNext()) {
                $groupIDArray[] = $x->getId();
            }

            $contactType = 'company';
            if ($user->getTypesex() == 'man' || $user->getTypesex() == 'woman' || !$user->getTypesex()) {
                $contactType = 'person';
            }

            $contactTypeArray = array(
                '',
                'all',
                $contactType
            );

            $fields = new XShopContactField();
            $fields->addWhereArray($groupIDArray, 'groupid');
            $fields->addWhereArray($contactTypeArray, 'typecontact');
            $fields->filterType('system', '!=');
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
                );
            }

            $a = array();
            foreach ($customFieldArray as $key => $x) {
                $tmp = new XShopCustomField();
                $tmp->setObjecttype(get_class($user));
                $tmp->setObjectid($user->getId());
                $tmp->setKey($key);
                $tmp->select();
                $value = $tmp->getValue();

                $a[$key] = array(
                    'name' => $x['name'],
                    'value' => htmlspecialchars($value),
                    'type' => $x['type'],
                );
            }
            $this->setValue('customFieldArray', $a);

            // юридические лица
            $contractors = Shop::Get()->getShopService()->getContractorsAll();
            $a = array();
            while ($x = $contractors->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                );
            }
            $this->setValue('contractorArray', $a);

            $this->setControlValue('skype', $user->getSkype());
            $skypeArray = explode("\n", $user->getSkype());
            $this->setValue('skypeArray', $skypeArray);

            $this->setControlValue('jabber', $user->getJabber());
            $jabberArray = explode("\n", $user->getJabber());
            $this->setValue('jabberArray', $jabberArray);

            $this->setControlValue('whatsapp', $user->getWhatsapp());
            $whatsappArray = explode("\n", $user->getWhatsapp());
            $this->setValue('whatsappArray', $whatsappArray);

            // источники
            $sources = Shop::Get()->getShopService()->getSourceAll();
            $this->setValue('sourceArray', $sources->toArray());

            // список родителей
            try {
                $a = array();
                $p = clone $user;

                $a[$p->getId()] = array(
                    'name' => $p->makeName(),
                    'url' => $p->makeURLEdit(),
                    'cdate' => DateTime_Formatter::DateISO8601($p->getCdate()),
                );

                while (1) {
                    try {
                        $p = Shop::Get()->getUserService()->getUserByID(
                            $p->getParentid()
                        );

                        if (isset($a[$p->getId()])) {
                            break;
                        }

                        $a[$p->getId()] = array(
                            'name' => $p->makeName(),
                            'url' => $p->makeURLEdit(),
                            'cdate' => DateTime_Formatter::DateISO8601($p->getCdate()),
                        );
                    } catch (Exception $e) {
                        break;
                    }
                }

                if (count($a) > 1) {
                    $this->setValue('parentArray', $a);
                }

            } catch (Exception $parentsEx) {

            }

            // список порекомендовавших
            $childArray = array();
            $type_sex = $user->getTypesex();
            $childsFor = Shop::Get()->getUserService()->getUsersAll($this->getUser());
            if ($type_sex === 'company') {

                $users_recomend = Shop::Get()->getUserService()->getUsersAll();
                $users_recomend->setCompany($company);

                while ($ur = $users_recomend->getNext()) {

                    $childsFor->setParentid($ur->getId());

                    while ($p = $childsFor->getNext()) {
                        $childArray[] = array(
                            'name' => $p->makeName(),
                            'url' => $p->makeURLEdit(),
                            'cdate' => DateTime_Formatter::DateISO8601($p->getCdate()),
                        );
                    }
                }
            } else {
                $childsFor->setParentid($user->getId());
                while ($p = $childsFor->getNext()) {
                    $childArray[] = array(
                        'name' => $p->makeName(),
                        'url' => $p->makeURLEdit(),
                        'cdate' => DateTime_Formatter::DateISO8601($p->getCdate()),
                        'id' => $p->getId()
                    );
                }
            }
            $this->setValue('childArray', $childArray);

            // рекомендуемое время для связи
            $tmp = new XShopUserEventRecommend();
            $tmp->setUserid($user->getId());
            $a = array();
            while ($x = $tmp->getNext()) {
                $a[$x->getDay()] = $x->getTime();
            }
            $this->setValue('recommendTimeArray', $a);

            $weekDayArray = array();
            $weekDayArray[1] = Shop::Get()
                ->getTranslateService()->getTranslateSecure('translate_monday_short');
            $weekDayArray[2] = Shop::Get()
                ->getTranslateService()->getTranslateSecure('translate_tuesday_short');
            $weekDayArray[3] = Shop::Get()
                ->getTranslateService()->getTranslateSecure('translate_wednesday_short');
            $weekDayArray[4] = Shop::Get()
                ->getTranslateService()->getTranslateSecure('translate_thursday_short');
            $weekDayArray[5] = Shop::Get()
                ->getTranslateService()->getTranslateSecure('translate_friday_short');
            $weekDayArray[6] = Shop::Get()
                ->getTranslateService()->getTranslateSecure('translate_saturday_short');
            $weekDayArray[7] = Shop::Get()
                ->getTranslateService()->getTranslateSecure('translate_sunday_short');
            $this->setValue('recommendWeekDayArray', $weekDayArray);

            $this->setValue('recommendWeekDayCurrent', date('D'));

            // комментарии по задачам


            $orders = new ShopOrder();
            $orders->addWhereQuery('(`managerid`='.$user->getId().' OR `userid`='.$user->getId().')');
            $orders->setLimitCount(10);
            $orders->setOrder('udate', 'DESC');
            $orderCommentArray = array();
            while ($x = $orders->getNext()) {
                $number = $x->getNumber(true);
                if (!$number) {
                    $number .= '#'.$x->getId();
                }

                $managerName = false;
                try{
                    $managerName = $x->getManager()->makeName(true);
                } catch (Exception $em) {

                }

                $parentName = false;
                try {
                    $parentName = $x->getParent()->makeName(true);
                } catch (Exception $ep) {

                }

                $orderCommentArray[] = array(
                    'id' => $number,
                    'name' => htmlspecialchars($x->getName()),
                    'url' => $x->makeURLEdit(),
                    'manager' => $managerName,
                    'cdate' => $x->getCdate(),
                    'parentName' => $parentName
                );
            }

            $this->setValue('orderCommentArray', $orderCommentArray);

            // отчет по задачам
            $orders = new ShopOrder();
            $orders->addWhereQuery('(`managerid`='.$user->getId().' OR `userid`='.$user->getId().')');
            $reportArray = array();
            $dateArray = array();
            $dateNameArray = array();

            $d = DateTime_Object::Now()->addYear(-1)->setFormat('Y-m');
            $dateToFormatted = DateTime_Object::Now()->setFormat('Y-m');

            while ($d->__toString() <= $dateToFormatted) {

                $dateStart = $d->__toString().'-01';
                $dateEnd = DateTime_Object::FromString($dateStart)->setFormat('Y-m-t')->__toString();

                //$dateNameArray[$d->__toString()] = $this->_nameDate($d, 'M Y');

                // запоминаем дату
                $dateArray[] = $d->__toString();

                // на заданный интервал дату считаем статистику
                $tmp = clone $orders;
                $tmp->addWhere('cdate', $dateStart, '>=');
                $tmp->addWhere('cdate', $dateEnd.' 23:59:59', '<=');
                while ($order = $tmp->getNext()) {
                    try {

                        if ($order->getType() == 'project') {
                            @$reportArray[$d->__toString()]['countProject'] ++;
                        } elseif ($order->getType() == 'issue') {
                            @$reportArray[$d->__toString()]['countIssue'] ++;
                        } else {
                            @$reportArray[$d->__toString()]['countOrder'] ++;
                        }

                    } catch (Exception $e) {

                    }
                }
                $d->addMonth(+1);
            }

            $this->setValue('reportArray', $reportArray);
            $this->setValue('dateArray', $dateArray);

            // -------

            // предсказанные события
            $tmp = new XShopUserEventPrediction();
            $tmp->setUserid($user->getId());
            $tmp->addWhere('pdate', date('Y-m-d'), '>=');
            $tmp->setOrder('pdate', 'ASC');
            $a = array();
            while ($x = $tmp->getNext()) {
                $a[] = array(
                    'comment' => $x->getComment(),
                    'pdate' => DateTime_Object::
                    FromString($x->getPdate())->setFormat('d.m.Y H:i')->__toString(),
                    'probablity' => round($x->getProbablity(), 2),
                    'isToday' => date('Y-m-d') == DateTime_Formatter::DateISO9075($x->getPdate()),
                );
            }
            $this->setValue('predictionArray', $a);

            // список проблем notify
            $notify = Engine::GetContentDriver()->getContent('notify-block');
            $notify->setValue('key', 'contact-'.$user->getId());
            $this->setValue('block_notify', $notify->render());

            // Список бизнес-процессов
            $category = Shop::Get()->getShopService()->getWorkflowsActive($this->getUser());
            $a = array();

            $dynamicWorkflow = false;
            if (Shop_ModuleLoader::Get()->isModuleInModulesArray('box')
                && !Engine::Get()->getConfigFieldSecure('static-shop-menu')
            ) {
                $dynamicWorkflow = true;
            }

            while ($x = $category->getNext()) {
                $p = array();
                $p['workflowid'] = $x->getId();
                $p['clientid'] = $user->getId();
                $p['clientname'] = urlencode($user->makeName());

                $typeWorkflow = $x->getType();
                if (!$typeWorkflow) {
                    $typeWorkflow = 'order';
                }

                if ($dynamicWorkflow) {
                    $url = '/admin/customorder/'.$typeWorkflow.'/add/';

                    if ($x->getType()) {
                        try{
                            $typeObj = new XShopWorkflowType();
                            $typeObj->setType($x->getType());
                            $typeObj = $typeObj->getNext();
                            if ($typeObj && $typeObj->getContentId()) {
                                $content = Engine_ContentDriver::Get()->getContent(
                                    $typeObj->getContentId()
                                )->getContentData();
                                if ($content['url']) {
                                    $url = $content['url'];
                                }
                            }
                        } catch (Exception $econten) {

                        }
                    }

                } else {
                    $url = '/admin/'.$typeWorkflow.'/add/';
                }

                $url .= '?';

                foreach ($p as $foreachKey => $foreachValue) {
                    if (!$foreachKey || !$foreachValue) {
                        continue;
                    }
                    $url.=$foreachKey.'='.$foreachValue.'&';
                }


                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'url' => $url,
                );
            }
            $this->setValue('workflowArray', $a);
        }

        // выводим всех друзей данного контакта
        $friendsArray = Shop::Get()->getUserService()->getFriends($this->getArgument('id'));
        $friendsArrayReturn = array();
        foreach ($friendsArray as $x) {
            try {
                $user = Shop::Get()->getUserService()->getUserByID($x);
                $friendsArrayReturn[] = array(
                    'id' => $user->getId(),
                    'name' => $user->makeName(true, 'lfm'),
                    'url' => $user->makeURLEdit(),
                );
            } catch (Exception $e) {
                $friendsArrayReturn[] = array(
                    'id' => $x,
                    'name' => $x
                );
            }
        }

        $this->setValue('friendsArray', $friendsArrayReturn);

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

        // блок информации о копмпаниях

        if (Shop::Get()->getSettingsService()->getSettingValue('company-info-in-user-card')) {
            $company = $user->getCompany();

            if ($company && $user->getTypesex() != 'company') {
                $companyNameArray = explode(',', $company);
                $companyArray = array();

                foreach ($companyNameArray as $tmpCompanyName) {
                    $tmpCompanyName = trim($tmpCompanyName);

                    try {
                        $existCompany = Shop::Get()->getShopService()->getCompanyByName($tmpCompanyName);

                        $jabberArray = explode("\n", $existCompany->getJabber());
                        foreach ($jabberArray as $jabberKey => $jabber) {
                            if (!trim($jabber)) {
                                unset($jabberArray[$jabberKey]);
                            }
                        }

                        $whatsAppArray = $existCompany->getWhatsappArray();
                        foreach ($whatsAppArray as $whatsappKey => $whatsapp) {
                            if (!trim($whatsapp)) {
                                unset($whatsAppArray[$whatsappKey]);
                            }
                        }

                        $skypeArray = $existCompany->getSkypeArray();
                        foreach ($skypeArray as $skypeKey => $skype) {
                            if (!trim($skype)) {
                                unset($skypeArray[$skypeKey]);
                            }
                        }

                        $emailArray = $existCompany->getEmailArray();
                        foreach ($emailArray as $emailKey => $email) {
                            if (!trim($email)) {
                                unset($emailArray[$emailKey]);
                            }
                        }

                        $phoneArray = $existCompany->getPhoneArray();
                        foreach ($phoneArray as $phoneKey => $phone) {
                            if (!trim($phone)) {
                                unset($phoneArray[$phoneKey]);
                            }
                        }

                        $companyArray[] = array(
                            'name' => $existCompany->makeName(),
                            'url' => $existCompany->makeURLEdit(),
                            'address' => $existCompany->getAddress(),
                            'whatsappArray' => $whatsAppArray,
                            'jabberArray' => $jabberArray,
                            'skypeArray' => $skypeArray,
                            'emailArray' => $emailArray,
                            'phoneArray' => $phoneArray
                        );

                    } catch (Exception $companyEx) {

                    }
                }
                $this->setValue('companyDataArray', $companyArray);
            }

        }

    }

    /**
     * Построить дерево групп.
     * $groupIDArray - это массив в котором уже есть юзер.
     *
     * @param array $groupIDArray
     *
     * @return array
     */
    private function _makeGroupArray($groupIDArray) {
        $group = Shop::Get()->getUserService()->makeUserGroupTree();
        $a = array();
        foreach ($group as $x) {
            if ($x->getLogicclass() && !in_array($x->getId(), $groupIDArray)) {
                continue;
            }

            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('groupid' => $x->getId())),
            'parentid' => $x->getParentid(),
            'count' => $x->getCnt(),
            'level' => $x->getField('level'),
            );
        }
        return $a;
    }

}