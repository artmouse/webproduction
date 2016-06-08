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
class Box_DB implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        $table = SQLObject_Config::Get()->addClass('XShopReport', 'shopreport');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('row', 'varchar(255)');
        $table->addField('columns', 'text');
        // indexes
        $table->addIndex('name', 'index_name');

        $table = SQLObject_Config::Get()->addClass('XShopOrderStatusSubWorkflow', 'shoporderstatussubworkflow');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('statusid', 'int(11)');
        $table->addField('sort', 'int(11)');
        $table->addField('subworkflowid', 'int(11)');
        $table->addField('subworkflowname', 'varchar(255)');
        $table->addField('subworkflowdate', 'int(3)');
        $table->addField('subworkflowdescription', 'text');
        // indexes
        $table->addIndex('statusid', 'index_statusid');

        // KPI
        $table = SQLObject_Config::Get()->addClass('XShopKPI', 'shopkpi');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('logicclass', 'varchar(255)');
        $table->addField('logicclassparam', 'varchar(255)');
        // indexes
        $table->addIndex('name', 'index_name');

        // Статистика KPI
        $table = SQLObject_Config::Get()->addClass('XShopKPIUser', 'shopkpiuser');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('kpiid', 'int(11)');
        $table->addField('userid', 'int(11)');
        $table->addField('cdate', 'datetime');
        $table->addField('value', 'float'); // фактическое значение на этот момент
        $table->addField('valueplan', 'float'); // плановое значение на этот момент
        // indexes
        $table->addIndex(array('userid', 'kpiid', 'cdate'), 'index_userkpi');
        $table->addIndex('kpiid', 'index_kpi');

        // Робочий график
        $table = SQLObject_Config::Get()->addClass('XShopUserWorkTime', 'shopuserworktime');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)');
        $table->addIndex('userid');
        $table->addField('cdate', 'datetime');
        // indexes
        $table->addIndexUnique(array('userid', 'cdate'), 'index_usercdate');

        // welcometext
        $table = SQLObject_Config::Get()->addClass('XWelcomeText', 'welcometext');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)');
        $table->addField('content', 'text');
        // indexes
        $table->addIndex('userid');

            // forms settings
        $table = SQLObject_Config::Get()->addClass('XShopFormsSettings', 'shopformssettings');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('description', 'varchar(255)');

        // индексы
        $table->addIndex('name', 'index_name'); // индекс для сортировки

        // forms settings
        $table = SQLObject_Config::Get()->addClass('XShopFormsSettingsItem', 'shopformssettingsitem');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('formid', "int(11)");
        $table->addField('name', 'varchar(255)');
        $table->addField('description', 'varchar(255)');
        $table->addField('type', "enum('checkbox','string','text')");
        $table->addField('required', 'tinyint(1)');
        $table->addField('sort', 'int(11)'); // сортировка
        // индексы
        $table->addIndex('formid', 'index_formid'); // индекс для formid
        $table->addIndex('name', 'index_name'); // индекс для name

        // forms settings value
        $table = SQLObject_Config::Get()->addClass('XShopFormsSettingsValue', 'shopformssettingsvalue');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('formid', "int(11)");
        $table->addField('projectid', "int(11)");
        $table->addField('userid', "int(11)");
        $table->addField('fieldid', 'int(11)');
        $table->addField('value', 'text');
        $table->addField('cdate', "datetime");

        // индексы
        $table->addIndex(array('projectid', 'formid'), 'index_project');
        $table->addIndex('fieldid', 'index_formid'); // индекс для fieldid

        // затраченое время
        $table = SQLObject_Config::Get()->addClass('XShopTimeLog', 'shoptimelog');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('orderid', 'int(11)');
        $table->addField('userid', 'int(11)');
        $table->addField('cdate', 'datetime');
        $table->addField('time', 'int(11)');
        // index
        $table->addIndex('orderid', 'index_orderid');
        $table->addIndex('userid', 'index_userid');

        // call forwarding/routing
        $table = SQLObject_Config::Get()->addClass('XCallRouting', 'callrouting');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('from', 'varchar(255)');
        $table->addField('to', 'varchar(255)');
        $table->addField('name', 'varchar(255)');
        $table->addField('comment', 'text');
        // индексы
        $table->addIndex(array('from'), 'index_from');

        // Стандарты
        $table = SQLObject_Config::Get()->addClass('XShopStandard', 'shopstandard');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('cdate', "datetime");
        $table->addField('content', "longtext");
        $table->addField('parentid', "int(11)");
        $table->addField('mdate', "datetime");
        $table->addField('cauthorid', "int(11)");
        $table->addField('mauthorid', "int(11)");
        $table->addField('active', "enum('1','0')");
        // indexes
        $table->addIndex('name', 'index_name');

        // История изменений стандартов
        $table = SQLObject_Config::Get()->addClass('XShopStandardLog', 'shopstandardlog');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('standardid', "int(11)");
        $table->addField('cdate', "datetime");
        $table->addField('userid', "int(11)");
        $table->addField('name', 'varchar(255)');
        $table->addField('content', "longtext");
        // indexes
        $table->addIndex('name', 'index_name');
    }

}