<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Загрузить предыдущие фильтра из сессии
 *
 * @copyright WebProduction
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 */
class Shop_FiltersObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        // проверяем есть ли фильтры в аргументах
        $filtersExists = false;

        $filtersArray = Engine::GetURLParser()->getArguments();
        if (isset($filtersArray['filterid'])) {
            $filtersExists = true;
        } else {
            foreach ($filtersArray as $k => $v) {
                if (preg_match('/^filter(\d+)_/uis', $k)) {
                    $filtersExists = true;
                    break;
                }
            }
        }

        // иначе пытаемся загрузить фильтры из сессии
        $filtersArray = @$_SESSION['filters'.Engine::Get()->getRequest()->getContentID()];
        if (!$filtersExists && $filtersArray) {
            $filtersArray = unserialize($filtersArray);
            foreach ($filtersArray as $k => $v) {
                Engine::GetURLParser()->setArgument($k, $v);
            }
        }
    }

}