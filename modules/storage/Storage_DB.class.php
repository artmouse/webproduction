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
class Storage_DB implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        
        // shop storage - запись о движении товара на складе
        $table = SQLObject_Config::Get()->addClass('XShopStorage', 'shopstorage');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('transactionid', 'int(11)'); // транзакция

        $table->addField('storagenamefromid', 'int(11)'); // откуда
        $table->addField('storagenametoid', 'int(11)'); // куда

        $table->addField('productid', 'int(11)'); // товар
        $table->addField('productname', 'varchar(255)'); // товар
        $table->addField('parentid', 'int(11)'); // коробка, в которой приходовался товар
        $table->addField('isbox', 'tinyint(1)'); // коробка ли это

        $table->addField('serial', 'varchar(255)'); // серийный номер
        $table->addField('code', 'varchar(32)'); // код прихода
        $table->addField('shipment', 'varchar(255)'); // код партии
        $table->addField('contractorid', 'int(11)'); // юр лицо

        $table->addField('userid', 'int(11)'); // кто завел
        $table->addField('cdate', 'datetime'); // дата записи транзакции
        $table->addField('date', 'datetime'); // дата проведения (в интерфейсе)

        $table->addField('amount', 'decimal(15,3)'); // количество
        $table->addField('price', 'decimal(15,2)'); // входящая цена
        $table->addField('currencyrate', 'decimal(15,2)'); // курс к базовой валюте на момент закупки
        $table->addField('currencyid', 'int(11)'); // валюта
        $table->addField('taxrate', 'decimal(15,3)'); // пдв

        $table->addField('pricebase', 'decimal(15,2)'); // входящая цена в базовой валюте

        $table->addField('type', "enum('incoming','transfer','sale','production','outcoming')"); // тип перемещения
        $table->addField('storageorderproductid', 'int(11)'); // привязка к внутреннему заказу
        // если приход
        $table->addField('warranty', 'varchar(255)'); // информация о гарантии
        $table->addField('document', 'varchar(255)'); // приходной документ от поставщика
        $table->addField('workerid', 'int(11)'); // сотрудник (производственный приход)
        $table->addField('workeroperation', 'varchar(255)'); // код операции (производственный приход)
        // если перемещение
        $table->addField('return', 'tinyint(1)'); // возврат
        $table->addField('request', 'varchar(255)'); // заявка
        // если продажа
        $table->addField('orderproductid', 'int(11)'); // привязка к заказу
        // индексы
        $table->addIndex(array('storagenametoid', 'code', 'cdate'), 'index_storagenametoid');
        $table->addIndex('transactionid', 'index_transactionid');
        $table->addIndex(array('productid', 'date'), 'index_productid');
        $table->addIndex(array('code', 'date'), 'index_code');

        // транзакция
        $table = SQLObject_Config::Get()->addClass('XShopStorageTransaction', 'shopstoragetransaction');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('userid', 'int(11)'); // кто завел
        $table->addField('cdate', 'datetime'); // дата записи транзакции
        $table->addField('date', 'datetime'); // дата проведения (в интерфейсе)
        $table->addField('amount', 'decimal(15,3)'); // количество
        $table->addField('cost', 'decimal(15,2)'); // сумма
        $table->addField('type', "enum('incoming','transfer','sale','production','outcoming')"); // тип перемещения
        $table->addField('storagenamefromid', 'int(11)'); // откуда
        $table->addField('storagenametoid', 'int(11)'); // куда
        $table->addField('return', 'tinyint(1)'); // возврат
        $table->addField('returntransactionid', 'int(11)'); // транзакция, по которой делается возврат
        // если приход
        $table->addField('document', 'varchar(255)'); // приходной документ от поставщика
        // если перемещение
        $table->addField('request', 'varchar(255)'); // заявка
        // если продажа
        $table->addField('orderid', 'int(11)'); // привязка к заказу
        $table->addField('client', 'text'); // клиент
        // индексы
        $table->addIndex(array('type', 'date'), 'index_type');

        // shop storage names - имена складов
        $table = SQLObject_Config::Get()->addClass('XShopStorageName', 'shopstoragename');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)'); // название склада
        $table->addField('userid', 'int(11)'); // чей склад (указатель на юзера)
        $table->addField('forsale', 'tinyint(1)'); // со склада можно продавать
        $table->addField('isvendor', 'tinyint(1)'); // со склада можно приходовать
        $table->addField('issold', 'tinyint(1)'); // склад на который "складывается" проданный товар
        $table->addField('isemployee', 'tinyint(1)'); // это "сотрудник-склад"
        $table->addField('isoutcoming', 'tinyint(1)'); // склад на который "складывается" израсходованный товар
        $table->addField('isproduction', 'tinyint(1)'); // склад для раскомплектовки
        $table->addField('hidden', 'tinyint(1)');
        $table->addField('default', 'tinyint(1)');
        $table->addField('linkkey', 'varchar(255)');
        // индексы
        $table->addIndex(array('forsale', 'name'), 'index_forsale');
        $table->addIndex(array('isvendor', 'name'), 'index_isvendor');
        $table->addIndex(array('issold', 'name'), 'index_issold');
        $table->addIndex(array('isemployee', 'name'), 'index_isemployee');
        $table->addIndex(array('isoutcoming', 'name'), 'index_isoutcoming');
        $table->addIndex(array('isproduction', 'name'), 'index_isproduction');
        $table->addIndex(array('hidden', 'name'), 'index_hidden');
        $table->addIndex('linkkey', 'index_linkkey');

        // shop storage balance
        $table = SQLObject_Config::Get()->addClass('XShopStorageBalance', 'shopstoragebalance');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('storagenameid', 'int(11)'); // с какого склада
        $table->addField('productid', 'int(11)');
        $table->addField('productname', 'varchar(255)');
        $table->addField('code', 'varchar(32)'); // код прихода
        $table->addField('shipment', 'varchar(255)'); // код партии
        $table->addField('serial', 'varchar(255)'); // серийный номер
        $table->addField('cdate', 'datetime'); // дата прихода
        $table->addField('pricebase', 'decimal(15,2)'); // входящая цена в базовой валюте
        $table->addField('amount', 'decimal(15,3)'); // количество
        $table->addField('amountlinked', 'decimal(15,3)'); // количество зарезервировано
        $table->addField('cost', 'decimal(15,2)'); // общая стоимость
        $table->addField('price', 'decimal(15,2)'); // входящая цена
        $table->addField('currencyrate', 'decimal(15,2)'); // курс к базовой валюте на момент закупки
        $table->addField('currencyid', 'int(11)'); // валюта
        $table->addField('taxrate', 'decimal(15,3)'); // пдв
        // индексы
        $table->addIndex(array('storagenameid', 'productid', 'serial'), 'index_balance1');
        $table->addIndex(array('storagenameid', 'amount', 'productname'), 'index_balance2');
        $table->addIndex(array('productid', 'cdate'), 'index_productcdate');
        $table->addIndex('code', 'index_code');

        // shop storage link
        $table = SQLObject_Config::Get()->addClass('XShopStorageLink', 'shopstoragelink');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('storagebalanceid', 'int(11)'); // запись в балансе
        $table->addField('userid', 'int(11)');
        $table->addField('basketid', 'int(11)');
        $table->addField('amount', 'decimal(15,3)'); // количество
        $table->addField('orderid', 'int(11)'); // заказ
        $table->addField('orderproductid', 'int(11)'); // привязка к заказу
        // индексы
        $table->addIndex('basketid', 'index_basketid');
        $table->addIndex('orderproductid', 'index_orderproductid');
        $table->addIndex('storagebalanceid', 'index_storagebalanceid');

        // паспорт товара
        $table = SQLObject_Config::Get()->addClass('XShopProductPassport', 'shopproductpassport');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('name', 'varchar(255)');
        $table->addField('valid', 'tinyint(1)');
        $table->addField('default', 'int(11)');
        // indexes
        $table->addIndex(array('valid', 'name'), 'index_validname');
        $table->addIndex(array('default'), 'index_default');

        // паспорт товара
        $table = SQLObject_Config::Get()->addClass('XShopProductPassportItem', 'shopproductpassportitem');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('passportid', 'int(11)'); // паспорт
        $table->addField('productid', 'int(11)'); // товар
        $table->addField('istarget', 'tinyint(1)'); // является ли данный товар 1 - целью 0 - материалом
        $table->addField('amount', 'decimal(15,3)'); // количество
        // indexes
        $table->addIndex('passportid', 'index_passportid');

        // товары корзины складских операций
        $table = SQLObject_Config::Get()->addClass('XShopStorageBasket', 'shopstoragebasket');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime');
        $table->addField('userid', 'int(11)'); // чья корзина
        $table->addField('type', "enum('incoming','transfer','sale','production','stocktaking','outcoming')"); // тип
        $table->addField('orderid', 'int(11)'); // заказ
        $table->addField('productid', 'int(11)'); // товар
        $table->addField('amount', 'decimal(15,3)'); // количество
        $table->addField('serial', 'varchar(255)'); // серийный номер
        $table->addField('orderproductid', 'int(11)'); // привязка к заказу
        $table->addField('storageorderproductid', 'int(11)'); // привязка к внутреннему заказу
        $table->addField('storageordersync', 'tinyint(1)'); // синхронизировать с внутренним заказом
        // для приходов
        $table->addField('shipment', 'varchar(255)'); // код партии
        $table->addField('price', 'decimal(15,2)'); // входящая цена
        $table->addField('currencyid', 'int(11)'); // валюта
        $table->addField('warranty', 'varchar(255)'); // информация о гарантии
        $table->addField('tax', 'tinyint(1)'); // пдв
        $table->addField('workerid', 'int(11)'); // сотрудник (производственный приход)
        $table->addField('workeroperation', 'varchar(255)'); // код операции (производственный приход)
        // для перемещений и производства
        $table->addField('storagenamefromid', 'int(11)'); // с какого склада
        // для производства
        $table->addField('istarget', 'tinyint(1)'); // это товар - 1, это материал - 0
        $table->addField('passportid', 'int(11)'); // паспорт
        // индексы
        $table->addIndex('type', 'index_type');

        // складской заказ
        $table = SQLObject_Config::Get()->addClass('XShopStorageOrder', 'shopstorageorder');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime'); // дата
        $table->addField('userid', 'int(11)'); // чей заказ
        $table->addField('type', "enum('incoming','transfer','production')"); // тип
        $table->addField('storagenamefromid', 'int(11)');
        $table->addField('storagenametoid', 'int(11)');
        $table->addField('isshipped', 'tinyint(1)'); // отгружен ли товар (со склада)
        $table->addField('sum', 'decimal(15,2)'); // сумма в системной валюте
        // indexes
        $table->addIndex('userid', 'index_userid');
        $table->addIndex('isshipped', 'index_isshipped');
        $table->addIndex('type', 'index_type');

        // товары складского заказа
        $table = SQLObject_Config::Get()->addClass('XShopStorageOrderProduct', 'shopstorageordertproduct');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('orderid', 'int(11)'); // заказ
        $table->addField('productid', 'int(11)'); // товар
        $table->addField('amount', 'decimal(15,3)'); // количество
        $table->addField('price', 'decimal(15,2)'); // входящая цена
        $table->addField('currencyrate', 'decimal(15,2)'); // курс к базовой валюте
        $table->addField('currencyid', 'int(11)'); // валюта
        $table->addField('taxrate', 'decimal(15,3)'); // пдв
        $table->addField('isshipped', 'tinyint(1)'); // отгружен ли товар (со склада)
        // indexes
        $table->addIndex('orderid', 'index_orderid');
        $table->addIndex('productid', 'index_productid');

        // привязка складского заказа к складской транзакции
        $table = SQLObject_Config::Get()->addClass('XShopStorageOrder2Transaction', 'shopstorageorder2transaction');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('orderid', 'int(11)');
        $table->addField('transactionid', 'int(11)');
        // indexes
        $table->addIndex('orderid', 'index_orderid');

        // минимальный резерв
        $table = SQLObject_Config::Get()->addClass('XShopStorageReserve', 'shopstoragereserve');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('storagenameid', 'int(11)');
        $table->addField('productid', 'int(11)');
        $table->addField('amount', 'decimal(15,3)'); // количество
        $table->addField('rrc', 'decimal(15,2)'); // рекомендуемая цена продажи товара
        $table->addField('currencyid', 'int(11)');
        // индексы
        $table->addIndexUnique(array('storagenameid', 'productid'), 'index_storagenameid_productid');

        // отчет по продажам
        $table = SQLObject_Config::Get()->addClass('XShopStorageReportSales', 'shopstoragereportsales');
        $table->addField('id', 'int(11)', 'auto_increment');
        $table->addIndexPrimary('id');
        $table->addField('cdate', 'datetime'); // дата обновления записи
        $table->addField('dateorder', 'datetime'); // дата заказа
        $table->addField('dateship', 'datetime'); // дата отгрузки
        $table->addField('dateincoming', 'datetime'); // дата оприходования
        $table->addField('orderid', 'int(11)'); // заказ
        $table->addField('clientid', 'int(11)'); // клиент
        $table->addField('managerid', 'int(11)'); // менеджер
        // $table->addField('departmentid', 'int(11)'); // отдел
        $table->addField('discountpercent', 'int(11)'); // процент скидки
        $table->addField('sumorder', 'decimal(15,2)'); // сумма заказано
        $table->addField('sumship', 'decimal(15,2)'); // сумма отгружено
        $table->addField('sumcost', 'decimal(15,2)'); // сумма себестоимости
        $table->addField('orderproductid', 'int(11)'); // товар заказа
        $table->addField('productid', 'int(11)'); // товар
        $table->addField('productname', 'varchar(255)'); // товар
        $table->addField('productprice', 'decimal(15,2)'); // цена товара в базовой валюте
        $table->addField('productamountorder', 'decimal(15,3)'); // количество товара заказано
        $table->addField('productamountship', 'decimal(15,3)'); // количество товара отгружено
        $table->addField('productsumorder', 'decimal(15,2)'); // сумма товара заказано
        $table->addField('productsumship', 'decimal(15,2)'); // сумма товара отгружено
        $table->addField('productsumcost', 'decimal(15,2)'); // сумма товара себестоимости
        $table->addField('transactionid', 'int(11)'); // транзакция отгрузки
        $table->addField('storagenameid', 'int(11)'); // склад, с которого отгрузили
        $table->addField('supplierid', 'int(11)'); // поставщик товара отгружено
        $table->addField('storageid', 'int(11)'); // товар склада
        $table->addField('storageprice', 'decimal(15,2)'); // цена товара склада
        $table->addField('storageamountorder', 'decimal(15,3)'); // товар склада заказано
        $table->addField('storageamountship', 'decimal(15,3)'); // товар склада
        $table->addField('storagesumorder', 'decimal(15,2)'); // сумма товара склада заказано
        $table->addField('storagesumship', 'decimal(15,2)'); // сумма товара склада отгружено
        $table->addField('storagesumcost', 'decimal(15,2)'); // сумма товара склада себестоимости
        // indexes
        $table->addIndex('cdate', 'index_cdate');

        // добавляем поля к статусу заказов
        $table = SQLObject_Config::Get()->addClass('XShopOrderStatus', 'shoporderstatus');
        $table->addField('storage_incoming', 'tinyint(1)');
        $table->addField('storagenameid_incoming', 'int(11)');
        $table->addField('storage_sale', 'tinyint(1)');
        $table->addField('storage_reserve', 'tinyint(1)');
        $table->addField('storage_unreserve', 'tinyint(1)');
        $table->addField('storage_return', 'tinyint(1)');

        // добавляем поля к статусу заказов
        $table = SQLObject_Config::Get()->addClass('XShopOrderProduct', 'shoporderproduct');
        $table->addField('storageincomingid', 'int(11)');

    }

}