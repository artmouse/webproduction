<?php

require_once(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$statuses = WorkflowService::Get()->getStatusAll();
while ($status = $statuses->getNext()) {
    $block = new XShopOrderStatusActionBlockStructure();
    $block->setStatusid($status->getId());
    $block->setOrder('id');
    $index = 0;
    while ($x = $block->getNext()) {
        $index++;
        $x->setSort($index);
        $x->update();

        print "\nupdate block for status #".$status->getId();
    }
}

print "\n\ndone\n\n";