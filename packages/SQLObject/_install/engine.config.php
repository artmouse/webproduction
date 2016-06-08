<?php

// 1. задаем конфигурацию SQLObject'у
SQLObject_Config::Get()->setPathDatabaseClasses(PROJECT_PATH.'api/db/');

// описываем таблицу
$table = SQLObject_Config::Get()->addTable('mytable', 'XMyTable');
$table->addField('id', 'int(11)', 'auto_increment');
$table->addField('name', 'varchar(255)');
$table->addField('name2', 'varchar(100)');
$table->addField('type', "enum('type1','type2')");
$table->addKey('id', 'primary');

// если таблица уже есть - то все сделается само
SQLObject_Config::Get()->addTable('category', 'XCategory');

// описываем таблицу protocols
$table = SQLObject_Config::Get()->addTable('protocols', 'XProtocol');
$table->addField('gameid', 'int(11)');
$table->addField('cdate', 'datetime');
$table->addField('action', "enum('goal','autogoal','penalty','cardyellow','cardyellow2','cardred','change')");
$table->addField('comment', 'varchar(255)');
$table->addField('user1id', 'int(11)');
$table->addField('user2id', 'int(11)');
$table->addField('minute', 'int(5)');
$table->addField('teamid', 'int(11)');

// описываем таблицу roles
$table = SQLObject_Config::Get()->addTable('roles', 'XRole');
$table->addField('name', 'varchar(255)');
$table->addField('names', 'varchar(255)');
$table->addField('player', 'tinyint(1)');
$table->addField('protocol', 'tinyint(1)');

// comments
$table = SQLObject_Config::Get()->addTable('comments', 'XComments');
$table->addField('id', 'int(11)', 'auto_increment');
$table->addField('cdate', 'datetime');
$table->addField('text', 'text');
$table->addField('userid', 'int(11)');
$table->addField('parentid', 'int(11)');
$table->addField('key', 'varchar(255)');
$table->addKey('id', 'primary');

// 2. выполняем SQLObject Sync
SQLObject_Config::Get()->sync();