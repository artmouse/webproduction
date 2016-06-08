<?php
/**
 * Перестроить все уведомления на основе ShopNofity
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$users = Shop::Get()->getUserService()->getUsersManagers();
while ($x = $users->getNext()) {
    print $x->makeName()."\n";
    try {
        $a = Shop::Get()->getShopService()->buildNotificationCache($x);
    } catch (Exception $e) {
        print $e;
    }
}

print "\n\ndone.\n\n";