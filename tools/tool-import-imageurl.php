<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

Shop::Get()->getShopService()->importProductImageFromURLs(true);

print "\n\ndone.\n\n";