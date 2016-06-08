<?php
include_once(dirname(__FILE__).'/api/include.php');
include_once(dirname(__FILE__).'/api/errors.php');

// подключаем help конфиг
include_once(dirname(__FILE__).'/docs/config.php');

PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage_Contents.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage_AdminMenu.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage_ACL.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage_DB.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage_Sync.class.php');

Events::Get()->observe(
    'SQLObject.build.before',
    'Storage_DB'
);

Events::Get()->observe(
    'SQLObject.build.after',
    'Storage_Sync'
);
// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'Storage_Contents'
);

// menu
Events::Get()->observe(
    'beforeBoxAdminMenuLoad',
    'Storage_AdminMenu'
);

// подгрузка ACL по требованию
Events::Get()->observe(
    'buildACL',
    'Storage_ACL'
);

Events::Get()->observe(
    'buildActionBlock',
    'Storage_Action_Block_Build'
);

// добавляем таб к заказу
Shop_ModuleLoader::Get()->registerOrderTabItem(
    'Склады',
    'shop-admin-storage-tab-order',
    'storage',
    'storage'
);

// добавляем таб к товарам
Shop_ModuleLoader::Get()->registerProductTabItem(
    'Склады',
    'shop-admin-storage-tab-product',
    'storage',
    'storage'
);

Shop_ModuleLoader::Get()->registerProductTabItem(
    'Паспорт продукта',
    'shop-admin-storage-tab-product-passport',
    'storagePassport',
    'storage'
);