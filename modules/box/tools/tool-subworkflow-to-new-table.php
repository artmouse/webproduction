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

$status = new ShopOrderStatus();
while ($x = $status->getNext()) {
    for ($i=1; $i<=30; $i++) {
        $sub = new XShopOrderStatusSubWorkflow();
        $sub->setStatusid($x->getId());
        $sub->setSort($i);
        $sub->setSubworkflowid($x->getField('subworkflow'.$i));
        $sub->setSubworkflowname($x->getField('subworkflow'.$i.'name'));
        $sub->setSubworkflowdate($x->getField('subworkflow'.$i.'date'));
        $sub->setSubworkflowdescription($x->getField('subworkflow'.$i.'description'));
        $sub->insert();
    }
    print "insert ".$x->getId()."\n";
}
print 'done';