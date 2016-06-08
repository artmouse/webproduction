<?php
/**
 * Для всех пользователей проводим автоматическое форматирование номеров к правильному
 * формату, который описан в engine.mode.php
 *
 * За одно убираем дубликаты телефонов из юзеров.
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$users = Shop::Get()->getUserService()->getUsersAll();
$users->setOrder('id', 'DESC');
while ($x = $users->getNext()) {
    print "User#".$x->getId()."\n";

    $phoneArray = $x->getPhoneArray();
    $phoneArray = array_unique($phoneArray);

    $a = array();
    foreach ($phoneArray as $phone) {
        $a[] = EventService::Get()->formatCallNumber($phone);
    }

    $x->setPhone(@$a[0]);
    unset($a[0]);
    $x->setPhones(implode("\n", $a));
    $x->update();
}

print "\n\ndone.\n\n";