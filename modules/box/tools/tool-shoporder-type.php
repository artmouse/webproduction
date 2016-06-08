<?php
/**
 * OneBox
 * Изменить тип shoporder в соответствии с бизнес-процессом
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

$orders = new ShopOrder();
$orders->setOrder('id', 'DESC');
while ($x = $orders->getNext()) {
    print $x->getId()."\n";

    try {
        $workflow = $x->getWorkflow();

        $x->setType($workflow->getType());
        $x->update();
    } catch (Exception $e) {

    }
}

print 'done';