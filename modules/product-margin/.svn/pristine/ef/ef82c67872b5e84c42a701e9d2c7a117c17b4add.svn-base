<?php
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Margin_ContentLoadObserver.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Margin_ACL.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Margin_Sync.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/ProductMargin_DB.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/ProductMargin_AdminMenu.class.php');

Events::Get()->observe(
    'SQLObject.build.before',
    'ProductMargin_DB'
);

Events::Get()->observe(
    'SQLObject.build.after',
    'Margin_Sync'
);

// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'Margin_ContentLoadObserver'
);

// box-menu
Events::Get()->observe(
    'beforeBoxAdminMenuLoad',
    'ProductMargin_AdminMenu'
);

// docs
include_once(dirname(__FILE__).'/docs/config.php');

// подгрузка ACL по требованию
Events::Get()->observe(
    'buildACL',
    'Margin_ACL'
);

// добавляем таб к товарам
Shop_ModuleLoader::Get()->registerProductTabItem(
    Shop::Get()->getTranslateService()->getTranslateSecure('translate_convert_price'),
    'product-margin',
    'product-margin',
    'marginrule'
);

PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/system/Marginrule_CronHour.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/api/system/MarginRule_Processor_PriceTask.class.php');

// дописываемся в cron
Events::Get()->observe(
    'afterCronHour',
    'Marginrule_CronHour'
);