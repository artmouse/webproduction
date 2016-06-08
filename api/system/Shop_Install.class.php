<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Система инсталяции
 *
 * @author Oleksii Golub <avator@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_Install implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $src = PackageLoader::Get()->getProjectPath().'/engine.mode.php';

        if (!file_exists($src)) {
            $query = Engine::Get()->getRequest();
            if ($query->getContentID() != 'install') {
                header('Location: /install/');
                exit();
            }
        }
    }

}