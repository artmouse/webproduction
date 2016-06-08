<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Класс, который проверяет есть ли доступ к заданному контенту у текущего юзера.
 * Использует старую систему авторизации, которая скоро будет полностью отрефакторена.
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * 
 * @copyright WebProduction
 * 
 * @package Shop
 */
class Shop_ACLObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        Shop::Get()->getAclService()->checkACLObserver($event);
    }

}