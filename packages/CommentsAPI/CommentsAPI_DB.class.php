<?php
/**
 * WebProduction Packages
 *
 * @copyright (C) 2007-2016 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Sync DB for CommentsAPI
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   SMSUtils
 */
class CommentsAPI_DB implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        $table = SQLObject_Config::Get()->addClass('CommentsAPI_XComment', 'commentsapi_comment');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('id_user', 'int(11)');
        $table->addField('key', 'varchar(32)');
        $table->addField('sessionid', 'varchar(32)');
        $table->addField('ip', 'varchar(15)');
        $table->addField('content', 'text');
        // indexes
        $table->addIndex(array('key', 'cdate'), 'index_keycdate');
        $table->addIndex(array('id_user', 'cdate'), 'index_usercdate');
    }

}