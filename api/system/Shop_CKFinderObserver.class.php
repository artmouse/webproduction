<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Egor Gerasimchuk <milhous@webproduction.ua>
 * @copyright WebProduction
 * @package Boat
 */
class Shop_CKFinderObserver  implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        // пропускаем все кроме админки
        if (!substr_count(Engine::GetURLParser()->getCurrentURL(), '/admin/') ) {
            return;
        }

        try {
            $user = Shop::Get()->getUserService()->getUser();
            // даем юзеру доступ к CKFinder
            if (PackageLoader::Get()->isImported('CKFinder') && $user->isAdmin()) {
                CKFinder_Configuration::Get()->setAuthorized(true);
            }
        } catch (ServiceUtils_Exception $e) {
            return;
        }
    }
}
