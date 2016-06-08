<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

// для авторизации с одной сессией на разных поддоменах
ini_set('session.cookie_domain', '.'.Engine::Get()->getProjectHost());
ini_set('session.cookie_secure', 'off');
ini_set('session.use_only_cookies', 1);

// запись в лог при Fatal Error
register_shutdown_function(
    function () {
        $errorArray = error_get_last();

        if (@$errorArray['type'] == 8) {
            return false;
        }

        LogService::Get()->add($errorArray, 'fatal');
    }
);

// issue #45129
session_start();

// robots.txt тестовый сайт
try {
    $projectTest = Engine::Get()->getConfigField('project-test');
} catch (Exception $e) {
    $host = Engine::GetURLParser()->getHost();
    if (preg_match('/.webproduction./', $host)
        || preg_match('/.oneclick./', $host)
        || preg_match('/.onebox-system./', $host)
    ) {
        Engine::Get()->setConfigField('project-test', true);
    } else {
        Engine::Get()->setConfigField('project-test', false);
    }
}

try {
    // подключаем SQLObject
    PackageLoader::Get()->import('SQLObject');

    // текущее соединение с базой
    $connection = ConnectionManager::Get()->getConnectionMySQL();

    // задаем соединение с SQLObject
    // строка ОБЯЗАТЕЛЬНА!
    SQLObject_Config::Get()->setConnectionDatabase($connection);
} catch (Exception $e) {

}

// задаем SQLObject путь для генерации файлов
SQLObject_Config::Get()->setPathDatabaseClasses(PROJECT_PATH.'api/db/');

// подключаем пакеты, которые нужны на всех страницах
PackageLoader::Get()->registerJSFile('/_js/jquery-1.8.2.min.js');
PackageLoader::Get()->registerJSFile('/_js/jquery-ui.min.js');
PackageLoader::Get()->registerCSSFile('/_css/jquery-ui.css');
PackageLoader::Get()->registerJSFile('/_js/jquery.uploadify.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.cookie.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.colorpicker.js');
PackageLoader::Get()->registerJSFile('/_js/no-conflict.js');
PackageLoader::Get()->registerJSFile('/_js/os-detection.js');
PackageLoader::Get()->registerJSFile('/_js/mouse.js');
PackageLoader::Get()->registerJSFile('/_js/jcarousellite.min.js');
PackageLoader::Get()->registerJSFile('/_js/tinymce/tinymce.min.js');
PackageLoader::Get()->registerJSFile('/_js/slick.min.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.eislideshow.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.easing.1.3.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.mousewheel.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.maskedinput.js');
PackageLoader::Get()->registerJSFile('/_js/jQueryTabs.js');
PackageLoader::Get()->registerJSFile('/_js/md5.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.colorbox.js');
PackageLoader::Get()->registerJSFile('/_js/jq.scrollTo-min.js');
PackageLoader::Get()->registerCSSFile('/_css/colorbox.css');
PackageLoader::Get()->registerCSSFile('/_css/jquery.colorpicker.css');
PackageLoader::Get()->registerJSFile('/_js/jquery.hotkeys.js');
PackageLoader::Get()->registerJSFile('/_js/masonry.pkgd.min.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.uniform.min.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.placeholder.min.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.history.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.selectbox-0.2.min.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.zoomtoo.min.js');
PackageLoader::Get()->registerJSFile('/_js/utmLabel.js');
PackageLoader::Get()->registerJSFile('/_js/ios.drag.fix.js');

PackageLoader::Get()->import('FS');
PackageLoader::Get()->import('StringUtils');
PackageLoader::Get()->import('ImageProcessor');
PackageLoader::Get()->import('Checker');
PackageLoader::Get()->import('MailUtils');
PackageLoader::Get()->import('SMSUtils');
PackageLoader::Get()->import('ServiceUtils');
PackageLoader::Get()->import('DateTime');
PackageLoader::Get()->import('CommentsAPI');
PackageLoader::Get()->import('Forms');

// задаем отправщик писем, по умолчанию все письма складывать в базу
MailUtils_Config::Get()->setSender('MailUtils_SenderQueDB');

// если в engine.mode.php не был задан отправщик почты,
// то по умолчанию будем использовать стандартный mail()
if (!Engine::Get()->getConfigFieldSecure('mail-sender')) {
    Engine::Get()->setConfigField('mail-sender', 'MailUtils_SenderMail');
}

PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Shop_DB.class.php');
PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Shop_Sync.class.php');

Events::Get()->observe(
    'SQLObject.build.before',
    'Shop_DB'
);

Events::Get()->observe(
    'SQLObject.build.after',
    'Shop_Sync'
);

// что будет делать движок в случае если мы не отловим Exception и он вылетит
Events::Get()->observe(
    'afterEngineException',
    'Shop_EngineException'
);

// сразу подключаем все API
include_once(dirname(__FILE__).'/db/index.php');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/services/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/system/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/forms/');

include_once(dirname(__FILE__).'/errors.php');

// расширенные настройки Pool'a
SQLObject_Config::Get()->setMaxPoolObjects('ShopOrder', 1000);
SQLObject_Config::Get()->setMaxPoolObjects('User', 500);
SQLObject_Config::Get()->setMaxPoolObjects('ShopOrderStatus', 500);
SQLObject_Config::Get()->setMaxPoolObjects('ShopOrderCategory', 500);


// добавляем cron-события
Events::Get()->addEvent('afterCronMinute', 'Events_Event');
Events::Get()->addEvent('afterCronHour', 'Events_Event');
Events::Get()->addEvent('afterCronDay', 'Events_Event');

// события для пересчета наличий
Events::Get()->addEvent('beforeProductAvailProcess', 'Events_Event');
Events::Get()->addEvent('afterProductAvailProcess', 'Events_Event');

// событие для перестройки ACL
Events::Get()->addEvent('buildACL', 'Events_Event'); // на это событие все вешаются

// событие для перестройки блоков
Events::Get()->addEvent('buildActionBlock', 'Events_Event');
Events::Get()->addEvent('buildInterfaceBlock', 'Events_Event');

// событие для переводов
Events::Get()->addEvent('beforeShopTranslateObserver', 'Events_Event');
Events::Get()->addEvent('beforeTranslateLoad', 'Events_Event');
Events::Get()->addEvent('afterTranslateLoad', 'Events_Event');

Events::Get()->observe(
    'beforeShopTranslateObserver',
    'Shop_LanguageMachine'
);

Events::Get()->observe(
    'beforeTranslateLoad',
    'Shop_TranslateLoadObserver'
);

// текущий язык
$language = Engine::Get()->getConfigFieldSecure('language-site');
if (strpos(Engine::GetURLParser()->getTotalURL(), '/admin/') === 0
    && Engine::Get()->getConfigFieldSecure('language-admin')) {
    $language = Engine::Get()->getConfigFieldSecure('language-admin');
}

// задаем перевода для пакетов
DateTime_Translate::Get()->setLanguage($language);
Forms_Translate::Get()->setLanguage($language);

// регистрируем обработчики событий
Events::Get()->observe(
    'afterQueryDefine',
    'Shop_AuthMachine'
);

Events::Get()->observe(
    'afterQueryDefine',
    'Shop_AuthLoginza'
);

Events::Get()->observe(
    'afterQueryDefine',
    'Shop_Install'
);

Events::Get()->observe(
    'afterCronDay',
    'Shop_CronDayDefault'
);

Events::Get()->observe(
    'afterCronHour',
    'Shop_CronHourDefault'
);

Events::Get()->observe(
    'afterCronMinute',
    'Shop_CronMinuteDefault'
);

// задаем сервис авторизации
Engine_Auth::SetAuthService(Shop::Get()->getUserService());

// подгрузка ACL по требованию
Events::Get()->observe(
    'buildACL',
    'Shop_ACL'
);

// проверка прав
Events::Get()->observe(
    'beforeContentProcess',
    'Shop_ACLObserver'
);

// система блоков
// пропускаем админку полностью
// пропускаем инсталлятор полностью
$url = Engine::GetURLParser()->getCurrentURL();
if ($url &&
    !substr_count($url, '/admin/')
    && !substr_count($url, '/install/')
) {
    Events::Get()->observe(
        'afterContentProcess',
        new Shop_BlockObserver()
    );
}

// задаем собственный URLParser
Engine::Get()->setURLParser(Shop_URLParser::Get());

if (Engine::Get()->getConfigFieldSecure('shop-cache')) {
    $cacheStorage = Storage::Initialize('shop-cache', new Shop_CacheHandler());
} else {
    try {
        $host = Engine::Get()->getProjectHost();
        $cacheStorage = Storage::Initialize('shop-cache', new Storage_HandlerMemcache($host));
    } catch (Exception $memcacheEx) {
        $cacheStorage = Storage::Initialize('shop-cache', new Shop_CacheHandler());
    }
}

Engine::GetCache()->setStorage($cacheStorage);

Events::Get()->observe(
    'afterEngineFinal',
    'Shop_CKFinderObserver'
);

// в каждый content передаем переменные contentID и currentURL,
// и переводы
Events::Get()->observe(
    'beforeContentProcess',
    'Shop_ContentValueObserver'
);

// регистрация базовых событий OneBox

// category
Events::Get()->addEvent('shopCategoryDeleteBefore', 'Shop_Event_Category');
Events::Get()->addEvent('shopCategoryDeleteAfter', 'Shop_Event_Category');

// product
Events::Get()->addEvent('shopProductAddAfter', 'Shop_Event_Product');
Events::Get()->addEvent('shopProductEditBefore', 'Shop_Event_Product');
Events::Get()->addEvent('shopProductEditAfter', 'Shop_Event_Product');
Events::Get()->addEvent('shopProductDeleteBefore', 'Shop_Event_Product');
Events::Get()->addEvent('shopProductDeleteAfter', 'Shop_Event_Product');
Events::Get()->addEvent('shopMarginProductAfter', 'Shop_Event_Product');

// order
Events::Get()->addEvent('shopOrderAddAfter', 'Shop_Event_Order');
Events::Get()->addEvent('shopOrderEditBefore', 'Shop_Event_Order');
Events::Get()->addEvent('shopOrderEditAfter', 'Shop_Event_Order');
Events::Get()->addEvent('shopOrderDeleteBefore', 'Shop_Event_Order');
Events::Get()->addEvent('shopOrderDeleteAfter', 'Shop_Event_Order');
Events::Get()->addEvent('shopOrderStatusUpdateAfter', 'Shop_Event_Order');

Events::Get()->addEvent('shopOrderEmployerUpdateAfter', 'Shop_Event_OrderEmployer');

Events::Get()->addEvent('shopOrderProductDeleteBefore', 'Shop_Event_OrderProduct');
Events::Get()->addEvent('shopOrderProductCountUpdateAfter', 'Shop_Event_OrderProduct');

Events::Get()->addEvent('shoprecalculateOrderSumsBefore', 'Shop_Event_Order');
Events::Get()->addEvent('shoprecalculateOrderSumsAfter', 'Shop_Event_Order');

Events::Get()->addEvent('shopOrderCommentAddAfter', 'Shop_Event_OrderComment');
Events::Get()->addEvent('shopOrderCommentAddBefore', 'Shop_Event_OrderComment');

// user/client
Events::Get()->addEvent('shopUserAddAfter', 'Shop_Event_User');
Events::Get()->addEvent('shopUserEditBefore', 'Shop_Event_User');
Events::Get()->addEvent('shopUserEditAfter', 'Shop_Event_User');

// события для обработки статусов в случае их удаление
Events::Get()->addEvent('ShopOrderStatus.delete.after', 'SQLObject_Event');
Events::Get()->observe('ShopOrderStatus.delete.after', 'Shop_Event_OrderStatusDeleteAfter');

// в случае изменения определенных сущностей - запускать отложенное событие buildACL
// ShopOrderStatus
Events::Get()->addEvent('ShopOrderStatus.delete.after', 'SQLObject_Event');
Events::Get()->observe('ShopOrderStatus.delete.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->addEvent('ShopOrderStatus.update.after', 'SQLObject_Event');
Events::Get()->observe('ShopOrderStatus.update.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->addEvent('ShopOrderStatus.insert.after', 'SQLObject_Event');
Events::Get()->observe('ShopOrderStatus.insert.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');

// ShopOrderCategory
Events::Get()->addEvent('ShopOrderCategory.delete.after', 'SQLObject_Event');
Events::Get()->observe('ShopOrderCategory.delete.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->addEvent('ShopOrderCategory.update.after', 'SQLObject_Event');
Events::Get()->observe('ShopOrderCategory.update.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->addEvent('ShopOrderCategory.insert.after', 'SQLObject_Event');
Events::Get()->observe('ShopOrderCategory.insert.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');

// XShopWorkflowType
Events::Get()->addEvent('XShopWorkflowType.delete.after', 'SQLObject_Event');
Events::Get()->observe('XShopWorkflowType.delete.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->observe('XShopWorkflowType.delete.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildMenu');
Events::Get()->addEvent('XShopWorkflowType.update.after', 'SQLObject_Event');
Events::Get()->observe('XShopWorkflowType.update.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->observe('XShopWorkflowType.update.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildMenu');
Events::Get()->addEvent('XShopWorkflowType.insert.after', 'SQLObject_Event');
Events::Get()->observe('XShopWorkflowType.insert.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildACL');
Events::Get()->observe('XShopWorkflowType.insert.after', 'Shop_QueProcessor_Event', 'Shop_Processor_BuildMenu');

// legal formats
$a = array();
$a['Ukraine'] = array(
    'name' => 'Наименование',
    'director' => 'Директор',
    'registration' => 'Основание деятельности',
    'address' => 'Адрес',
    'inn' => 'ИНН',
    'edprou' => 'ЕДПРОУ',
    'bankaccount' => 'Расчетный счет',
    'bankname' => 'Банк',
    'bankcode' => 'МФО',
);

$a['Kazakhstan'] = array(
    'name' => 'Наименование',
    'director' => 'Директор',
    'registration' => 'Основание деятельности',
    'address' => 'Адрес',
    'rnn' => 'РНН',
    'bin' => 'БИН',
    'bik' => 'БИК',
    'bankaccount' => 'Расчетный счет',
    'bankname' => 'Банк',
);

$a['Belarus'] = array(
    'name' => 'Наименование',
    'director' => 'Директор',
    'registration' => 'Основание деятельности',
    'address' => 'Адрес',
    'okpo' => 'ОКПО',
    'unp' => 'УНП',
    'mfo' => 'МФО/БИК',
    'bankaccount' => 'Расчетный счет',
    'bankname' => 'Банк',
    'bankaddress' => 'Адрес банка',
);

$a['Russia'] = array(
    'name' => 'Наименование',
    'director' => 'Директор',
    'registration' => 'Основание деятельности',
    'address' => 'Адрес',
    'bik' => 'БИК',
    'inn' => 'ИНН',
    'kpp' => 'КПП',
    'ogrn' => 'ОГРН',
    'cassaccount' => 'Кассовый счет',
    'bankaccount' => 'Расчетный счет',
    'bankname' => 'Банк',
    'bankaddress' => 'Адрес банка',
);

$a['International-ABA'] = array(
    'name' => 'Company name',
    'director' => 'Director',
    'address' => 'Company address',
    'bankname' => 'Bank name',
    'bankaddress' => 'Bank address',
    'abanumber' => 'ABA Number',
    'bankaccount' => 'Account number',
    'iban' => 'IBAN',
);

$a['International-SWIFT'] = array(
    'name' => 'Company name',
    'director' => 'Director',
    'address' => 'Company address',
    'bankname' => 'Bank name',
    'bankaddress' => 'Bank address',
    'swiftcode' => 'SWIFT code',
    'bankaccount' => 'Account number',
    'iban' => 'IBAN',
);

Engine::Get()->setConfigField('legalFormatArray', $a);

// форматы баннеров
try {
    Engine::Get()->getConfigField('shop-banner-place');
} catch (Exception $e) {
    $a = array();

    $a['top'] = array(
        'name' => 'Сверху в категории и бренде (940x340px)',
        'width' => 940,
        'height' => 340,
        'method' => false,
    );

    $a['left'] = array(
        'name' => 'Слева в колонке (220x250px)',
        'width' => 220,
        'height' => 250,
        'method' => false,
    );

    $a['right'] = array(
        'name' => 'Справа в колонке (220x250px)',
        'width' => 220,
        'height' => 250,
        'method' => false,
    );

    $a['index'] = array(
        'name' => 'Большой на главной (940x340px)',
        'width' => 940,
        'height' => 200,
        'method' => false,
    );

    $a['welcome'] = array(
        'name' => 'Добро пожаловать (800x350px)',
        'width' => 800,
        'height' => 350,
        'method' => false,
    );

    $a['success'] = array(
        'name' => 'При успешной покупке (800x350px)',
        'width' => 800,
        'height' => 350,
        'method' => false,
    );

    $a['wide'] = array(
        'name' => 'На всю ширину под главным меню (1920 x auto)',
        'method' => false,
    );
    
    $a['page-interval'] = array(
        'name' => 'Баннер всплывающим окном со страничным интервалом (800x350px)',
        'width' => 800,
        'height' => 350,
        'method' => false,
    );

    Engine::Get()->setConfigField('shop-banner-place', $a);
}

if (PackageLoader::Get()->getMode('build-scss')) {
    ModeService::Get()->verbose('build SCSS...');

    // подключаем SCSS компилятор
    PackageLoader::Get()->import('SCSSPHP');

    // Компилим все scss в css
    Compile_Scss_To_Css::Get()->compile();

    //    $minify = new ShopMinify('/_js/cache/', '/_css/cache/', false);
    //    $minify->process();
}

// обработчик распределения товаров в категориях
Events::Get()->observe(
    'afterCronMinute',
    'ShopBuildProductCategory_CronMinute'
);

Events::Get()->observe(
    'afterCronMinute',
    'Action_Status_CronMinute'
);

// Обработчик часового крона, для действий статуса
Events::Get()->observe(
    'afterCronHour',
    'Action_Status_CronHour'
);

// Обработчик дневного крона, для действий статуса
Events::Get()->observe(
    'afterCronDay',
    'Action_Status_CronDay'
);

// Обработчик изменения статуса, для действий статуса
Events::Get()->observe(
    'shopOrderStatusUpdateAfter',
    'Action_Status_OrderStatusUpdateAfter'
);

// Обработчик изменения зазака, для действий статуса
Events::Get()->observe(
    'shopOrderAddAfter',
    'Action_Status_OrderAddAfter'
);

// Обработчик удаления заказа, для действий статуса
Events::Get()->observe(
    'shopOrderDeleteBefore',
    'Action_Status_OrderDeleteBefore'
);

// Обработчик удаление товара из заказа, для действий статуса
Events::Get()->observe(
    'shopOrderProductDeleteBefore',
    'Action_Status_OrderProductDeleteBefore'
);

// Обработчик редактирования заказа, для действий статуса
Events::Get()->observe(
    'shopOrderEditAfter',
    'Action_Status_OrderEditAfter'
);

// Обработчик редактирования заказа, для действий статуса
Events::Get()->observe(
    'shopOrderEmployerUpdateAfter',
    'Action_Status_OrderEmployerUpdateAfter'
);

Events::Get()->observe(
    'buildActionBlock',
    'Shop_Action_Block_Build'
);

Engine::GetCache()->registerModifier('template', 'Shop_CacheModifierTemplate');