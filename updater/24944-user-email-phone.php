<?php
$users = Shop::Get()->getUserService()->getUsersAll();
$users->setOrder('id', 'DESC');
while ($x = $users->getNext()) {
    print $x->getId()."\n";

    try {
        Shop::Get()->getUserService()->buildUserEmails($x);
    } catch (Exception $e) {
        print $e;
    }

    try {
        Shop::Get()->getUserService()->buildUserPhones($x);
    } catch (Exception $e) {
        print $e;
    }
}