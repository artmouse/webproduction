<?php

PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/service/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/system/');

// регистрируем события box'a
Events::Get()->addEvent(
    'boxEventAddAfter',
    'Box_Event_Event'
);

// дописываемся в cron
Events::Get()->observe(
    'afterCronHour',
    'Box_CronHour'
);

Events::Get()->observe(
    'afterCronMinute',
    'Box_CronMinute'
);

// обработчик после добавления заказа/задачи/проекта
Events::Get()->observe(
    'shopOrderAddAfter',
    'Box_Event_OrderAddAfter'
);

// события после изменения статуса
Events::Get()->observe(
    'shopOrderStatusUpdateAfter',
    'Box_Event_UpdateOrderStatus'
);

// после довавления события запускаем парсер box
Events::Get()->observe(
    'boxEventAddAfter',
    'Box_Event_EmailBoxParser'
);

// Box_KickMachine
Events::Get()->observe(
    'afterQueryDefine',
    'Box_KickMachine'
);

// превращение писем в задачи
Events::Get()->observe(
    'boxEventAddAfter',
    'Box_Event_Email2Issue'
);

// превращение звонков в задачи
Events::Get()->observe(
    'boxEventAddAfter',
    'Box_Event_Call2Issue'
);