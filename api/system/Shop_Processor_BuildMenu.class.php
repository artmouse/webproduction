<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Обработчик события, который инициирует отложенное событие buildMenu
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_Processor_BuildMenu {

    public function process() {

        // чистим меню из кэша для всех пользователей level >=2
        ModeService::Get()->verbose('Remove menu cache for users...');
        $users = Shop::Get()->getUserService()->getUsersAll();
        $users->addWhere('level', 2, '>=');
        while ($x = $users->getNext()) {
            try {
                ModeService::Get()->verbose('Remove menu cache for user '.$x->getLogin());
                Engine::GetCache()->removeData('contentbox-admin-menu-block-'.$x->getId());
            } catch (Exception $exCache) {
                ModeService::Get()->debug($exCache);
            }
        }
    }

}