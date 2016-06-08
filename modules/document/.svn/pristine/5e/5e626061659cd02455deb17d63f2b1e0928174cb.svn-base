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
class Document_DB implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        // шаблоны документов
        $table = SQLObject_Config::Get()->addClass('XShopDocumentTemplate', 'shopdocumenttemplate');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('key', 'varchar(255)'); // ключ
        $table->addField('name', 'varchar(255)'); // название
        $table->addField('type', 'varchar(255)'); // к чему относится
        $table->addField('groupname', 'varchar(255)'); // группа
        $table->addField('direction', "enum('in','out','our')"); // направление
        $table->addField('content', 'text');
        $table->addField('hidden', 'tinyint(1)');
        $table->addField('required', 'tinyint(1)'); // обязательный ли документ
        $table->addField('period', 'int(11)'); // срок действия документа в днях
        $table->addField('sort', 'int(11)'); // сортировка
        $table->addField('numberprocessor', 'varchar(255)'); // процессор для определения нумерации
        // indexes
        $table->addIndex(array('sort', 'name'), 'index_sort');
        $table->addIndex('groupname', 'index_groupname');

        // документ
        $table = SQLObject_Config::Get()->addClass('XShopDocument', 'shopdocument');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('number', 'varchar(255)'); // номер документа
        $table->addField('name', 'varchar(255)'); // название документа
        $table->addField('contractorid', 'int(11)');
        $table->addField('templateid', 'int(11)');
        $table->addField('userid', 'int(11)');
        $table->addField('linkkey', 'varchar(255)');
        $table->addField('cdate', 'datetime'); // дата создания документа
        $table->addField('edate', 'datetime'); // дата окончания документа
        $table->addField('sdate', 'datetime'); // дата отправки документа
        $table->addField('bdate', 'datetime'); // дата получения документа
        $table->addField('adate', 'datetime'); // дата помещения в архив
        $table->addField('fileoriginal', 'varchar(255)'); // вложенный файл-оригинал, который может заменить контент
        $table->addField('file', 'varchar(255)'); // вложенный файл (например, скан)
        $table->addField('content', 'longtext');
        $table->addField('deleted', 'tinyint(1)');
        // indexes
        $table->addIndex('contractorid', 'index_contractorid');
        $table->addIndex('templateid', 'index_templateid');
        $table->addIndex('userid', 'index_userid');
        $table->addIndex('linkkey', 'index_linkkey');

        // отдельные поля документов
        $table = SQLObject_Config::Get()->addClass('XShopDocumentFieldValue', 'shopdocumentfieldvalue');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('documentid', 'int(11)');
        $table->addField('name', 'varchar(255)'); // имя поле
        $table->addField('value', 'text'); // значение поля
        // indexes
        $table->addIndex('documentid', 'index_documentid');
        
    }

}