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
 * Подгрузка контентов по требованию
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_ContentLoadObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        $path = PackageLoader::Get()->getProjectPath();

        include($path.'/contents/contents_global.php');
        include($path.'/contents/shop/api/contents_api.php');
        include($path.'/contents/shop/admin/contents_admin.php');
        include($path.'/contents/shop/admin/products/contents_products.php');
        include($path.'/contents/shop/admin/users/contents_users.php');
        include($path.'/contents/shop/admin/priceplaces/contents_priceplaces.php');
        include($path.'/contents/shop/admin/statistics/contents_statistics.php');


        // регистрируем help-контенты
        include($path.'/contents/help/contents_help.php');
    }

}