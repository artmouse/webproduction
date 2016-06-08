<?php
include_once(dirname(__FILE__).'/api/include.php');

// docs
include_once(dirname(__FILE__).'/docs/config.php');

PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Finance_ContentLoadObserver.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Finance_AdminMenu.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Finance_ACL.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Finance_DB.class.php');

Events::Get()->observe(
    'SQLObject.build.before',
    'Finance_DB'
);
// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'Finance_ContentLoadObserver'
);

// menu
Events::Get()->observe(
    'beforeBoxAdminMenuLoad',
    'Finance_AdminMenu'
);

// подгрузка ACL по требованию
Events::Get()->observe(
    'buildACL',
    'Finance_ACL'
);

// добавляем таб к заказу
Shop_ModuleLoader::Get()->registerOrderTabItem(
    'Финансы',
    'shop-admin-finance-tab-order',
    'finance',
    'finance'
);

// добавляем блок к статистике юзеров
Shop_ModuleLoader::Get()->registerUserStatisticsBlock(
    'admin-finance-user-block'
);

Shop_ModuleLoader::Get()->registerUserTabItem(
    'Платежи',
    'shop-admin-finance-tab-user',
    'user-finance',
    'finance'
);
// добавляем action блок
Events::Get()->observe(
    'buildActionBlock',
    'Finance_Action_Block_Build'
);

// документы
/*if (PackageLoader::Get()->getMode('build')) {
try {
SQLObject::TransactionStart();

$sync = new SQLObjectSync_Data(new XShopDocumentTemplate());

$languagesArray = array(
'ukr' => 'UA',
'ru' => 'RU',
'eng' => 'EN',
);

foreach ($languagesArray as $key => $name) {
$sync->addData(array(
'key' => 'finance-invoice-'.$key
),
array(
'name' => 'Счет-фактура ('.$name.')',
'content' => @file_get_contents(MEDIA_PATH.'/mail-templates/shop-document-invoice-'.$key.'.html'),
'type' => 'FinanceInvoice'
));
}

$sync->sync();

SQLObject::TransactionCommit();
} catch (Exception $ge) {
SQLObject::TransactionRollback();
throw $ge;
}
}*/

// cron
Events::Get()->observe(
    'afterCronMinute',
    'Finance_CronMinuteDefault'
);
// cron
Events::Get()->observe(
    'afterCronHour',
    'Finance_CronHourDefault'
);

// в случае изменения определенных сущностей - запускать отложенное событие buildACL
Events::Get()->addEvent('FinanceAccount.delete.after', 'SQLObject_Event');
Events::Get()->observe('FinanceAccount.delete.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->addEvent('FinanceAccount.update.after', 'SQLObject_Event');
Events::Get()->observe('FinanceAccount.update.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->addEvent('FinanceAccount.insert.after', 'SQLObject_Event');
Events::Get()->observe('FinanceAccount.insert.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');