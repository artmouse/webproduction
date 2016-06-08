<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$id = (int) @$argv[1];

if ($id) {
    try {
        $user = Shop_UserService::Get()->getUserByID($id);
        if ($user->getLogin() || $user->getPassword()) {
            print "\nLogin or password is not empty!!!\n\n";
            exit();
        }
        if (!$user->getEmployer()) {
            print "\nWarnning: You generate password User ".$user->getId()." not employer!!!\n\n";
        }

        if ($user->getName() && $user->getNamelast()) {
            $name = mb_strtolower($user->getName());
            $name = _translit($name);
            $login = $name[0];
            $nameLast = mb_strtolower($user->getNamelast());
            $login .= _translit($nameLast);
            $password = randomPassword();
            $passwordMD5 = md5(md5($password).md5('WebProduction'));
            $user->setLogin($login);
            $user->setPassword($passwordMD5);
            $user->update();
            
            if ($user->getEmail()) {
                if (Shop_SettingsService::Get()->getSettingValue('reverse-email')) {
                    $from = Shop_SettingsService::Get()->getSettingValue('reverse-email');
                } else {
                    $from = Shop_SettingsService::Get()->getSettingValue('email-tehnical');
                }
                $body = "login: ".$login."\n\n Password: ".$password;
                $letter = new MailUtils_Letter(
                    $from,
                    $user->getEmail(),
                    'Your new password in OneBox',
                    $body
                );
                $letter->send();
                print "\nSend new password to User ".$user->getId()." email ".$user->getEmail()."\n";
            } else {
                $data = "User id ".$user->getId()." Login: ".$login."  Password: ".$password."\n";
                $f = fopen('passwords.txt', 'a');
                fwrite($f, $data . PHP_EOL);
            }
        } else {
            $name = str_replace(' ', '', $user->getName());
            $login = _translit($name);
            $login = substr($login, 0, 10);
            $login = trim($login);
            $password = randomPassword();
            $passwordMD5 = md5(md5($password).md5('WebProduction'));
            $user->setLogin($login);
            $user->setPassword($passwordMD5);
            $user->update();
            
            if ($user->getEmail()) {
                if (Shop_SettingsService::Get()->getSettingValue('reverse-email')) {
                    $from = Shop_SettingsService::Get()->getSettingValue('reverse-email');
                } else {
                    $from = Shop_SettingsService::Get()->getSettingValue('email-tehnical');
                }
                $body = "login: ".$login."\n\n Password: ".$password;
                $letter = new MailUtils_Letter(
                    $from,
                    $user->getEmail(),
                    'Your new password in OneBox',
                    $body
                );
                $letter->send();
                print "\nSend new password to User ".$user->getId()." email ".$user->getEmail()."\n";
            } else {
                $data = "User id ".$user->getId()." Login: ".$login."  Password: ".$password."\n";
                $f = fopen('passwords.txt', 'a');
                fwrite($f, $data . PHP_EOL);
            }
        }
    } catch (Exception $ex) {
        print "\nId not found .\n\n";
        exit();
    }
    
    
} else {
    print "\nid empty, generate data all Employeers\n";
    $users = Shop_UserService::Get()->getUsersManagers();
    $users->addWhere('login', '', '=');
    $users->addWhere('password', '', '=');
    while ($user = $users->getNext()) {
        if ($user->getName() && $user->getNamelast()) {
            $name = mb_strtolower($user->getName());
            $name = _translit($name);
            $login = $name[0];
            $nameLast = mb_strtolower($user->getNamelast());
            $login .= _translit($nameLast);
            $password = randomPassword();
            $passwordMD5 = md5(md5($password).md5('WebProduction'));
            $user->setLogin($login);
            $user->setPassword($passwordMD5);
            $user->update();
            
            if ($user->getEmail()) {
                if (Shop_SettingsService::Get()->getSettingValue('reverse-email')) {
                    $from = Shop_SettingsService::Get()->getSettingValue('reverse-email');
                } else {
                    $from = Shop_SettingsService::Get()->getSettingValue('email-tehnical');
                }
                $body = "login: ".$login."\n\n Password: ".$password;
                $letter = new MailUtils_Letter(
                    $from,
                    $user->getEmail(),
                    'Your new password in OneBox',
                    $body
                );
                $letter->send();
                print "\nSend new password to User ".$user->getId()." email ".$user->getEmail()."\n";
            } else {
                $data = "User id ".$user->getId()." Login: ".$login."  Password: ".$password."\n";
                $f = fopen('passwords.txt', 'a');
                fwrite($f, $data . PHP_EOL);
            }
        } else {
            $name = str_replace(' ', '', $user->getName());
            $login = _translit($name);
            $login = substr($login, 0, 10);
            $login = trim($login);
            $password = randomPassword();
            $passwordMD5 = md5(md5($password).md5('WebProduction'));
            $user->setLogin($login);
            $user->setPassword($passwordMD5);
            $user->update();
            
            if ($user->getEmail()) {
                if (Shop_SettingsService::Get()->getSettingValue('reverse-email')) {
                    $from = Shop_SettingsService::Get()->getSettingValue('reverse-email');
                } else {
                    $from = Shop_SettingsService::Get()->getSettingValue('email-tehnical');
                }
                $body = "login: ".$login."\n\n Password: ".$password;
                $letter = new MailUtils_Letter(
                    $from,
                    $user->getEmail(),
                    'Your new password in OneBox',
                    $body
                );
                $letter->send();
                print "\nSend new password to User ".$user->getId()." email ".$user->getEmail()."\n";
            } else {
                $data = "User id ".$user->getId()." Login: ".$login."  Password: ".$password."\n";
                $f = fopen('passwords.txt', 'a');
                fwrite($f, $data . PHP_EOL);
            }
        }
    }
}

function _translit($str) {
    $rus = array(
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
        'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а',
        'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р',
        'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
    );
    $lat = array(
        'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
        'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya',
        'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
        'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya'
    );
    return str_replace($rus, $lat, $str);
    
}
  
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}