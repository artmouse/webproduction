<?php

set_time_limit(0);
include dirname(__FILE__)."/../../../packages/Engine/include.2.6.php";

$x = new Shop_CronImportProductsXML();
$event = new Events_Event();
$x->notify($event);

$x = new Shop_CronImportImages();
$x->notify($event);