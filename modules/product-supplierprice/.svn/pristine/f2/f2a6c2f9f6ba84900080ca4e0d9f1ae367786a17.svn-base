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
class SupplierPrice_DB implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        
        //  ShopPriceSupplierImport
        $table = SQLObject_Config::Get()->addClass('XShopPriceSupplierImport', 'shoppricesupplierimport');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('pdate', 'datetime');
        $table->addField('step', 'int(3)'); // шаг импорта прайса
        $table->addField('supplierid', 'int(3)');
        $table->addField('suppliercurrencyid', 'int(3)'); // валюта поставщика
        $table->addField('file', 'varchar(255)'); // файл
        $table->addField('filetype', 'varchar(55)'); // тип файла
        $table->addField('fileencoding', 'varchar(55)'); // кодировка файла
        $table->addField('columncode', 'varchar(55)');
        $table->addField('columnname', 'varchar(55)');
        $table->addField('columnarticul', 'varchar(55)');
        $table->addField('columnprice', 'int(3)');
        $table->addField('columnminretail', 'int(3)');
        $table->addField('columnminretail_cur_id', 'int(3)');
        $table->addField('columnrecommretail', 'int(3)');
        $table->addField('columnrecommretail_cur_id', 'int(3)');
        $table->addField('columnavail', 'varchar(55)');
        $table->addField('columncomment', 'varchar(55)');
        $table->addField('datelifeto', 'datetime');
        $table->addField('columndiscount', 'int(3)');
        $table->addField('optionarray', 'varchar(255)'); // массив дополнительнительных опций
        $table->addField('searchnameprecision', 'int(11)'); // точность поиска по имени
        $table->addField('lastpart', 'tinyint(1)'); // последняя часть прайса?
        $table->addField('firstpart', 'tinyint(1)'); // первая часть прайса?
        $table->addField('processed_lists', 'varchar(55)'); // загружаемые листы
        $table->addField('convert', 'tinyint(1)'); // была ли конвертация?
        $table->addField('xlssheet', 'int(3)'); //обрабатываемый лист
        $table->addField('pricename', 'varchar(255)');

        // indexes
        $table->addIndex('pdate', 'index_pdate');
        $table->addIndex(array('lastpart', 'cdate'), 'index_lastpart');
        $table->addIndex(array('firstpart', 'cdate'), 'index_firstpart');

        // PriceSupplierImportReport
        // служебная таблица для сбора информации о загрузке прайса
        $table = SQLObject_Config::Get()->addClass('XPriceSupplierImportReport', 'pricesupplierimportreport');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('dateupdate', 'datetime');
        $table->addField('productid', 'int(11)');
        $table->addField('productname', 'varchar(255)');
        $table->addField('error', 'tinyint(1)'); // ошибка обновления
        $table->addField('isnew', 'tinyint(1)'); // был ли создан новый товар
        // indexes
        $table->addIndex('productid', 'index_productid');

        // Статус загрузки прайса
        $table = SQLObject_Config::Get()->addClass('XPriceSupplierImportStatus', 'pricesupplierimportstatus');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('dateupload', 'datetime');
        $table->addField('supplierid', 'int(3)');
        $table->addField('processed', 'tinyint(1)');
        $table->addField('dateprocessed', 'datetime');
        $table->addField('resultfail', 'int(11)'); // error
        $table->addField('resultsuccess', 'int(11)'); // update
        $table->addField('resultadded', 'int(11)');
        $table->addField('resulttext', 'longtext');
        $table->addField('pricenamemd5', 'varchar(255)');
        $table->addField('priceid', 'int(11)');
        // indexes
        $table->addIndex('dateupload', 'index_dateupload');
        $table->addIndex('supplierid', 'index_supplierid');
        $table->addIndex('processed', 'index_processed');

        // ShopPriceSupplierSaveConfig
        // Конфиги вливания прайса поставщика
        $table = SQLObject_Config::Get()->addClass('XShopPriceSupplierConfig', 'shoppricesupplierconfig');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('supplierid', 'int(3)');
        $table->addField('suppliercurrencyid', 'int(3)'); // валюта поставщика
        $table->addField('filetype', 'varchar(55)'); // тип файла
        $table->addField('fileencoding', 'varchar(55)'); // кодировка файла
        $table->addField('columncode', 'varchar(55)');
        $table->addField('columnname', 'varchar(55)');
        $table->addField('columnarticul', 'varchar(55)');
        $table->addField('columnprice', 'varchar(55)');
        $table->addField('columnminretail', 'varchar(55)');
        $table->addField('minretail_cur_id', 'int(3)');
        $table->addField('columnrecommretail', 'varchar(55)');
        $table->addField('recommretail_cur_id', 'int(3)');
        $table->addField('columnavail', 'varchar(55)');
        $table->addField('columncomment', 'varchar(55)');
        $table->addField('columndiscount', 'varchar(55)');
        $table->addField('limitfrom', 'varchar(55)');
        $table->addField('limitto', 'varchar(55)');
        $table->addField('processed_lists', 'varchar(55)'); // загружаемые листы
        // настройки
        $table->addField('issearchcode', 'tinyint(1)'); // искать по коду
        $table->addField('issearchcodethis', 'tinyint(1)'); // искать по коду только этого поставщика
        $table->addField('issearchcodemd5', 'tinyint(1)'); // брать md5 от кода без пробелов lowercase
        $table->addField('issearchname', 'tinyint(1)'); // искать по имени
        $table->addField('issearchnameprecision', 'int(11)'); // точность поиска по имени
        $table->addField('issearcharticul', 'tinyint(1)'); // искать по артикулю
        $table->addField('notimportemptyprice', 'tinyint(1)'); // не импортировать товары с пустой ценой
        $table->addField('notimportemptyavail', 'tinyint(1)'); // не импортировать товары с пустой ценой
        $table->addField('importcron', 'tinyint(1)'); // импортировать в кроне
        $table->addField('createnewproduct', 'tinyint(1)'); // создать новые продукты
        $table->addField('onlyretail', 'tinyint(1)'); // только рцц и мин розница
        $table->addField('removeminretail', 'tinyint(1)'); // Стереть мин розницу
        $table->addField('removerecommretail', 'tinyint(1)'); // стереть реком розницу
        // indexes
        $table->addIndex('supplierid', 'index_supplierid');

        // Запоминание вручную выбранных товаров
        $table = SQLObject_Config::Get()->addClass('XShopPriceSupplierUserSelection', 'shoppricesupplieruserselection');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)'); // имя продукта
        $table->addField('productid', 'int(11)'); // к какому продукту привязано
        // индексы
        $table->addIndex('name', 'index_name');

        //временная таблица для загрузки прайсов в фоне
        $table = SQLObject_Config::Get()->addClass('XShopTmpPrice', 'shoptmpprice');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('priceid', 'int(11)');
        $table->addField('productid', 'int(11)');
        $table->addField('supplierid', 'int(3)');
        $table->addField('currencyid', 'int(3)');
        $table->addField('code', 'varchar(32)');
        $table->addField('name', 'varchar(255)');
        $table->addField('articul', 'varchar(32)');
        $table->addField('price', 'decimal(15,2)');
        $table->addField('minretail', 'decimal(15,2)');
        $table->addField('minretailcurrrncyid', 'int(3)');
        $table->addField('recommretail', 'decimal(15,2)');
        $table->addField('recommretailcurrruncyid', 'int(3)');
        $table->addField('availtext', 'varchar(16)');
        $table->addField('avail', 'tinyint(1)');
        $table->addField('comment', 'varchar(100)');
        $table->addField('datelifeto', 'datetime');
        $table->addField('isnew', 'tinyint(1)');
        $table->addField('date', 'datetime');
        $table->addField('discount', 'int(11)');
        $table->addField('olddate', 'datetime');
        $table->addField('isremoveminretail', 'tinyint(1)');
        $table->addField('isremoverecommretail', 'tinyint(1)');
        $table->addField('matchreason', 'varchar(255)');
        $table->addField('oldprice', 'decimal(15,2)');
        $table->addField('oldpricecurrencyid', 'int(3)');
        $table->addField('oldavailtext', 'varchar(16)');
        $table->addField('onlyretail', 'tinyint(1)');
        $table->addField('createnew', 'tinyint(1)');
        $table->addField('dateupload', 'datetime');

        // indexes
        $table->addIndex('supplierid', 'index_supplierid');
        $table->addIndex('productid', 'index_productid');

        //Черный список
        $table = SQLObject_Config::Get()->addClass('XShopPriceSupplierIgnore', 'shoppricesupplierignore');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('supplierid', 'int(3)');
        $table->addField('code', 'varchar(32)');
        $table->addField('name', 'varchar(255)');
        $table->addField('price', 'decimal(15,2)');
        $table->addField('currencyid', 'int(3)');
        $table->addField('availtext', 'varchar(16)');
        // индексы
        $table->addIndex('name', 'index_name');

    }

}