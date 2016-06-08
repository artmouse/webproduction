<?php
/**
 * OneBox
 * Очистить все UID чтобы парсер почты все начал вычитывать с начала.
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$uids = new XShopEventEmailUID();
$uids->delete(true);

print "\n\ndone.\n\n";