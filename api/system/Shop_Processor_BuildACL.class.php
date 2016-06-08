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
 * Обработчик события, который инициирует отложенное событие buildACL
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_Processor_BuildACL {

    public function process() {
        // начинаем синхронизацию ACL
        Shop::Get()->getAclService()->syncStart();

        // перестройка ACL
        $event = Events::Get()->generateEvent('buildACL');
        $event->notify();

        Shop_AclService::Get()->syncEnd();
    }

}