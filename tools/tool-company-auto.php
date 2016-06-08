<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$company = Shop::Get()->getShopService()->getCompanyArray();
foreach ($company as $name) {
    print $name."\n";
	try {
	    $x = Shop::Get()->getShopService()->getCompanyByName($name);

	    print "ok\n";
	} catch (Exception $e) {
	    // компания не найдена
	    print "not found\n";

	    $tmp = new User();
	    $tmp->setCdate(date('Y-m-d H:i:s'));
	    $tmp->setTypesex('company');
	    $tmp->setAuthorid(1);
	    $tmp->setCompany($name);
	    $tmp->insert();
	}
}

print "\n\ndone.\n\n";