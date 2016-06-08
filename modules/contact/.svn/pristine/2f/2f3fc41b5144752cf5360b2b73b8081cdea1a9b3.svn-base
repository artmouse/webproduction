<?php
class users_sms_mailing extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jQueryFilter.js');
        PackageLoader::Get()->import('CKFinder');
        CKFinder_Configuration::Get()->setAuthorized(true);

        // отправляем письма
        if ($this->getControlValue('ok')) {
            $usersArray = false;
            $cnt = 0;

            if ($this->getArgumentSecure('arrUserId')) {
                $usersArray = explode(';', $this->getArgumentSecure('arrUserId'));

            } else {
                //если post запроса нету берем всех
                if (!$usersArray) {
                    $AllUsers = Shop::Get()->getUserService()->getUsersAll();
                    $AllUsers->addWhere('phone', '', '<>');
                    while ($x = $AllUsers->getNext()) {
                        $usersArray[] = $x->getId();
                    }

                }

            }

            $text = $this->getControlValue('text');

            $sendsArray = false;
            foreach ($usersArray as $userID) {
                if (!$userID) {
                    continue;
                }
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($userID);
                    if (!$user->getDistribution() || !$user->getPhone()) {
                        continue;
                    }
                    $sendsArray[$userID] = array(
                        'id' => $userID,
                        'url' => $user->makeURLEdit(),
                        'phone' => $user->getPhone()
                    );

                    $text2 = $text;
                    $text2 = str_replace('[name]', $user->getName(), $text2);
                    $text2 = str_replace('[phone]', $user->getPhone(), $text2);

                    if (!$user->getDistribution()) {
                        throw new Exception();
                    }

                    Shop::Get()->getUserService()->sendSMS(
                        $user->getPhone(),
                        $text2,
                        $this->getUser()
                    );

                    $sendsArray[$userID]['send'] = 1;
                    $cnt ++;
                } catch (Exception $e) {
                    $sendsArray[$userID]['send'] = 0;
                }
            }

            if ($cnt) {
                $this->setValue('message', 'ok');
                $this->setValue('sendsArray', $sendsArray);
                $this->setValue('cnt', $cnt);
            } else {
                $this->setValue('message', 'error');
            }

        }


        try{
            $login = Shop::Get()->getSettingsService()->getSettingValue('sms-login');
            $pass = Shop::Get()->getSettingsService()->getSettingValue('sms-password');
            $sender = Shop::Get()->getSettingsService()->getSettingValue('sms-sender');

            // Подключаемся к серверу
            $client = new SoapClient('http://turbosms.in.ua/api/wsdl.html');

            // Данные авторизации
            $auth = array(
                'login' => $login,
                'password' => $pass
            );

            // Авторизируемся на сервере
            $result = $client->Auth($auth);

            // Получаем количество доступных кредитов
            $result = $client->GetCreditBalance();
            $balance = $result->GetCreditBalanceResult;
            if (is_numeric($balance)) {
                $this->setValue('balance', $balance);
            } else {
                $this->setValue('errorAuth', true);
            }

        } catch (Exception $e) {

        }

        if ($sender && $login && $pass) {
            $table = new Shop_ContentTable(new Datasource_SMSLog());
            $this->setValue('table', $table->render());
        } else {
            $this->setValue('false', true);
        }

        if ($this->getArgumentSecure('arrUserId')) {
            $userIdArray = explode(';', $this->getArgumentSecure('arrUserId'));
            $count = 0;
            $disCount = 0;
            foreach ($userIdArray as $us) {
                try{
                    $user = Shop::Get()->getUserService()->getUserByID($us);
                    $phone = preg_replace("/[^0-9]/ius", '', $user->getPhone());
                    if (strlen($phone) >= 10) {
                        $count++;
                        if ($user->getDistribution()) {
                            $disCount++;
                        }
                    }
                } catch (Exception $e) {

                }
            }
            $this->setValue('userCount', $count);
            $this->setValue('disCount', $disCount);
            $this->setValue('arrUserId', $this->getArgumentSecure('arrUserId'));

        } else {
            // если нету post
            if (!$usersArray) {
                $AllUsers = Shop::Get()->getUserService()->getUsersAll();
                $AllUsers->addWhere('phone', '', '<>');
                $count = 0;
                $disCount = 0;
                while ($x = $AllUsers->getNext()) {
                    $phone = preg_replace("/[^0-9]/ius", '', $x->getPhone());
                    if (strlen($phone) >= 10) {
                        $count++;
                        if ($x->getDistribution()) {
                            $disCount++;
                        }
                    }
                }
                $this->setValue('userCount', $count);
                $this->setValue('disCount', $disCount);

            }

        }

    }

}