<?php
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Order_ContentLoadObserver.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Order_AdminMenu.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Order_ACL.class.php');

// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'Order_ContentLoadObserver'
);

// menu
Events::Get()->observe(
    'beforeBoxAdminMenuLoad',
    'Order_AdminMenu'
);

// docs
include_once(dirname(__FILE__).'/docs/config.php');

// подгрузка ACL по требованию
Events::Get()->observe(
    'buildACL',
    'Order_ACL'
);

// добавляем таб к товарам
Shop_ModuleLoader::Get()->registerProductTabItem(
    Shop::Get()->getTranslateService()->getTranslateSecure('translate_ords'),
    'shop-admin-order-tab-product',
    'order',
    'products-orders'
);

// добавляем блок к статистике юзеров
Shop_ModuleLoader::Get()->registerUserStatisticsBlock(
    'admin-order-user-block'
);