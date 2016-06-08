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
 * событие для перестройки базы данных (SQLObject Sync)
 *
 * @author    i.ustimenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class ProductFavorite_DB implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        $table = SQLObject_Config::Get()->addClass('XShopUserProductsFavorite', 'shop_user_products_favorite');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('productid', 'int(11)');
        $table->addField('userid', 'int(11)');
        // индексы
        $table->addIndex('userid', 'index_userid');
        $table->addIndex('productid', 'index_productid');

    }

}