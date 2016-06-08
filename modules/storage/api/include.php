<?php

PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/services/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/system/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/forms/');

// дописываем обработчик в cron
Events::Get()->observe(
    'afterCronDay',
    'Storage_CronDayDefault'
);

// обработчик удаления заказа
Events::Get()->observe(
    'shopOrderDeleteBefore',
    'Storage_OrderDeleteHandler'
);

// обработчик удаления товара заказа
Events::Get()->observe(
    'shopOrderProductDeleteBefore',
    'Storage_OrderProductDeleteHandler'
);

// обработчик редактирования товара заказа
Events::Get()->observe(
    'shopOrderProductCountUpdateAfter',
    'Storage_OrderProductCountUpdateHandler'
);

// в случае изменения поставщиков - нужно запустить синхронизацию имен складов
// Supplier >> StorageName
Events::Get()->addEvent('ShopSupplier.delete.after', 'SQLObject_Event');
Events::Get()->observe('ShopSupplier.delete.after', 'Shop_QueProcessor_Event', 'Storage_SyncNames');
Events::Get()->addEvent('ShopSupplier.update.after', 'SQLObject_Event');
Events::Get()->observe('ShopSupplier.update.after', 'Shop_QueProcessor_Event', 'Storage_SyncNames');
Events::Get()->addEvent('ShopSupplier.insert.after', 'SQLObject_Event');
Events::Get()->observe('ShopSupplier.insert.after', 'Shop_QueProcessor_Event', 'Storage_SyncNames');

// и запустить перестройку ACL
Events::Get()->addEvent('ShopStorageName.delete.after', 'SQLObject_Event');
Events::Get()->observe('ShopStorageName.delete.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->addEvent('ShopStorageName.update.after', 'SQLObject_Event');
Events::Get()->observe('ShopStorageName.update.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->addEvent('ShopStorageName.insert.after', 'SQLObject_Event');
Events::Get()->observe('ShopStorageName.insert.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');