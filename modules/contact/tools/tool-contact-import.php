<?php
/**
 * Вливание базы контактов из csv-json файла.
 * Файл передается первым параметром.
 * Второй параметр "test" означает тестовый режим - парсить но не вливать.
 *
 * Пример: php -f tool-contact-import.php my.json <test>
 *
 * OneBox
 *
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$file = $argv[1];
$method = @$argv[2];

$cdate = date('Y-m-d H:i:s');

$index = 0;

$f = fopen($file, 'r');
while ($line = fgets($f, 30000)) {

    $index ++;
    print "Line={$index}\n";

    $json = json_decode(trim($line));
    $json = (array) $json;
    print_r($json);

    if (!$json['phoneArray'] && !$json['emailArray']) {
        continue;
    }
    
    $json['phoneArray'] = (array) $json['phoneArray'];
    $json['emailArray'] = (array) $json['emailArray'];
    $phoneArray = array();
    foreach ($json['phoneArray'] as $phone) {
        $phone = preg_replace("/\D/ius", '', $phone);
        if (strlen($phone) < 10) {
            continue;
        }
        $phoneArray[] = $phone;
    }

    $emailArray = array();
    foreach ($json['emailArray'] as $email) {
        $emailArray[] = $email;
    }

    if (!$emailArray && !$phoneArray) {
        continue;
    }

    $personArray = array();
    foreach ($json as $key => $value) {
        print $key.' = ';
        if ($key == 'personArray') {
            $personArray = (array) $value;
            print_r($personArray);
        } elseif (is_array($value)) {
            print implode(',', $value);
        } else {
            print $value;
        }
        print "\n";
    }
    print "\n";

    $contact = false;

    // проверка по email
    foreach ($json['emailArray'] as $email) {
        try {
            $contact = Shop::Get()->getUserService()->findUserByContact($email, 'email');

            print "Found by email {$email}\n";

            break;
        } catch (Exception $e) {

        }
    }
    // проверка по телефону
    if (!$contact) {
        foreach ($phoneArray as $phone) {
            try {
                $contact = Shop::Get()->getUserService()->findUserByContact($phone, 'phone');

                print "Found by phone {$phone}\n";

                break;
            } catch (Exception $e) {

            }
        }
    }

    if (!$contact) {
        print "Not found\n";
    } else {
        print "Found contact #".$contact->getId()."\n";
    }

    print "\n";
    print "\n";

    if ($method == 'test') {
        continue;
    }

    try {
        SQLObject::TransactionStart();

        // создаем или находим источник
        $sourceID = 0;
        try {
            $source = Shop::Get()->getShopService()->addSource($json['source']);
            $sourceID = $source->getId();
        } catch (Exception $e) {

        }

        if (!$contact) {
            // создаем контакт
            $contact = new User();
            $contact->setTypesex($json['type']);
            $contact->setCompany($json['company']);
            $contact->setPost(@$json['position']);
            $contact->setCdate($cdate);
            $contact->setUrls(implode("\n", $json['urlArray']));
            $contact->setPhone(@$phoneArray[0]);
            unset($phoneArray[0]);
            $contact->setPhones(implode("\n", $phoneArray));
            $contact->setEmail(@$emailArray[0]);
            unset($emailArray[0]);
            $contact->setEmails(implode("\n", $emailArray));
            $contact->setDistribution(1);
            $contact->setCommentadmin(@$json['comment']);
            $contact->setTags(@$json['tags']);
            $contact->setAddress(@$json['address']);
            $contact->insert();

            print "Added contact#".$contact->getId()."\n";
        }

        foreach ($personArray as $person) {
            $person = (array) $person;
            //print_r($person);
            //continue;
            $contactPerson = new User();
            $contactPerson->setTypesex('man');
            $contactPerson->setCompany($json['company']);
            $contactPerson->setName($person['namefirst']);
            $contactPerson->setNamelast($person['namelast']);
            $contactPerson->setNamemiddle($person['namemiddle']);
            $contactPerson->setPost($person['position']);
            if (!$contactPerson->select()) {
                $contactPerson->setDistribution(1);
                if (!empty($person['email'])) {
                    if (!in_array($person['email'], $emailArray)) {
                        $contactPerson->setEmail($person['email']);
                    }
                }
                $contactPerson->insert();
            }
            print "person#".$contactPerson->getId()."\n";
        }

        $image = @$json['image'];
        if ($image && !$contact->getImage()) {
            Shop::Get()->getUserService()->updateUserImage($contact, $image);
        }

        if ($sourceID && !$contact->getSourceid()) {
            $contact->setSourceid($sourceID);
        }

        // дополняем телефоны
        if ($phoneArray) {
            $tmp = $contact->getPhoneArray();
            $tmp = array_merge($tmp, $phoneArray);
            $tmp = array_unique($tmp);

            $contact->setPhone(@$tmp[0]);
            unset($tmp[0]);
            $contact->setPhones(implode("\n", $tmp));
        }

        // дополняем емейлы
        if ($emailArray) {
            $tmp = $contact->getEmailArray();
            $tmp = array_merge($tmp, $emailArray);
            $tmp = array_unique($tmp);

            $contact->setEmail(@$tmp[0]);
            unset($tmp[0]);
            $contact->setEmails(implode("\n", $tmp));
        }

        // дополняем URL
        if ($json['urlArray']) {
            $tmp = explode("\n", $contact->getUrls());
            $tmp = array_merge($tmp, $json['urlArray']);
            $tmp = array_unique($tmp);

            $contact->setUrls(implode("\n", $tmp));
        }

        if (!empty($json['comment']) && !$contact->getCommentadmin()) {
            $contact->setCommentadmin($json['comment']);
        }

        if (@$json['address'] && !$contact->getAddress()) {
            $contact->setAddress($json['address']);
        }

        if (@$json['position'] && !$contact->getPost()) {
            $contact->setPost($json['position']);
        }

        if (@$json['tags'] && !$contact->getTags()) {
            $contact->setTags($json['tags']);
        }

        $contact->update();

        SQLObject::TransactionCommit();
    } catch (Exception $ge) {
        SQLObject::TransactionRollback();
        print $ge;
    }

    print "\n";
}
fclose($f);

print "\n\ndone.\n\n";