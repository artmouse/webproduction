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
class ProductMargin_DB implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        // правила для автоматических наценок
        $table = SQLObject_Config::Get()->addClass('XShopMarginRule', 'shopmarginrule');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('pricefrom', 'decimal(15,2)');
        $table->addField('priceto', 'decimal(15,2)');
        $table->addField('value', 'decimal(15,2)');
        $table->addField('type', "enum('percent','sum')");
        $table->addField('currencyid', 'int(11)');
        $table->addField('supplierid', 'int(11)');
        $table->addField('priority', 'int(3)'); // 0-99
        $table->addField('brandid', 'int(11)');
        // indexes
        $table->addIndex('pricefrom', 'index_pricefrom');
        $table->addIndex('priceto', 'index_priceto');
        $table->addIndex('type', 'index_type');
        $table->addIndex('priority', 'index_priority');
        $table->addIndex('supplierid', 'index_supplierid');
        $table->addIndex('brandid', 'index_brandid');

        // привязки автоматических наценок к объектам
        $table = SQLObject_Config::Get()->addClass('XShopMarginRuleLink', 'shopmarginrulelink');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('marginruleid', 'int(11)');
        $table->addField('objecttype', 'varchar(255)');
        $table->addField('objectid', 'int(11)');
        // indexes
        $table->addIndex('objectid', 'index_objectid');
        $table->addIndex('objecttype', 'index_objecttype');

        // shopproductpricetask
        $table = SQLObject_Config::Get()->addClass('XShopProductPriceTask', 'shopproductpricetask');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('pdate', 'datetime');
        $table->addField('categoryid', 'int(11)');
        // indexes
        $table->addIndex('pdate', 'index_pdate');

    }

}