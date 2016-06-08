<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$products = Shop::Get()->getShopService()->getProductsAll();
while ($x = $products->getNext()) {
	for ($j = 1; $j <= 5; $j++) {
	    $supplierID = $x->getField('supplier'.$j.'id');
	    $supplierAvailtext = $x->getField('supplier'.$j.'availtext');

	    if (!$supplierID) {
	    	continue;
	    }

	    print $x->getId()."\n";
	    print $supplierAvailtext."\n";

	    $supplierAvail = 0;
	    if (preg_match("/в наличии/ius", $supplierAvailtext, $r)) {
	    	$supplierAvail = 1;
	    }
	    if (substr_count($supplierAvailtext, '+')) {
	    	$supplierAvail = 1;
	    }
	    if (preg_match("/есть/ius", $supplierAvailtext, $r)) {
	    	$supplierAvail = 1;
	    }
	    if (preg_match("/заканчивается/ius", $supplierAvailtext, $r)) {
	    	$supplierAvail = 1;
	    }
	    if (preg_match("/(\d+)/ius", $supplierAvailtext, $r)) {
	    	if ($r[1] > 0) {
	    		$supplierAvail = 1;
	    	}
	    }
	    if (preg_match("/нет/ius", $supplierAvailtext, $r)) {
	    	$supplierAvail = 0;
	    }
	    if (substr_count($supplierAvailtext, '-')) {
	    	$supplierAvail = 0;
	    }

	    print $supplierAvail."\n\n";

	    $x->setField('supplier'.$j.'avail', $supplierAvail);
	    $x->update();
	}
}

print "\n\ndone.\n\n";