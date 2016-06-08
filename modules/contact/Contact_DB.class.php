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
class Contact_DB implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        // настраиваемые поля для конатктов
        $table = SQLObject_Config::Get()->addClass('XShopContactField', 'shopuserfield');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addField('groupid', 'int(11)');
        $table->addField('idkey', 'varchar(255)');
        $table->addField('name', 'varchar(64)');
        $table->addField('type', 'varchar(32)');
        $table->addField('hidden', 'tinyint(1)');
        $table->addField('filterable', 'tinyint(1)');
        $table->addField('showinpreview', 'tinyint(1)');
        $table->addField('showinorder', 'tinyint(1)');
        $table->addField('typecontact', 'varchar(32)');
        $table->addIndexPrimary('id');
        // indexes
        $table->addIndexUnique(array('idkey', 'groupid'), 'index_idkeygroupid');
        $table->addIndexUnique(array('groupid', 'name'), 'index_namegroupid');
        
    }

}