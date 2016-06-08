#!/usr/bin/php
<?php
require(dirname(__FILE__).'/packages/PackageLoader/include.php');

PackageLoader::Get()->setMode('build-scss');

require(dirname(__FILE__).'/packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

print "\ndone.\n\n";