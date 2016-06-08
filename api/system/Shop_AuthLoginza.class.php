<?php

class Shop_AuthLoginza implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $query = Engine::Get()->getRequest();

        $arguments = Engine::GetURLParser()->getArguments();

        if (!empty($arguments['token'])) {
            try {
                $token = $arguments['token'];

                $loginzaID = Shop::Get()->getSettingsService()->getSettingValue('loginza-widgetid');
                $loginzaSecretKey = Shop::Get()->getSettingsService()->getSettingValue('loginza-secretkey');

                $signature = md5($token.$loginzaSecretKey);
                $json = @file_get_contents('http://loginza.ru/api/authinfo?token='.$token.'&id='.$loginzaID.'&sig='.$signature);
                $json = json_decode($json);

                if (!isset($json->identity)) {
                    throw new Exception('', 0);
                }

                $email = false;
                if (!empty($json->email)) {
                    $email = $json->email.'';
                }

                // построение логина
                $login = md5($json->identity.'');
                if (!empty($json->identity->nickname)) {
                    $login = $json->identity->nickname.'';
                } elseif (!empty($json->identity->email)) {
                    $login = $json->identity->email.'';
                    $login = preg_replace("/[^0-9a-z]/ius", '', $login);
                } elseif (!empty($json->identity->uid)) {
                    $login = $json->identity->uid.'';
                }

                $nameFirst = false;
                $nameLast = false;
                $nameMiddle = false;

                if (!empty($json->name->first_name)) {
                    $nameFirst = $json->name->first_name.'';
                }
                if (!empty($json->name->last_name)) {
                    $nameLast = $json->name->last_name.'';
                }
                if (!empty($json->name->middle_name)) {
                    $nameMiddle = $json->name->middle_name.'';
                }

                // проверяем, есть ли такой юзер по емейлу
                if ($email) {
                    $user = new XUser();
                    $user->setEmail($email);
                    if ($user->select()) {
                        // входим и пофиг на loginza
                        Shop::Get()->getUserService()->login(
                        $email,
                        $user->getPassword(),
                        true, // cookie
                        true // password already crypted
                        );

                        return;
                    }
                }

                // так как емейла нет
                // то емейл будет вида login@provider
                $email = $login.'@'.Engine::Get()->getProjectHost();

                // проверяем, есть ли такой юзер по логину
                $user = new XUser();
                $user->setLogin($login);
                if (!$user->select()) {
                    // регистрируем такого юзера
                    $user = Shop::Get()->getUserService()->addUser(
                    $login, // login
                    md5($login.rand()), // password
                    $email, // email
                    trim($nameFirst.' '.$nameMiddle.' '.$nameLast), // name
                    '', // phone
                    false, // address
                    false, // bdate
                    false, // parentid
                    1 // active
                    );
                }

                // входим
                Shop::Get()->getUserService()->login(
                $login,
                $user->getPassword(),
                true, // cookie
                true // password already encrypted
                );

                return;
            } catch (Exception $e) {
                $query->setContentID(401);
                return false;
            }
        }
    }

}