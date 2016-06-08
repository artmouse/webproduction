<?php
include_once(dirname(__FILE__).'/api/include.php');

include_once(dirname(__FILE__).'/docs/config.php');

PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Box_Contents.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Box_AdminMenu.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Box_ACL.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Box_DB.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Box_Sync.class.php');

Events::Get()->observe(
    'SQLObject.build.before',
    'Box_DB'
);

Events::Get()->observe(
    'SQLObject.build.after',
    'Box_Sync'
);

// регистрируем контенты в движке
Events::Get()->observe(
    'afterContentLoad',
    'Box_Contents'
);

Events::Get()->observe(
    'buildActionBlock',
    'Box_Action_Block_Build'
);

Events::Get()->observe(
    'buildInterfaceBlock',
    'Box_Interface_Block_Build'
);

// menu
Events::Get()->observe(
    'beforeBoxAdminMenuLoad',
    'Box_AdminMenu'
);

// @todo: избавиться от этого вообще
Engine::Get()->setConfigField('project-box', true);

// branding
if (!Engine::Get()->getConfigFieldSecure('project-branding')) {
    Engine::Get()->setConfigField('project-branding', 'OneBox');
}

// подгрузка ACL по требованию
Events::Get()->observe(
    'buildACL',
    'Box_ACL'
);

// добавляем способ отображения заказов
Shop_ModuleLoader::Get()->registerOrderViewMode(
    'Календарем',
    'calendar-block',
    'calendar'
);

Shop_ModuleLoader::Get()->registerOrderViewMode(
    'Диаграммой (Gantt)',
    'gantt-index',
    'gantt'
);

Shop_ModuleLoader::Get()->registerOrderViewMode(
    'Статистикой этапов (PERT)',
    'funnel-index',
    'stage'
);

Shop_ModuleLoader::Get()->registerOrderViewMode(
    'Воронкой',
    'funnel-chart-index',
    'funnel'
);

Shop_ModuleLoader::Get()->registerOrderViewMode(
    'Статусами',
    'issue-status-index',
    'status'
);

Shop_ModuleLoader::Get()->registerOrderViewMode(
    'Mind map',
    'mind-index',
    'mind'
);

Shop_ModuleLoader::Get()->registerOrderViewMode(
    'На карте',
    'maps-index',
    'maps'
);

// добавляем табы к заказу
Shop_ModuleLoader::Get()->registerOrderTabItem(
    'События',
    'shop-admin-order-event',
    'event',
    'event'
);

Shop_ModuleLoader::Get()->registerOrderTabItem(
    'Исполнители',
    'shop-admin-orders-employer',
    'employer',
    'employer'
);

Shop_ModuleLoader::Get()->registerOrderTabItem(
    'Контакты',
    'shop-admin-orders-contacts',
    'contacts',
    'users'
);

Shop_ModuleLoader::Get()->registerOrderTabItem(
    'История',
    'shop-admin-orders-log',
    'log',
    'log'
);

// добавляем блоки к статистике юзеров
Shop_ModuleLoader::Get()->registerUserStatisticsBlock(
    'admin-issue-user-block'
);

Shop_ModuleLoader::Get()->registerUserStatisticsBlock(
    'admin-project-user-block'
);

// добавляем таб файлы к заказу
Shop_ModuleLoader::Get()->registerOrderTabItem(
    Shop::Get()->getTranslateService()->getTranslate('translate_fayli'),
    'shop-admin-orders-files',
    'file',
    'files'
);

// добавляем таб файлы к контакту
Shop_ModuleLoader::Get()->registerUserTabItem(
    Shop::Get()->getTranslateService()->getTranslate('translate_fayli'),
    'shop-admin-user-tab-files',
    'file',
    'files'
);

// добавляем таб KPI к контакту
Shop_ModuleLoader::Get()->registerUserTabItem(
    'KPI',
    'shop-admin-user-tab-kpi',
    'kpi',
    'users_kpi'
);

// добавляем таб файлы к контакту
Shop_ModuleLoader::Get()->registerUserTabItem(
    'Рабочий график',
    'shop-admin-user-tab-worktime',
    'worktime'
);

// быстрое закрытие notify после добавления или обновления юзера
Events::Get()->addEvent('UserAddAfter', 'SQLObject_Event');
Events::Get()->observe('UserAddAfter', 'Box_Event_UserNotifyObserver');

Events::Get()->addEvent('User.update.after', 'SQLObject_Event');
Events::Get()->observe('User.update.after', 'Box_Event_UserNotifyObserver');

Events::Get()->observe('shopUserAddAfter', 'ProductView_UserAddAfter');

// подмена на свой SMTP
Engine::Get()->setConfigField('mail-sender', 'Box_SenderMail');

// косим вечные кроны
if (PackageLoader::Get()->getMode('build')) {
    ModeService::Get()->verbose('Killing lifetime crons...');

    $returnProcessArray = array();
    exec('ps ux | grep cron-ami', $returnProcessArray);

    foreach ($returnProcessArray as $process) {
        if (preg_match('/^[\w\d]*\s*([\d]+)\s+/uis', $process, $r)) {
            $resultKill = false;
            $result = false;

            ModeService::Get()->verbose('Kill process PID '.$r[1]);
            LogService::Get()->add('Killing process PID='.$r[1].' '.$process, 'kill');
            exec('kill '.$r[1].' &> /dev/null', $resultKill, $result);

            if (!$result && file_exists(__DIR__.'/cron/cron-ami.php.pid')) {
                unlink(__DIR__.'/cron/cron-ami.php.pid');
            }
        }
    }

    $returnProcessArray = array();
    exec('ps ux | grep cron-imap', $returnProcessArray);

    foreach ($returnProcessArray as $process) {
        if (preg_match('/^[\w\d]*\s*([\d]+)\s+/uis', $process, $r)) {
            $resultKill = false;
            $result = false;

            ModeService::Get()->verbose('Kill process PID '.$r[1]);
            LogService::Get()->add('Killing process PID='.$r[1].' '.$process, 'kill');
            exec('kill '.$r[1].' &> /dev/null', $resultKill, $result);

            if (!$result && file_exists(__DIR__.'/cron/cron-imap.php.pid')) {
                unlink(__DIR__.'/cron/cron-imap.php.pid');
            }
        }
    }
}