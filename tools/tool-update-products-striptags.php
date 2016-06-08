<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

// строим ЧПУ для всех товаров
$products = Shop::Get()->getShopService()->getProductsAll();
while ($x = $products->getNext()) {
    print "product ".$x->getId()."\n";
	try {
	    $x->setName(strip_tags($x->getName()));

	    $description = ($x->getDescription());
	    $description = str_replace("</p>", "\n\n", $description);
	    $description = str_replace("</P>", "\n\n", $description);
	    $description = str_replace(array("\t", "\r"), '', $description);
	    $description = str_replace("\n\n\n", "\n\n", $description);
	    $description = str_replace("&nbsp;", ' ', $description);
	    $description = strip_tags($description);
	    $description = nl2br($description);
	    $x->setDescription($description);

        $x->update();
	} catch (Exception $e) {

	}
}


print "\n\ndone.\n\n";