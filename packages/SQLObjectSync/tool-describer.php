<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Console-tool: SQLObjectSync Describer.
 * En: Generate SQLObjectSync defenition by exists database.
 * Ru: Генерит описание существующей БД
 *
 * example:
 *   php -f tool-describer.php mysqlhost mysqluser mysqlpass mysqldatabase SQLObjectConfig
 *
 * @author Max
 * @copyright WebProduction
 * @package SQLObjectSync
 */
if (count($argv) != 6) {
	print "Incorrent tool syntax. See manual.\n\n";
	exit();
}

mysql_connect($argv[1], $argv[2], $argv[3]);
mysql_select_db($argv[4]);

require(dirname(__FILE__).'/include.php');

print SQLObjectSync_Describer::Get($argv[5])->describeDatabase($argv[4]);

print "\n\n";