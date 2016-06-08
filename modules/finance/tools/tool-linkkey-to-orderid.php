<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$payments = new FinancePayment();
while ($x = $payments->getNext()) {
    if (preg_match("/^order-(\d+)$/ius", $x->getLinkkey(), $r)) {
        $x->setOrderid($r[1]);
        $x->update();
    }
}

print "\n\ndone.\n\n";