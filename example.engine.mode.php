<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * В этом файле определяются устанавливается режим работы Engine
 */

// список режимов и документация по ним доступна по ссылке
// https://box.webproduction.ua/doc/onebox-mode
// по умолчанию все отключите
// PackageLoader::Get()->setMode('build');
// PackageLoader::Get()->setMode('build-acl');
// PackageLoader::Get()->setMode('build-scss');
// PackageLoader::Get()->setMode('debug');
// PackageLoader::Get()->setMode('xdebug');
// PackageLoader::Get()->setMode('verbose');
// PackageLoader::Get()->setMode('check');
// PackageLoader::Get()->setMode('no-cache');
// PackageLoader::Get()->setMode('no-minify');

// Engine::Get()->enableErrorReporting();

// Engine::Get()->setConfigField('project-host', 'www.localhost');
// Engine::Get()->setConfigField('project-test', true);
//мобильный хост
/*Engine::Get()->setConfigField('mobile-host', 'm.localhost');*/


// часовой пояс проекта
// date_default_timezone_set('Asia/Almaty');

// помена пользователя для debug режима.
// В данном примере если я авторизирован под max, то система будет думать что я mzhunussov
// При этом mzhunussov не будет кикнут (выкинут из системы)
// Engine::Get()->setConfigField('user-sudo', array('max' => 'mzhunussov'));

/*

// connection to database
ConnectionManager::Get()->addConnectionDatabase(
new ConnectionManager_MySQLi(
'localhost',
'user',
'password',
'db'
));

*/

// подключение темы
// Engine::Get()->setConfigField('shop-template', 'mytheme');

// Задать размер картинки в карточке товара
//Engine::Get()->setConfigField('product-image-size', array(330, 225));

// подключение модулей
Engine::Get()->setConfigField('shop-module', array('quiz'));

// включение морды ИЕ
// Engine::Get()->setConfigField('oneclick-enable', true);

// брендирование сайта
// Engine::Get()->setConfigField('project-branding', 'Yazz');

// язык сайта по дефолту русский
// можно прописать en, ua, ru
//Engine::Get()->setConfigField('language-site', true);
//Engine::Get()->setConfigField('language-site', en);
//Engine::Get()->setConfigField('language-admin', ru);

// переопределение первых пунктов меню (до  модулей)
/*Engine::Get()->setConfigField('project-menu', array(
'/admin/shop/orders/' => 'Заказы',
'/admin/shop/orders/report/servicebusy/' => 'Сетка занятости',
'/admin/shop/users/' => 'Клиенты',
'/admin/shop/products/' => 'Продукты',
));*/

// автоматически переводить все английские фразы
// Engine::Get()->setConfigField('seo-transliterate-en2ru-auto', true);

// Искать телефоны по неточному совпадению
//Engine::Get()->setConfigField('phone-search-no-exact-match', true);
/*
// настройка форматов и мест баннеров.
// настройка перезатирает все стандартные баннера.
$a = array();
$a['place1'] = array(
'name' => 'Баннер на главной странице большой 900x300',
'width' => 900,
'height' => 300,
'method' => false, // prop / crop / false
);
$a['place2'] = array(
'name' => 'Баннер большой везде 900x400',
'width' => 900,
'height' => 400,
'method' => 'crop', // prop / crop / false
);
Engine::Get()->setConfigField('shop-banner-place', $a);
*/

// текст для модуля product-favorite
//Engine::Get()->setConfigField('isFavoriteText', 'В избранном');
//Engine::Get()->setConfigField('inFavoriteText', 'В избранное');

// группировка товаров по полю
//Engine::Get()->setConfigField('product-grouped', 'model');

// отключение smart ACL
// По умолчнию Smart ACL включен и дает полный доступ к задаче/проекту/заказу,
// если сотрудник является автором, ответственным или исполнителем.
//Engine::Get()->setConfigField('acl-smart-disabled', true);
// убрать исполнителей из списка
//Engine::Get()->setConfigField('acl-smart-employer-disabled', true);

// задать отправщик писем из базы в мир.
// по умолчанию используется стандартная функция mail()
// Можно указать строку, можно указать сразу объект (implements MailUtils_ISender)
// OneBox заменяет на свой умный отправщик.
Engine::Get()->setConfigField('mail-sender', 'MailUtils_SenderMail');

// старое меню
//Engine::Get()->setConfigField('static-shop-menu', true);

// в списке активных заказов, показывать только заказы где пользователь - ответсвенный(только для старого ордера)
//Engine::Get()->setConfigField('active-orders-to-manager', true);

// настройка парсера imap
/*$a = array();

$a[] = array(
'host' => 'mail.domain.com',
'username' => 'name@domain.com',
'password' => 'password',
);

Engine::Get()->setConfigField('project-box-event-parser-imap', $a);*/

// подключение pdf
// Engine::Get()->setConfigField('php-cgi-path', '/usr/bin/php');

// режим вывода в консоль ACL
//PackageLoader::Get()->setMode('acl-to-console');

// подключение к  AMI
/*$a = array();
$a['host'] = 'host';
$a['port'] = 5038;
$a['login'] = 'login';
$a['password'] = 'password';
Engine::Get()->setConfigField('asterisk-ami', $a);

// контексты входящих и исходящих звонков для Asterisk AMI
// по умолчанию office-calls и outgoing-calls
Engine::Get()->setConfigField('asterisk-ami-context-in', 'office-calls');
Engine::Get()->setConfigField('asterisk-ami-context-out', 'outgoing-calls');
*/

// включить окошко входящего звонка по AMI
//Engine::Get()->setConfigField('project-box-call-window', true);

// с каких емейлов создавать задачи в какие проекты
/*$a = array();
$a['mail@domain.com'] = array(
'workflowid' => 1,
'managerid' => 7,
'checkorder' => true,
);

Engine::Get()->setConfigField('project-box-event-to-issue', $a);*/

// лицензия
//Engine::Get()->setConfigField('box-key', '00000-00000-00000-00000');

// добавляет поле в блок информации в заказе(no box, shop only) read only
$a = array();
$a[] = array('name' => "Ориентировочная стоимость доставки", 'field' => 'novaposhtaprice', 'text' => 'грн.');
Engine::Get()->setConfigField('order-view-custom-field-block-info', $a);

// использовать шоповский кэш, таблица в БД shopCache
Engine::Get()->setConfigField('shop-cache', true);

// указать кастомный модуль(название папки в /modules/)
Engine::Get()->setConfigField('dependency-module', 'custom-megalink');