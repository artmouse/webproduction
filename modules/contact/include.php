<?php
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/api/');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Contact_ContentLoadObserver.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Contact_AdminMenu.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Contact_ACL.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Contact_DB.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Contact_Sync.class.php');

Events::Get()->observe(
    'SQLObject.build.before',
    'Contact_DB'
);

Events::Get()->observe(
    'SQLObject.build.after',
    'Contact_Sync'
);

// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'Contact_ContentLoadObserver'
);

// menu
Events::Get()->observe(
    'beforeBoxAdminMenuLoad',
    'Contact_AdminMenu'
);

// добавляем таб просмотреные товары к контакту
Shop_ModuleLoader::Get()->registerUserTabItem(
    'Просмотр продуктов',
    'shop-admin-user-tab-view-products',
    'viewproducts'
);

// docs
include_once(dirname(__FILE__).'/docs/config.php');

// подгрузка ACL по требованию
Events::Get()->observe(
    'buildACL',
    'Contact_ACL'
);

// Способы отображения контактов
Shop_ModuleLoader::Get()->registerUserViewMode(
    'Списком',
    'contact-mode-listing',
    'contact-mode-listing'
);

Shop_ModuleLoader::Get()->registerUserViewMode(
    'На карте',
    'contact-mode-maps',
    'contact-mode-maps'
);

// дописываемся в cron
Events::Get()->observe(
    'afterCronDay',
    'Contact_CronDay'
);

// в случае изменения определенных сущностей - запускать отложенное событие buildACL
Events::Get()->addEvent('ShopUserGroup.delete.after', 'SQLObject_Event');
Events::Get()->observe('ShopUserGroup.delete.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->addEvent('ShopUserGroup.update.after', 'SQLObject_Event');
Events::Get()->observe('ShopUserGroup.update.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->addEvent('ShopUserGroup.insert.after', 'SQLObject_Event');
Events::Get()->observe('ShopUserGroup.insert.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');